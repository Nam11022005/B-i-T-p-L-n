<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_order',

            'title' => 'Đơn hàng mới',

            'message' =>
                'Có đơn hàng mới #' . $this->order->id
                . ' với tổng tiền '
                . number_format($this->order->total_price, 0, ',', '.')
                . 'đ.',

            'order_id' => $this->order->id,

            'url' => route(
                'admin.orders.show',
                $this->order->id
            ),
        ];
    }
}