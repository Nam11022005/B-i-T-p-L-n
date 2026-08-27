<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class WelcomeController extends Controller
{
    /**
     * Trang chủ cửa hàng
     */
    public function index()
    {
        // Sản phẩm mới nhất
        $products = Product::with('category')
            ->latest()
            ->paginate(8);

        // Danh mục để hiển thị nhanh trên trang chủ
        $categories = Category::withCount('products')
            ->latest()
            ->take(6)
            ->get();

        // Một số sản phẩm nổi bật
        $featuredProducts = Product::with('category')
            ->where('quantity', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        // Thống kê đơn giản
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        return view(
            'welcome',
            compact(
                'products',
                'categories',
                'featuredProducts',
                'totalProducts',
                'totalCategories'
            )
        );
    }
}