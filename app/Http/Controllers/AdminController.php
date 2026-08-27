<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD ADMIN
    // ==========================================
    public function dashboard()
    {
        // Tổng sản phẩm
        $totalProducts = Product::count();

        // Tổng danh mục
        $totalCategories = Category::count();

        // Tổng đơn hàng
        $totalOrders = Order::count();

        // Chỉ tính doanh thu từ đơn đã giao thành công
        $totalRevenue = Order::where(
            'status',
            'delivered'
        )->sum('total_price');

        // Đơn đang chờ xác nhận
        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        // Đơn đang giao
        $shippingOrders = Order::where(
            'status',
            'shipped'
        )->count();

        // Đơn đã giao
        $deliveredOrders = Order::where(
            'status',
            'delivered'
        )->count();

        // Đơn đã hủy
        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();

        // 5 đơn mới nhất
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'totalCategories',
                'totalOrders',
                'totalRevenue',
                'pendingOrders',
                'shippingOrders',
                'deliveredOrders',
                'cancelledOrders',
                'recentOrders'
            )
        );
    }


    // ==========================================
    // HỒ SƠ ADMIN
    // ==========================================
    public function profile()
    {
        $admin = Auth::user();

        return view(
            'admin.profile',
            compact('admin')
        );
    }
}