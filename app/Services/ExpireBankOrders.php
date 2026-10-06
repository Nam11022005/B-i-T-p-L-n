<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class ExpireBankOrders
{
    public function expire(int $orderId): bool
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::whereKey($orderId)->lockForUpdate()->first();
            if (!$order || $order->payment_method !== 'bank'
                || $order->payment_status !== 'pending_confirmation'
                || !in_array($order->status, ['pending', 'confirmed'], true)
                || !$order->payment_expires_at || $order->payment_expires_at->isFuture()) {
                return false;
            }
            foreach ($order->items()->orderBy('product_id')->get() as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();
                if ($product) {
                    $product->quantity = round((float) $product->quantity + (float) $item->quantity, 2);
                    $product->save();
                }
            }
            if ($order->voucher_code) {
                $voucher = Voucher::where('code', $order->voucher_code)->lockForUpdate()->first();
                if ($voucher && $voucher->used_count > 0) {
                    $voucher->decrement('used_count');
                }
            }
            $order->status = 'cancelled';
            $order->payment_status = 'unpaid';
            $order->save();
            OrderStatusHistory::create([
                'order_id' => $order->id, 'user_id' => $order->user_id, 'status' => 'cancelled',
                'title' => 'Đơn hàng tự động bị hủy',
                'note' => 'Đã hết thời hạn thanh toán QR; hệ thống chưa ghi nhận thanh toán. Đã hoàn tồn kho và lượt dùng voucher.',
            ]);
            return true;
        }, 3);
    }
}
