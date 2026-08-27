<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // ==========================================
    // USER - DANH SÁCH ĐƠN HÀNG CỦA MÌNH
    // ==========================================
    public function index()
    {
        $query = Order::with('items.product')
            ->where('user_id', Auth::id());

        // Lọc theo trạng thái
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $orders = $query
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
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

        $totalRevenue = $orders
            ->where('status', 'delivered')
            ->sum('total_price');

        $totalOrders = $orders->count();

        $totalProducts = Product::count();

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
            'user'
        ]);

        return view(
            'admin.orders.show',
            compact('order')
        );
    }


    // ==========================================
    // ADMIN - CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
    // ==========================================
    public function updateStatus(
        Request $request,
        Order $order
    ) {
        $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,shipped,delivered,cancelled'
            ],
        ], [
            'status.required' => 'Vui lòng chọn trạng thái đơn hàng.',
            'status.in' => 'Trạng thái đơn hàng không hợp lệ.',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with(
                'success',
                'Cập nhật trạng thái đơn hàng #' .
                str_pad($order->id, 6, '0', STR_PAD_LEFT) .
                ' thành công!'
            );
    }
    // ==========================================
// ADMIN - XÁC NHẬN THANH TOÁN
// ==========================================
public function confirmPayment(Order $order)
{
    if ($order->payment_method !== 'bank') {

        return back()->with(
            'error',
            'Đơn hàng này không sử dụng phương thức chuyển khoản.'
        );
    }


    $order->payment_status = 'paid';

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
            ) . 'Thành công!'
        );
}
}