<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Notifications\NewOrderNotification;
use App\Notifications\LowStockNotification;

class CartController extends Controller
{
    // ==========================================
    // HÀM PHỤ
    // ==========================================

    /**
     * Kiểm tra số lượng mua có đúng bước tăng hay không.
     * Ví dụ min = 0.25, step = 0.25:
     * 0.25, 0.50, 0.75, 1.00... là hợp lệ.
     */
    private function isValidStep(
        float $quantity,
        float $minQuantity,
        float $step
    ): bool {
        if ($quantity < $minQuantity || $step <= 0) {
            return false;
        }

        $steps = ($quantity - $minQuantity) / $step;

        return abs($steps - round($steps)) < 0.00001;
    }

    private function normalizeQuantity(float $quantity): float
    {
        return round($quantity, 2);
    }

    // ==========================================
    // GIỎ HÀNG
    // ==========================================

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    // ==========================================
    // THÊM SẢN PHẨM
    // ==========================================

    public function add(Request $request, Product $product)
    {
        $minQuantity = (float) ($product->min_quantity ?? 1);
        $step = (float) ($product->quantity_step ?? 1);
        $stock = (float) $product->quantity;

        $requestedQuantity = $request->input(
            'quantity',
            $minQuantity
        );

        if (!is_numeric($requestedQuantity)) {
            return back()->with(
                'error',
                'Số lượng mua không hợp lệ.'
            );
        }

        $requestedQuantity = $this->normalizeQuantity(
            (float) $requestedQuantity
        );

        if (!$this->isValidStep(
            $requestedQuantity,
            $minQuantity,
            $step
        )) {
            return back()->with(
                'error',
                'Số lượng phải từ ' .
                $minQuantity . ' ' .
                ($product->unit ?? 'sản phẩm') .
                ' và tăng theo bước ' .
                $step . '.'
            );
        }

        if ($requestedQuantity > $stock) {
            return back()->with(
                'error',
                'Số lượng bạn chọn vượt quá tồn kho.'
            );
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $this->normalizeQuantity(
                (float) $cart[$product->id]['quantity']
                + $requestedQuantity
            );

            if ($newQuantity > $stock) {
                return back()->with(
                    'error',
                    'Tổng số lượng trong giỏ vượt quá tồn kho.'
                );
            }

            $cart[$product->id]['quantity'] = $newQuantity;

            // Luôn đồng bộ dữ liệu quan trọng từ DB
            $cart[$product->id]['price'] = $product->getCurrentPrice();
            $cart[$product->id]['unit'] = $product->unit ?? 'sản phẩm';
            $cart[$product->id]['min_quantity'] = $minQuantity;
            $cart[$product->id]['quantity_step'] = $step;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $requestedQuantity,
                'price' => $product->getCurrentPrice(),
                'category' => $product->category?->name ?? 'Chưa phân loại',
                'unit' => $product->unit ?? 'sản phẩm',
                'min_quantity' => $minQuantity,
                'quantity_step' => $step,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Sản phẩm đã được thêm vào giỏ hàng.'
            );
    }

