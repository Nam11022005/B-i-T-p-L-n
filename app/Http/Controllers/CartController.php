<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
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
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {

            $cart[$product->id]['quantity']++;

        } else {

            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'category' => $product->category?->name ?? 'Chưa phân loại',
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }


    // ==========================================
    // CẬP NHẬT SỐ LƯỢNG
    // ==========================================

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {

            return redirect()
                ->route('cart.index')
                ->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $cart[$id]['quantity'] = (int) $request->quantity;

        session()->put('cart', $cart);
        session()->save();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Giỏ hàng đã được cập nhật!');
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
            ->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
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


    // ==========================================
    // TÍNH TẠM TÍNH
    // ==========================================

    $subtotal = 0;

    foreach ($cart as $item) {

        $subtotal +=
            $item['price']
            *
            $item['quantity'];
    }


    // ==========================================
    // TẠO MÃ THANH TOÁN RIÊNG CHO ĐƠN
    // ==========================================

    $paymentCode =
        session('payment_code');


    /*
     * Nếu chưa có mã trong session
     * thì tạo mã mới.
     */
    if (!$paymentCode) {

        do {

            $paymentCode =
                'PN' .
                strtoupper(
                    Str::random(8)
                );

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


    return view(
        'cart.checkout',
        compact(
            'cart',
            'subtotal',
            'paymentCode'
        )
    );
}


    // ==========================================
    // XỬ LÝ ĐẶT HÀNG
    // ==========================================

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',

            'customer_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s]{9,20}$/'
            ],

            'shipping_address' => 'required|string|max:500',

            'notes' => 'nullable|string|max:1000',

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
                ->with('error', 'Giỏ hàng đang trống.');
        }


        // ==========================================
        // TÍNH TIỀN HÀNG
        // ==========================================

        $subtotal = 0;

        foreach ($cart as $item) {

            $subtotal +=
                $item['price'] * $item['quantity'];
        }


        // ==========================================
        // TÍNH PHÍ VẬN CHUYỂN
        // ==========================================

        $shippingFees = [

            'standard' => 25000,

            'fast' => 35000,

            'express' => 50000,
        ];

        $shippingFee =
            $shippingFees[$request->shipping_method];


        // ==========================================
        // TÍNH VOUCHER
        // ==========================================

        $discount = 0;

        $voucherCode = null;

        if ($request->filled('voucher_code')) {

            $voucherCode =
                strtoupper(trim($request->voucher_code));


            /*
             * Voucher demo cho đồ án
             *
             * SHOPEE10 = giảm 10%
             * FREESHIP = giảm 25.000 phí ship
             * GIAM50K = giảm 50.000
             */

            if ($voucherCode === 'SHOPEE10') {

                $discount = $subtotal * 0.10;

            } elseif ($voucherCode === 'FREESHIP') {

                $discount = min(
                    25000,
                    $shippingFee
                );

            } elseif ($voucherCode === 'GIAM50K') {

                $discount = min(
                    50000,
                    $subtotal
                );

            } else {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Mã giảm giá không hợp lệ.'
                    );
            }
        }


        // ==========================================
        // TỔNG THANH TOÁN
        // ==========================================

        $totalPrice =
            $subtotal
            + $shippingFee
            - $discount;


        // Không cho tổng tiền âm
        if ($totalPrice < 0) {
            $totalPrice = 0;
        }


        // ==========================================
        // TẠO ĐƠN HÀNG
        // ==========================================

        DB::beginTransaction();

        try {

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
            // TẠO CHI TIẾT ĐƠN HÀNG
            // ==========================================

            foreach ($cart as $productId => $item) {

                OrderItem::create([

                    'order_id' =>
                        $order->id,

                    'product_id' =>
                        $productId,

                    'quantity' =>
                        $item['quantity'],

                    'price' =>
                        $item['price'],
                ]);
            }


            // ==========================================
            // XÓA GIỎ HÀNG
            // ==========================================

       session()->forget([
    'cart',
    'payment_code',
]);


            DB::commit();


            // ==========================================
            // CHUYỂN SANG ĐƠN HÀNG
            // ==========================================

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
}