<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatusHistory;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ==========================================
    // USER - DANH SÁCH ĐƠN HÀNG CỦA MÌNH
    // ==========================================
    public function index()
{
    $userId = Auth::id();

    // ==========================================
    // TỔNG SỐ ĐƠN HÀNG CỦA KHÁCH
    // Không bị ảnh hưởng bởi phân trang / bộ lọc
    // ==========================================
    $totalOrders = Order::where('user_id', $userId)->count();

    // Tổng đơn đang giao
    $totalShipped = Order::where('user_id', $userId)
        ->where('status', 'shipped')
        ->count();

    // Tổng đơn đã giao
    $totalDelivered = Order::where('user_id', $userId)
        ->where('status', 'delivered')
        ->count();

    // ==========================================
    // DANH SÁCH ĐƠN HÀNG
    // ==========================================
    $query = Order::with([
        'items.product',
        'statusHistories.user'
    ])
    ->where('user_id', $userId);

    // Lọc theo trạng thái
    if (request('status')) {
        $query->where('status', request('status'));
    }

    // Mỗi trang 5 đơn
    $orders = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view('orders.index', compact(
        'orders',
        'totalOrders',
        'totalShipped',
        'totalDelivered'
    ));
}


    // ==========================================
    // USER - XEM CHI TIẾT ĐƠN HÀNG
    // ==========================================
    public function showCustomer(Order $order)
    {
        // User chỉ được xem đơn hàng của chính mình
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $order->load([
            'items.product',
            'statusHistories.user'
        ]);

        return view(
            'orders.show',
            compact('order')
        );
    }


    // ==========================================
    // USER - KIỂM TRA TRẠNG THÁI THANH TOÁN
    // Dùng cho giao diện tự cập nhật sau khi webhook xác nhận.
    // ==========================================
    public function paymentStatus(Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        return response()->json([
            'paid' => $order->payment_status === 'paid',
            'payment_status' => $order->payment_status,
            'order_id' => $order->id,
        ]);
    }


    // ==========================================
    // ADMIN - DANH SÁCH TẤT CẢ ĐƠN HÀNG
    // ==========================================
    public function adminIndex()
    {
        $orders = Order::with([
                'items.product',
                'user'
            ])
            ->latest()
            ->get();


        // Chỉ tính đơn giao thành công
        $totalRevenue = $orders
            ->where(
                'status',
                'delivered'
            )
            ->sum('total_price');


        $totalOrders =
            $orders->count();


        $totalProducts =
            Product::count();


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


    // ==========================================
    // ADMIN - XEM CHI TIẾT ĐƠN HÀNG
    // ==========================================
   public function show(Order $order)
{
    $order->load([
        'items.product',
        'user',
        'statusHistories.user'
    ]);


    return view(
        'admin.orders.show',
        compact('order')
    );
}


    // ==========================================
    // ADMIN - CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
    // + TỰ ĐỘNG HOÀN / TRỪ TỒN KHO
    // ==========================================
    public function updateStatus(
        Request $request,
        Order $order
    ) {
        // ==========================================
        // VALIDATE
        // ==========================================
        $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,shipped,delivered,cancelled'
            ],
        ], [
            'status.required' =>
                'Vui lòng chọn trạng thái đơn hàng.',

            'status.in' =>
                'Trạng thái đơn hàng không hợp lệ.',
        ]);


        $newStatus =
            $request->status;


        DB::beginTransaction();


        try {

            // ==========================================
            // KHÓA ĐƠN HÀNG
            // ==========================================
            $lockedOrder = Order::whereKey(
                    $order->id
                )
                ->lockForUpdate()
                ->firstOrFail();


            $oldStatus =
                $lockedOrder->status;


            // Không thay đổi gì nếu status giống nhau
            if ($oldStatus === $newStatus) {

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


            // Load sản phẩm trong đơn
            $lockedOrder->load(
                'items.product'
            );


            // ==========================================
            // TRƯỜNG HỢP 1:
            // ĐƠN CHUYỂN SANG CANCELLED
            //
            // => HOÀN TỒN KHO
            // ==========================================
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


                    /*
                     * Nếu sản phẩm đã bị Admin xóa,
                     * bỏ qua thay vì làm lỗi toàn bộ đơn.
                     */
                    if (!$product) {
                        continue;
                    }


                    $currentStock =
                        (float)
                        $product->quantity;


                    $returnQuantity =
                        (float)
                        $item->quantity;


                    $product->quantity =
                        round(
                            $currentStock
                            +
                            $returnQuantity,
                            2
                        );


                    $product->save();
                }
            }


            // ==========================================
            // TRƯỜNG HỢP 2:
            // ĐƠN ĐANG CANCELLED
            // NHƯNG ADMIN CHUYỂN LẠI TRẠNG THÁI KHÁC
            //
            // => PHẢI TRỪ KHO LẠI
            // ==========================================
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
                        $product->quantity;


                    $requiredQuantity =
                        (float)
                        $item->quantity;


                    // Không đủ hàng để mở lại đơn
                    if (
                        $requiredQuantity
                        >
                        $currentStock
                    ) {

                        throw new \Exception(
                            'Không đủ tồn kho để khôi phục đơn. Sản phẩm "' .
                            $product->name .
                            '" chỉ còn ' .
                            $this->formatQuantity(
                                $currentStock
                            ) .
                            ' ' .
                            ($product->unit ?? 'sản phẩm') .
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
            }


            // ==========================================
            // CẬP NHẬT STATUS
            // ==========================================
           $lockedOrder->status =
    $newStatus;


$lockedOrder->save();


// ==========================================
// GHI LỊCH SỬ TRẠNG THÁI
// ==========================================
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


            // ==========================================
            // 🔔 THÔNG BÁO CHO KHÁCH HÀNG
            // Chỉ gửi sau khi transaction đã commit thành công
            // ==========================================
            $lockedOrder->loadMissing('user');

            if ($lockedOrder->user) {
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

                    'Cập nhật trạng thái đơn hàng #' .

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
                    'Không thể cập nhật đơn hàng: ' .
                    $e->getMessage()
                );
        }
    }


    // ==========================================
    // ADMIN - XÁC NHẬN THANH TOÁN
    // ==========================================
    public function confirmPayment(
        Order $order
    ) {
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


        // Đã xác nhận rồi thì không làm lại
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


        $order->payment_status =
            'paid';


        $order->save();


        return redirect()
            ->route(
                'admin.orders.show',
                $order->id
            )
            ->with(
                'success',

                '✅ Đã xác nhận thanh toán cho đơn hàng #' .

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


    // ==========================================
    // HÀM HIỂN THỊ SỐ LƯỢNG ĐẸP
    //
    // 1.00   => 1
    // 0.50   => 0.5
    // 0.25   => 0.25
    // ==========================================
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
    // ==========================================
// TIÊU ĐỀ TRẠNG THÁI
// ==========================================
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


// ==========================================
// GHI CHÚ TIMELINE
// ==========================================
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