    // ==========================================
    // CẬP NHẬT SỐ LƯỢNG
    // ==========================================

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Sản phẩm không tồn tại trong giỏ hàng.'
                );
        }

        $product = Product::find($id);

        if (!$product) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Sản phẩm không còn tồn tại.'
                );
        }

        $quantity = $this->normalizeQuantity(
            (float) $request->quantity
        );

        $minQuantity = (float) ($product->min_quantity ?? 1);
        $step = (float) ($product->quantity_step ?? 1);
        $stock = (float) $product->quantity;

        if (!$this->isValidStep(
            $quantity,
            $minQuantity,
            $step
        )) {
            return back()->with(
                'error',
                'Số lượng phải từ ' .
                $minQuantity . ' ' .
                ($product->unit ?? 'sản phẩm') .
                ' và tăng theo bước ' .
                $step . '.'
            );
        }

        if ($quantity > $stock) {
            return back()->with(
                'error',
                'Số lượng vượt quá tồn kho hiện tại.'
            );
        }

        $cart[$id]['quantity'] = $quantity;

        // Không tin giá trong session cũ, đồng bộ lại giá DB
        $cart[$id]['price'] = $product->getCurrentPrice();
        $cart[$id]['unit'] = $product->unit ?? 'sản phẩm';
        $cart[$id]['min_quantity'] = $minQuantity;
        $cart[$id]['quantity_step'] = $step;

        session()->put('cart', $cart);
        session()->save();

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Giỏ hàng đã được cập nhật!'
            );
    }

    // ==========================================
    // XÓA SẢN PHẨM
    // ==========================================

    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);

            session()->put('cart', $cart);
            session()->save();
        }

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Sản phẩm đã được xóa khỏi giỏ hàng.'
            );
    }

    // ==========================================
    // TRANG THANH TOÁN
    // ==========================================

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Giỏ hàng đang trống.'
                );
        }

        $subtotal = 0;

        /*
         * Tính lại giá từ database để tránh việc
         * giá trong session bị sửa.
         */
        foreach ($cart as $productId => &$item) {
            $product = Product::find($productId);

            if (!$product) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Có sản phẩm trong giỏ không còn tồn tại.'
                    );
            }

            $quantity = (float) $item['quantity'];

            if ($quantity > (float) $product->quantity) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Sản phẩm "' .
                        $product->name .
                        '" không đủ tồn kho.'
                    );
            }

            $item['price'] = $product->getCurrentPrice();
            $item['unit'] = $product->unit ?? 'sản phẩm';
            $item['min_quantity'] =
                (float) ($product->min_quantity ?? 1);
            $item['quantity_step'] =
                (float) ($product->quantity_step ?? 1);

            $subtotal +=
                $product->getCurrentPrice() * $quantity;
        }

        unset($item);

        session()->put('cart', $cart);

        $paymentCode = session('payment_code');

        if (!$paymentCode) {
            do {
                $paymentCode =
                    'PN' .
                    strtoupper(Str::random(8));
            } while (
                Order::where(
                    'payment_code',
                    $paymentCode
                )->exists()
            );

            session()->put(
                'payment_code',
                $paymentCode
            );
        }
        $availableVouchers = Voucher::where('is_active', true)
    ->where(function ($query) {
        $query->whereNull('starts_at')
            ->orWhere('starts_at', '<=', now());
    })
    ->where(function ($query) {
        $query->whereNull('expires_at')
            ->orWhere('expires_at', '>=', now());
    })
    ->where(function ($query) {
        $query->whereNull('usage_limit')
            ->orWhereColumn('used_count', '<', 'usage_limit');
    })
    ->orderBy('min_order_value')
    ->get();

        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view(
    'cart.checkout',
    compact(
        'cart',
        'subtotal',
        'paymentCode',
        'availableVouchers',
        'addresses'
    )
);
    }

    // ==========================================
    // XỬ LÝ ĐẶT HÀNG
    // ==========================================

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' =>
                'required|string|max:255',

            'customer_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s]{9,20}$/'
            ],

            'shipping_address' =>
                'required|string|max:500',

            'notes' =>
                'nullable|string|max:1000',

            'shipping_method' =>
                'required|in:standard,fast,express',

            'payment_method' =>
                'required|in:cod,bank',

            'voucher_code' =>
                'nullable|string|max:50',
        ], [
            'customer_name.required' =>
                'Vui lòng nhập họ tên.',

            'customer_phone.required' =>
                'Vui lòng nhập số điện thoại.',

            'customer_phone.regex' =>
                'Số điện thoại không hợp lệ.',

            'shipping_address.required' =>
                'Vui lòng nhập địa chỉ giao hàng.',

            'shipping_method.required' =>
                'Vui lòng chọn phương thức vận chuyển.',

            'payment_method.required' =>
                'Vui lòng chọn phương thức thanh toán.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Giỏ hàng đang trống.'
                );
        }

        // ==========================================
        // KIỂM TRA LẠI SẢN PHẨM + TÍNH TIỀN HÀNG
        // ==========================================

        $subtotal = 0;
        $productsForOrder = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                return back()->with(
                    'error',
                    'Có sản phẩm không còn tồn tại.'
                );
            }

            $quantity = $this->normalizeQuantity(
                (float) $item['quantity']
            );

            $minQuantity =
                (float) ($product->min_quantity ?? 1);

            $step =
                (float) ($product->quantity_step ?? 1);

            if (!$this->isValidStep(
                $quantity,
                $minQuantity,
                $step
            )) {
                return back()->with(
                    'error',
                    'Số lượng của "' .
                    $product->name .
                    '" không hợp lệ.'
                );
            }

            if ($quantity > (float) $product->quantity) {
                return back()->with(
                    'error',
                    'Sản phẩm "' .
                    $product->name .
                    '" không đủ tồn kho.'
                );
            }

            // Giá luôn lấy từ DB
            $price = $product->getCurrentPrice();

            $subtotal += $price * $quantity;

            $productsForOrder[$productId] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // ==========================================
        // PHÍ VẬN CHUYỂN
        // ==========================================

        $shippingFees = [
            'standard' => 25000,
            'fast' => 35000,
            'express' => 50000,
        ];

        $shippingFee =
            $shippingFees[$request->shipping_method];

        // ==========================================
        // VOUCHER
        // ==========================================

$discount = 0;
$voucherCode = null;
$voucher = null;


