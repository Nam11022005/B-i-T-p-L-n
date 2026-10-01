<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\OrderStatusHistory;
use App\Notifications\OrderStatusChangedNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER - DANH SÁCH ĐƠN HÀNG
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $userId = Auth::id();


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA CÁC ĐƠN QR ĐÃ HẾT 5 PHÚT
        |--------------------------------------------------------------------------
        */

        $expiredOrders = Order::query()
            ->where(
                'user_id',
                $userId
            )
            ->where(
                'payment_method',
                'bank'
            )
            ->where(
                'payment_status',
                'pending_confirmation'
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->whereNotNull(
                'payment_expires_at'
            )
            ->where(
                'payment_expires_at',
                '<=',
                now()
            )
            ->get();


        foreach ($expiredOrders as $expiredOrder) {

            $this->expireBankPaymentIfNeeded(
                $expiredOrder
            );
        }


        /*
        |--------------------------------------------------------------------------
        | THỐNG KÊ
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::where(
            'user_id',
            $userId
        )->count();


        $totalShipped = Order::where(
            'user_id',
            $userId
        )
            ->where(
                'status',
                'shipped'
            )
            ->count();


        $totalDelivered = Order::where(
            'user_id',
            $userId
        )
            ->where(
                'status',
                'delivered'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | DANH SÁCH ĐƠN
        |--------------------------------------------------------------------------
        */

        $query = Order::with([
            'items.product',
            'statusHistories.user',
        ])
            ->where(
                'user_id',
                $userId
            );


        if (request('status')) {

            $query->where(
                'status',
                request('status')
            );
        }


        $orders = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();


        return view(
            'orders.index',
            compact(
                'orders',
                'totalOrders',
                'totalShipped',
                'totalDelivered'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - CHI TIẾT ĐƠN HÀNG
    |--------------------------------------------------------------------------
    */

    public function showCustomer(
        Order $order
    ) {

        /*
        |--------------------------------------------------------------------------
        | CHỈ CHỦ ĐƠN ĐƯỢC XEM
        |--------------------------------------------------------------------------
        */

        if (
            (int) $order->user_id
            !==
            (int) Auth::id()
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA HẾT HẠN QR
        |--------------------------------------------------------------------------
        */

        $this->expireBankPaymentIfNeeded(
            $order
        );


        /*
        |--------------------------------------------------------------------------
        | LẤY LẠI DỮ LIỆU MỚI NHẤT
        |--------------------------------------------------------------------------
        */

        $order->refresh();


        $order->load([
            'items.product',
            'statusHistories.user',
        ]);


        return view(
            'orders.show',
            compact(
                'order'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - KIỂM TRA TRẠNG THÁI THANH TOÁN
    |--------------------------------------------------------------------------
    |
    | Javascript tại trang QR sẽ gọi route này mỗi vài giây.
    |
    | Khi hết 5 phút:
    |
    | - Hủy đơn
    | - Hoàn tồn kho
    | - Hoàn voucher
    |
    */

    public function paymentStatus(
        Order $order
    ) {

        /*
        |--------------------------------------------------------------------------
        | BẢO MẬT
        |--------------------------------------------------------------------------
        */

        if (
            (int) $order->user_id
            !==
            (int) Auth::id()
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA HẾT HẠN
        |--------------------------------------------------------------------------
        */

        $this->expireBankPaymentIfNeeded(
            $order
        );


        $order->refresh();


        /*
        |--------------------------------------------------------------------------
        | SỐ GIÂY CÒN LẠI
        |--------------------------------------------------------------------------
        */

        $remainingSeconds = 0;


        if (
            $order->payment_method === 'bank'
            &&
            $order->payment_status === 'pending_confirmation'
            &&
            $order->status !== 'cancelled'
            &&
            $order->payment_expires_at
        ) {

            $remainingSeconds = max(
                0,
                (int) now()->diffInSeconds(
                    $order->payment_expires_at,
                    false
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | JSON CHO JAVASCRIPT
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'order_id' =>
                $order->id,

            'paid' =>
                $order->payment_status === 'paid',

            'cancelled' =>
                $order->status === 'cancelled',

            'status' =>
                $order->status,

            'payment_status' =>
                $order->payment_status,

            'payment_expires_at' =>
                $order->payment_expires_at
                    ? $order
                        ->payment_expires_at
                        ->toIso8601String()
                    : null,

            'remaining_seconds' =>
                $remainingSeconds,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - DANH SÁCH ĐƠN HÀNG
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        /*
        |--------------------------------------------------------------------------
        | TỰ HỦY CÁC ĐƠN QR HẾT HẠN
        |--------------------------------------------------------------------------
        */

        $expiredOrders = Order::query()
            ->where(
                'payment_method',
                'bank'
            )
            ->where(
                'payment_status',
                'pending_confirmation'
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->whereNotNull(
                'payment_expires_at'
            )
            ->where(
                'payment_expires_at',
                '<=',
                now()
            )
            ->get();


        foreach ($expiredOrders as $expiredOrder) {

            $this->expireBankPaymentIfNeeded(
                $expiredOrder
            );
        }


        /*
        |--------------------------------------------------------------------------
        | THỐNG KÊ
        |--------------------------------------------------------------------------
        */

        $totalRevenue = Order::where(
            'status',
            'delivered'
        )->sum(
            'total_price'
        );


        $totalOrders =
            Order::count();


        $totalProducts =
            Product::count();


        /*
        |--------------------------------------------------------------------------
        | DANH SÁCH
        |--------------------------------------------------------------------------
        */

        $orders = Order::with([
            'items.product',
            'user',
        ])
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'admin.orders.index',
            compact(
                'orders',
                'totalRevenue',
                'totalOrders',
                'totalProducts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - CHI TIẾT ĐƠN
    |--------------------------------------------------------------------------
    */

    public function show(
        Order $order
    ) {

        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA HẾT HẠN QR TRƯỚC KHI HIỂN THỊ
        |--------------------------------------------------------------------------
        */

        $this->expireBankPaymentIfNeeded(
            $order
        );


        $order->refresh();


        $order->load([
            'items.product',
            'user',
            'statusHistories.user',
        ]);


        return view(
            'admin.orders.show',
            compact(
                'order'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - CẬP NHẬT TRẠNG THÁI
    |--------------------------------------------------------------------------
    |
    | Có xử lý:
    |
    | - Hủy đơn => hoàn tồn kho
    | - Mở lại đơn đã hủy => trừ kho lại
    |
    */

    public function updateStatus(
        Request $request,
        Order $order
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'status' => [
                    'required',
                    'in:pending,confirmed,shipped,delivered,cancelled',
                ],
            ],
            [
                'status.required' =>
                    'Vui lòng chọn trạng thái đơn hàng.',

                'status.in' =>
                    'Trạng thái đơn hàng không hợp lệ.',
            ]
        );


        $newStatus =
            $request->status;


        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | LOCK ĐƠN
            |--------------------------------------------------------------------------
            */

            $lockedOrder = Order::whereKey(
                $order->id
            )
                ->lockForUpdate()
                ->firstOrFail();


            $oldStatus =
                $lockedOrder->status;


            /*
            |--------------------------------------------------------------------------
            | KHÔNG THAY ĐỔI
            |--------------------------------------------------------------------------
            */

            if (
                $oldStatus
                ===
                $newStatus
            ) {

                DB::commit();


                return redirect()
                    ->route(
                        'admin.orders.show',
                        $lockedOrder->id
                    )
                    ->with(
                        'success',
                        'Trạng thái đơn hàng không thay đổi.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | LOAD ITEMS
            |--------------------------------------------------------------------------
            */

            // Check the locked row so stale admin forms cannot reopen a delivered order.
            if ($oldStatus === 'delivered') {
                throw new \RuntimeException(
                    'Đơn hàng đã giao thành công và đã khóa trạng thái. Không thể chuyển sang trạng thái khác.'
                );
            }

            $lockedOrder->load(
                'items.product'
            );


            /*
            |--------------------------------------------------------------------------
            | CHUYỂN SANG CANCELLED
            |--------------------------------------------------------------------------
            |
            | Checkout đã trừ kho từ lúc tạo đơn.
            | Vì vậy khi hủy phải hoàn lại.
            |
            */

            if (
                $newStatus === 'cancelled'
                &&
                $oldStatus !== 'cancelled'
            ) {

                foreach (
                    $lockedOrder->items
                    as
                    $item
                ) {

                    $product =
                        Product::whereKey(
                            $item->product_id
                        )
                            ->lockForUpdate()
                            ->first();


                    if (!$product) {
                        continue;
                    }


                    $currentStock =
                        (float)
                            $product
                                ->quantity;


                    $returnQuantity =
                        (float)
                            $item
                                ->quantity;


                    $product->quantity =
                        round(
                            $currentStock
                            +
                            $returnQuantity,
                            2
                        );


                    $product->save();
                }


                /*
                |--------------------------------------------------------------------------
                | NẾU HỦY ĐƠN ĐANG CHỜ QR
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedOrder->payment_method
                    ===
                    'bank'
                    &&
                    $lockedOrder->payment_status
                    !==
                    'paid'
                ) {

                    $lockedOrder->payment_status =
                        'unpaid';


                    $lockedOrder->payment_expires_at =
                        null;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ĐƠN CANCELLED ĐƯỢC ADMIN MỞ LẠI
            |--------------------------------------------------------------------------
            |
            | Phải trừ kho lại.
            |
            */

            if (
                $oldStatus === 'cancelled'
                &&
                $newStatus !== 'cancelled'
            ) {

                foreach (
                    $lockedOrder->items
                    as
                    $item
                ) {

                    $product =
                        Product::whereKey(
                            $item->product_id
                        )
                            ->lockForUpdate()
                            ->first();


                    if (!$product) {

                        throw new \Exception(
                            'Không thể khôi phục đơn vì một sản phẩm không còn tồn tại.'
                        );
                    }


                    $currentStock =
                        (float)
                            $product
                                ->quantity;


                    $requiredQuantity =
                        (float)
                            $item
                                ->quantity;


                    if (
                        $requiredQuantity
                        >
                        $currentStock
                    ) {

                        throw new \Exception(
                            'Không đủ tồn kho để khôi phục đơn. Sản phẩm "'
                            .
                            $product->name
                            .
                            '" chỉ còn '
                            .
                            $this->formatQuantity(
                                $currentStock
                            )
                            .
                            ' '
                            .
                            (
                                $product->unit
                                ??
                                'sản phẩm'
                            )
                            .
                            '.'
                        );
                    }


                    $product->quantity =
                        round(
                            $currentStock
                            -
                            $requiredQuantity,
                            2
                        );


                    $product->save();
                }


                /*
                |--------------------------------------------------------------------------
                | NẾU LÀ ĐƠN BANK CHƯA THANH TOÁN
                |--------------------------------------------------------------------------
                |
                | Admin mở lại đơn:
                | cấp lại thời hạn QR mới 5 phút.
                |
                */

                if (
                    $lockedOrder->payment_method
                    ===
                    'bank'
                    &&
                    $lockedOrder->payment_status
                    !==
                    'paid'
                ) {

                    $lockedOrder->payment_status =
                        'pending_confirmation';


                    $lockedOrder->payment_expires_at =
                        now()->addMinutes(
                            config(
                                'payment.bank_timeout_minutes',
                                5
                            )
                        );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | CẬP NHẬT STATUS
            |--------------------------------------------------------------------------
            */

            $lockedOrder->status =
                $newStatus;


            $lockedOrder->save();


            /*
            |--------------------------------------------------------------------------
            | TIMELINE
            |--------------------------------------------------------------------------
            */

            OrderStatusHistory::create([

                'order_id' =>
                    $lockedOrder->id,

                'user_id' =>
                    Auth::id(),

                'status' =>
                    $newStatus,

                'title' =>
                    $this->getStatusTitle(
                        $newStatus
                    ),

                'note' =>
                    $this->getStatusNote(
                        $newStatus
                    ),

            ]);


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | THÔNG BÁO CUSTOMER
            |--------------------------------------------------------------------------
            */

            $lockedOrder->loadMissing(
                'user'
            );


            if (
                $lockedOrder->user
            ) {

                $lockedOrder->user->notify(
                    new OrderStatusChangedNotification(
                        $lockedOrder,
                        $oldStatus,
                        $newStatus
                    )
                );
            }


            return redirect()
                ->route(
                    'admin.orders.show',
                    $lockedOrder->id
                )
                ->with(
                    'success',

                    'Cập nhật trạng thái đơn hàng #'
                    .
                    str_pad(
                        $lockedOrder->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    )
                    .
                    ' thành công!'
                );

        } catch (\Exception $e) {

            DB::rollBack();


            return redirect()
                ->route(
                    'admin.orders.show',
                    $order->id
                )
                ->with(
                    'error',
                    'Không thể cập nhật đơn hàng: '
                    .
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - XÁC NHẬN THANH TOÁN
    |--------------------------------------------------------------------------
    */

    public function confirmPayment(
        Order $order
    ) {

        /*
        |--------------------------------------------------------------------------
        | CHỈ ÁP DỤNG BANK
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_method
            !==
            'bank'
        ) {

            return back()->with(
                'error',
                'Đơn hàng này không sử dụng phương thức chuyển khoản.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA HẾT 5 PHÚT
        |--------------------------------------------------------------------------
        */

        $this->expireBankPaymentIfNeeded(
            $order
        );


        $order->refresh();


        /*
        |--------------------------------------------------------------------------
        | ĐƠN ĐÃ BỊ HỦY
        |--------------------------------------------------------------------------
        */

        if (
            $order->status
            ===
            'cancelled'
        ) {

            return back()->with(
                'error',
                'Không thể xác nhận thanh toán vì đơn hàng đã bị hủy hoặc đã hết thời gian thanh toán.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ĐÃ THANH TOÁN
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_status
            ===
            'paid'
        ) {

            return back()->with(
                'success',
                'Đơn hàng này đã được xác nhận thanh toán trước đó.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | XÁC NHẬN
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use ($order) {

                $lockedOrder =
                    Order::whereKey(
                        $order->id
                    )
                        ->lockForUpdate()
                        ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | KIỂM TRA LẠI SAU KHI LOCK
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedOrder->status
                    ===
                    'cancelled'
                ) {

                    throw new \Exception(
                        'Đơn hàng đã bị hủy.'
                    );
                }


                if (
                    $lockedOrder->payment_status
                    ===
                    'paid'
                ) {
                    return;
                }


                if (
                    $lockedOrder->payment_expires_at
                    &&
                    now()->greaterThanOrEqualTo(
                        $lockedOrder
                            ->payment_expires_at
                    )
                ) {

                    throw new \Exception(
                        'Đơn hàng đã hết thời gian thanh toán.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | THANH TOÁN THÀNH CÔNG
                |--------------------------------------------------------------------------
                */

                $lockedOrder->payment_status =
                    'paid';


                /*
                 * Đã thanh toán thì không cần
                 * thời gian đếm ngược nữa.
                 */

                $lockedOrder->payment_expires_at =
                    null;


                $lockedOrder->save();
            }
        );


        return redirect()
            ->route(
                'admin.orders.show',
                $order->id
            )
            ->with(
                'success',

                '✅ Đã xác nhận thanh toán cho đơn hàng #'
                .
                str_pad(
                    $order->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                )
                .
                ' thành công!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TỰ HỦY ĐƠN QR HẾT HẠN
    |--------------------------------------------------------------------------
    |
    | Điều kiện:
    |
    | payment_method = bank
    | payment_status = pending_confirmation
    | status = pending / confirmed
    | payment_expires_at <= now()
    |
    | Khi hủy:
    |
    | - status = cancelled
    | - payment_status = unpaid
    | - hoàn tồn kho
    | - hoàn lượt voucher
    | - tạo timeline
    |
    */

    private function expireBankPaymentIfNeeded(
        Order $order
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA NHANH TRƯỚC TRANSACTION
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_method
            !==
            'bank'
        ) {
            return false;
        }


        if (
            $order->payment_status
            !==
            'pending_confirmation'
        ) {
            return false;
        }


        if (
            $order->status
            ===
            'cancelled'
        ) {
            return false;
        }


        if (
            !$order->payment_expires_at
        ) {
            return false;
        }


        if (
            $order->payment_expires_at
                ->isFuture()
        ) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use ($order) {

                /*
                |--------------------------------------------------------------------------
                | LOCK ĐƠN
                |--------------------------------------------------------------------------
                */

                $lockedOrder =
                    Order::whereKey(
                        $order->id
                    )
                        ->lockForUpdate()
                        ->first();


                if (!$lockedOrder) {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | KIỂM TRA LẠI SAU KHI LOCK
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedOrder->payment_method
                    !==
                    'bank'
                ) {
                    return false;
                }


                if (
                    $lockedOrder->payment_status
                    !==
                    'pending_confirmation'
                ) {
                    return false;
                }


                if (
                    $lockedOrder->status
                    ===
                    'cancelled'
                ) {
                    return false;
                }


                /*
                 * Chỉ tự hủy đơn chưa bắt đầu giao.
                 */

                if (
                    !in_array(
                        $lockedOrder->status,
                        [
                            'pending',
                            'confirmed',
                        ],
                        true
                    )
                ) {
                    return false;
                }


                if (
                    !$lockedOrder
                        ->payment_expires_at
                ) {
                    return false;
                }


                if (
                    $lockedOrder
                        ->payment_expires_at
                        ->isFuture()
                ) {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | LOAD ITEMS
                |--------------------------------------------------------------------------
                */

                $lockedOrder->load(
                    'items'
                );


                /*
                |--------------------------------------------------------------------------
                | HOÀN TỒN KHO
                |--------------------------------------------------------------------------
                */

                foreach (
                    $lockedOrder->items
                    as
                    $item
                ) {

                    $product =
                        Product::whereKey(
                            $item->product_id
                        )
                            ->lockForUpdate()
                            ->first();


                    if (!$product) {
                        continue;
                    }


                    $currentStock =
                        (float)
                            $product
                                ->quantity;


                    $returnQuantity =
                        (float)
                            $item
                                ->quantity;


                    $product->quantity =
                        round(
                            $currentStock
                            +
                            $returnQuantity,
                            2
                        );


                    $product->save();
                }


                /*
                |--------------------------------------------------------------------------
                | HOÀN LƯỢT VOUCHER
                |--------------------------------------------------------------------------
                */

                if (
                    !empty(
                        $lockedOrder
                            ->voucher_code
                    )
                ) {

                    $voucher =
                        Voucher::where(
                            'code',
                            $lockedOrder
                                ->voucher_code
                        )
                            ->lockForUpdate()
                            ->first();


                    if (
                        $voucher
                        &&
                        (int) $voucher->used_count
                        >
                        0
                    ) {

                        $voucher->decrement(
                            'used_count'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | HỦY ĐƠN
                |--------------------------------------------------------------------------
                */

                $lockedOrder->status =
                    'cancelled';


                $lockedOrder->payment_status =
                    'unpaid';


                /*
                 * Giữ payment_expires_at
                 * để giao diện biết thời gian đã hết.
                 */

                $lockedOrder->save();


                /*
                |--------------------------------------------------------------------------
                | TIMELINE
                |--------------------------------------------------------------------------
                */

                OrderStatusHistory::create([

                    'order_id' =>
                        $lockedOrder->id,

                    'user_id' =>
                        $lockedOrder->user_id,

                    'status' =>
                        'cancelled',

                    'title' =>
                        'Đơn hàng tự động bị hủy',

                    'note' =>
                        'Đơn hàng đã quá thời hạn 5 phút nhưng hệ thống chưa nhận được thanh toán chuyển khoản.',

                ]);


                return true;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT SỐ LƯỢNG
    |--------------------------------------------------------------------------
    */

    private function formatQuantity(
        float $quantity
    ): string {

        return rtrim(
            rtrim(
                number_format(
                    $quantity,
                    2,
                    '.',
                    ''
                ),
                '0'
            ),
            '.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TIÊU ĐỀ TRẠNG THÁI
    |--------------------------------------------------------------------------
    */

    private function getStatusTitle(
        string $status
    ): string {

        return match ($status) {

            'pending' =>
                'Đơn hàng đang chờ xác nhận',

            'confirmed' =>
                'Đơn hàng đã được xác nhận',

            'shipped' =>
                'Đơn hàng đang được giao',

            'delivered' =>
                'Giao hàng thành công',

            'cancelled' =>
                'Đơn hàng đã bị hủy',

            default =>
                'Trạng thái đơn hàng đã thay đổi',

        };
    }


    /*
    |--------------------------------------------------------------------------
    | GHI CHÚ TIMELINE
    |--------------------------------------------------------------------------
    */

    private function getStatusNote(
        string $status
    ): string {

        return match ($status) {

            'pending' =>
                'Đơn hàng đang chờ cửa hàng xử lý.',

            'confirmed' =>
                'Cửa hàng đã xác nhận và đang chuẩn bị đơn hàng.',

            'shipped' =>
                'Đơn hàng đã được bàn giao cho đơn vị vận chuyển.',

            'delivered' =>
                'Đơn hàng đã được giao thành công đến khách hàng.',

            'cancelled' =>
                'Đơn hàng đã được hủy và tồn kho đã được hoàn lại.',

            default =>
                '',

        };
    }
}