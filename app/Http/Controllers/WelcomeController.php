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
        // Chỉ tính đơn đã giao thành công.
        // Không có dữ liệu bán thì section sẽ tự ẩn ở Blade.
        // =====================================================
        $bestSellingProducts = Product::with('category')
            ->withSoldQuantity()
            ->having('sold_quantity', '>', 0)
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