if ($request->filled('voucher_code')) {

    $voucherCode =
        strtoupper(
            trim($request->voucher_code)
        );


    $voucher = Voucher::where(
        'code',
        $voucherCode
    )->first();


    if (!$voucher) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Mã giảm giá không tồn tại.'
            );
    }


    if (!$voucher->isAvailable()) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Voucher đã hết hạn, hết lượt hoặc đang bị tắt.'
            );
    }


    if (
        $subtotal
        <
        (float) $voucher->min_order_value
    ) {

        return back()
            ->withInput()
            ->with(
                'error',

                'Đơn hàng phải đạt tối thiểu ' .

                number_format(
                    $voucher->min_order_value,
                    0,
                    ',',
                    '.'
                )

                .

                'đ để sử dụng voucher này.'
            );
    }


    $discount = $this->calculateVoucherDiscount(
        $voucher,
        $subtotal,
        $shippingFee
    );
}

        // ==========================================
        // TỔNG THANH TOÁN
        // ==========================================

        $totalPrice =
            $subtotal
            + $shippingFee
            - $discount;

        if ($totalPrice < 0) {
            $totalPrice = 0;
        }

        // ==========================================
        // TẠO ĐƠN HÀNG
        // ==========================================

        // Danh sách sản phẩm cần kiểm tra cảnh báo tồn kho
        // sau khi đơn hàng được commit thành công.
        $orderedProductIds = array_keys($productsForOrder);

        DB::beginTransaction();

        try {
            /*
             * Lock lại các sản phẩm trước khi trừ kho
             * để tránh 2 người mua cùng lúc vượt tồn kho.
             */
            foreach ($productsForOrder as $productId => &$data) {
                $lockedProduct =
                    Product::whereKey($productId)
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    $data['quantity']
                    > (float) $lockedProduct->quantity
                ) {
                    throw new \Exception(
                        'Sản phẩm "' .
                        $lockedProduct->name .
                        '" không đủ tồn kho.'
                    );
                }

                $data['product'] = $lockedProduct;
                $data['price'] =
                    $lockedProduct->getCurrentPrice();
            }

            unset($data);

            /*
             * Giá có thể vừa thay đổi trước thời điểm đặt hàng,
             * vì vậy tính subtotal lại sau khi lock.
             */
            $subtotal = 0;

            foreach ($productsForOrder as $data) {
                $subtotal +=
                    $data['price']
                    * $data['quantity'];
            }

            // ==========================================
            // KIỂM TRA + LOCK VOUCHER
            // ==========================================
            $discount = 0;

            if ($voucher) {
                $voucher = Voucher::whereKey($voucher->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$voucher->isAvailable()) {
                    throw new \Exception(
                        'Voucher vừa hết lượt hoặc không còn hiệu lực.'
                    );
                }

                if (
                    $subtotal <
                    (float) $voucher->min_order_value
                ) {
                    throw new \Exception(
                        'Đơn hàng không đủ giá trị tối thiểu để sử dụng voucher.'
                    );
                }

                $discount = $this->calculateVoucherDiscount(
                    $voucher,
                    $subtotal,
                    $shippingFee
                );
            }

            $totalPrice =
                $subtotal
                + $shippingFee
                - $discount;

            if ($totalPrice < 0) {
                $totalPrice = 0;
            }

            $order = Order::create([
                'user_id' => Auth::id(),

                'customer_name' =>
                    $request->customer_name,

                'customer_phone' =>
                    $request->customer_phone,

                'shipping_address' =>
                    $request->shipping_address,

                'notes' =>
                    $request->notes,

                'subtotal' =>
                    $subtotal,

                'shipping_fee' =>
                    $shippingFee,

                'discount' =>
                    $discount,

                'total_price' =>
                    $totalPrice,

                'status' =>
                    'pending',

                'payment_method' =>
                    $request->payment_method,

                'payment_status' =>
                    $request->payment_method === 'bank'
                        ? 'pending_confirmation'
                        : 'unpaid',

                'payment_code' =>
                    $request->payment_method === 'bank'
                        ? session('payment_code')
                        : null,

                'shipping_method' =>
                    $request->shipping_method,

                'voucher_code' =>
                    $voucherCode,
            ]);
            // ==========================================
