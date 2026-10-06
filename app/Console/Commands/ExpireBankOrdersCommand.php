<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\ExpireBankOrders;
use Illuminate\Console\Command;

class ExpireBankOrdersCommand extends Command
{
    protected $signature = 'orders:expire-bank';
    protected $description = 'Hủy đơn QR chưa thanh toán đã hết hạn và hoàn tồn kho';

    public function handle(ExpireBankOrders $service): int
    {
        $count = 0;
        Order::where('payment_method', 'bank')->where('payment_status', 'pending_confirmation')
            ->whereIn('status', ['pending', 'confirmed'])->where('payment_expires_at', '<=', now())
            ->select('id')->chunkById(100, function ($orders) use ($service, &$count) {
                foreach ($orders as $order) {
                    $count += (int) $service->expire($order->id);
                }
            });
        $this->info("Đã tự hủy {$count} đơn QR hết hạn.");
        return self::SUCCESS;
    }
}
