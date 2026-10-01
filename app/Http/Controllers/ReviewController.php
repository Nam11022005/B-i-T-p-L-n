<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (Auth::user()->role === 'admin') {
            return back()->with('error', 'Tài khoản Admin không thể đánh giá sản phẩm.');
        }

        $request->validate(
            [
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ],
            [
                'rating.required' => 'Vui lòng chọn số sao đánh giá.',
                'rating.integer' => 'Số sao không hợp lệ.',
                'rating.min' => 'Đánh giá tối thiểu là 1 sao.',
                'rating.max' => 'Đánh giá tối đa là 5 sao.',
                'comment.max' => 'Nội dung đánh giá tối đa 1000 ký tự.',
            ]
        );

        // Chỉ khách đã nhận hàng thành công mới được đánh giá.
$hasPurchased = DB::table('orders')
    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
    ->where('orders.user_id', Auth::id())
    ->where('order_items.product_id', $product->id)
    ->where('orders.status', 'delivered')
    ->exists();

        if (!$hasPurchased) {
            return back()->with(
                'error',
              'Bạn chỉ có thể đánh giá sản phẩm sau khi đơn hàng đã được giao thành công.'
            );
        }

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', '⭐ Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Đã xóa đánh giá.');
    }
}