// TIMELINE - ĐƠN HÀNG ĐƯỢC TẠO
// ==========================================
OrderStatusHistory::create([

    'order_id' =>
        $order->id,

    'user_id' =>
        Auth::id(),

    'status' =>
        'pending',

    'title' =>
        'Đơn hàng đã được tạo',

    'note' =>
        'Khách hàng đã đặt hàng thành công. Đơn hàng đang chờ cửa hàng xác nhận.',

]);

            // ==========================================
            // CHI TIẾT ĐƠN + TRỪ TỒN KHO
            // ==========================================

            foreach (
                $productsForOrder
                as $productId => $data
            ) {
                OrderItem::create([
                    'order_id' =>
                        $order->id,

                    'product_id' =>
                        $productId,

                    'quantity' =>
                        $data['quantity'],

                    'price' =>
                        $data['price'],
                ]);

                $data['product']->decrement(
                    'quantity',
                    $data['quantity']
                );
            }

            // ==========================================
            // TĂNG LƯỢT SỬ DỤNG VOUCHER
            // ==========================================
            if ($voucher) {
                $voucher->increment('used_count');
            }

            session()->forget([
                'cart',
                'payment_code',
            ]);

            DB::commit();

            // ==========================================
            // 🔔 THÔNG BÁO ĐƠN HÀNG MỚI CHO ADMIN
            // ==========================================
            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(
                    new NewOrderNotification($order)
                );
            }


            // ==========================================
            // ⚠️ CẢNH BÁO SẢN PHẨM SẮP HẾT / HẾT HÀNG
            // ==========================================
            foreach ($orderedProductIds as $productId) {

                $stockProduct = Product::find($productId);

                if (!$stockProduct) {
                    continue;
                }

                $currentStock =
                    (float) $stockProduct->quantity;

                $minQuantity =
                    (float) ($stockProduct->min_quantity ?? 1);

                /*
                 * Quy tắc cảnh báo:
                 *
                 * quantity <= 0
                 * => hết hàng
                 *
                 * quantity <= min_quantity * 5
                 * => sắp hết hàng
                 */
                $alertLevel = null;

                if ($currentStock <= 0) {
                    $alertLevel = 'out_of_stock';
                } elseif (
                    $currentStock
                    <=
                    ($minQuantity * 5)
                ) {
                    $alertLevel = 'low_stock';
                }

                // Tồn kho vẫn an toàn => không gửi cảnh báo.
                if ($alertLevel === null) {
                    continue;
                }

                foreach ($admins as $admin) {

                    /*
                     * Chống spam:
                     * Nếu Admin đã có một notification CHƯA ĐỌC
                     * cho cùng sản phẩm và cùng mức cảnh báo
                     * thì không tạo thêm notification giống hệt.
                     *
                     * Khi Admin đọc notification cũ và sản phẩm
                     * tiếp tục giảm xuống mức cảnh báo ở đơn sau,
                     * hệ thống có thể tạo một cảnh báo mới.
                     */
                    $duplicateNotificationExists =
                        $admin
                            ->unreadNotifications()
                            ->where(
                                'data->type',
                                'low_stock'
                            )
                            ->where(
                                'data->product_id',
                                $stockProduct->id
                            )
                            ->where(
                                'data->alert_level',
                                $alertLevel
                            )
                            ->exists();

                    if ($duplicateNotificationExists) {
                        continue;
                    }

                    $admin->notify(
                        new LowStockNotification(
                            $stockProduct,
                            $alertLevel
                        )
                    );
                }
            }


            if ($order->payment_method === 'bank') {
                return redirect()
                    ->route('orders.show', $order->id)
                    ->with(
                        'success',
                        'Đơn hàng đã được tạo. Vui lòng quét QR và chuyển khoản đúng số tiền, đúng nội dung.'
                    );
            }

            return redirect()
                ->route('orders.index')
                ->with(
                    'success',
                    'Đặt hàng thành công! Mã đơn hàng #' .
                    $order->id
                );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Đặt hàng thất bại: ' .
                    $e->getMessage()
                );
        }
    }

    // ==========================================
    // TÍNH GIÁ TRỊ GIẢM CỦA VOUCHER
    // ==========================================
    private function calculateVoucherDiscount(
        Voucher $voucher,
        float $subtotal,
        float $shippingFee
    ): float {
        $discount = 0;

        if ($voucher->type === 'percent') {
            $percent = min((float) $voucher->value, 100);

            $discount = $subtotal * ($percent / 100);

            if ($voucher->max_discount !== null) {
                $discount = min(
                    $discount,
                    (float) $voucher->max_discount
                );
            }
        } elseif ($voucher->type === 'fixed') {
            $discount = min(
                (float) $voucher->value,
                $subtotal
            );

            if ($voucher->max_discount !== null) {
                $discount = min(
                    $discount,
                    (float) $voucher->max_discount
                );
            }
        } elseif ($voucher->type === 'shipping') {
            $discount = min(
                (float) $voucher->value,
                $shippingFee
            );

            if ($voucher->max_discount !== null) {
                $discount = min(
                    $discount,
                    (float) $voucher->max_discount
                );
            }
        }

        return round(
            max($discount, 0),
            2
        );
    }

}
