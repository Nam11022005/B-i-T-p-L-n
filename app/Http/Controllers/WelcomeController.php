<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        // =====================================================
        // SẢN PHẨM MỚI
        // Có kèm số lượng đã bán của đơn giao thành công
        // =====================================================
        $products = Product::with('category')
            ->withSoldQuantity()
            ->latest()
            ->paginate(8);

        // =====================================================
        // TOÀN BỘ DANH MỤC
        // =====================================================
        $categories = Category::withCount('products')
            ->latest()
            ->get();

        // =====================================================
        // ⭐ SẢN PHẨM NỔI BẬT DO ADMIN GHIM
        // =====================================================
        $featuredProducts = Product::with('category')
            ->withSoldQuantity()
            ->where('is_featured', true)
            ->latest('updated_at')
            ->take(8)
            ->get();

        // =====================================================
        // 🔥 TOP SẢN PHẨM BÁN CHẠY
        // Chỉ tính sản phẩm thuộc đơn đã giao thành công.
        //
        // whereHas() dùng để loại sản phẩm chưa bán.
        // withSoldQuantity() vẫn tính tổng số lượng đã bán.
        //
        // Cách này tương thích cả MySQL và SQLite khi test.
        // =====================================================
        $bestSellingProducts = Product::with('category')
            ->withSoldQuantity()
            ->whereHas('orderItems', function ($query) {
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->where('status', 'delivered');
                });
            })
            ->orderByDesc('sold_quantity')
            ->take(8)
            ->get();

        // =====================================================
        // THỐNG KÊ
        // =====================================================
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // =====================================================
        // TRẢ DỮ LIỆU RA TRANG CHỦ
        // =====================================================
        return view(
            'welcome',
            compact(
                'products',
                'categories',
                'featuredProducts',
                'bestSellingProducts',
                'totalProducts',
                'totalCategories'
            )
        );
    }
}