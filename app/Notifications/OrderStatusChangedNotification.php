<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Order $order,
        protected string $oldStatus,
        protected string $newStatus
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $orderNumber = str_pad(
            (string) $this->order->id,
            6,
            '0',
            STR_PAD_LEFT
        );

        return [
            'type' => 'order_status_changed',
            'title' => $this->getTitle(),
            'message' => $this->getMessage($orderNumber),
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'status' => $this->newStatus,
            'url' => route('orders.index'),
        ];
    }

    private function getTitle(): string
    {
        return match ($this->newStatus) {
            'pending' => 'Đơn hàng đang chờ xác nhận',
            'confirmed' => 'Đơn hàng đã được xác nhận',
            'shipped' => 'Đơn hàng đang được giao',
            'delivered' => 'Giao hàng thành công',
            'cancelled' => 'Đơn hàng đã bị hủy',
            default => 'Trạng thái đơn hàng đã thay đổi',
        };
    }

    private function getMessage(string $orderNumber): string
    {
        return match ($this->newStatus) {
            'pending' =>
                "Đơn hàng #{$orderNumber} đang chờ cửa hàng xác nhận.",

            'confirmed' =>
                "Đơn hàng #{$orderNumber} đã được cửa hàng xác nhận và đang được chuẩn bị.",

            'shipped' =>
                "Đơn hàng #{$orderNumber} đang được giao đến bạn.",

            'delivered' =>
                "Đơn hàng #{$orderNumber} đã được giao thành công.",

            'cancelled' =>
                "Đơn hàng #{$orderNumber} đã bị hủy.",

            default =>
                "Trạng thái đơn hàng #{$orderNumber} vừa được cập nhật.",
        };
    }
}
