<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ==========================================
    // 🔔 USER - ĐỌC MỘT THÔNG BÁO
    // ==========================================
    public function read(string $notification)
    {
        $user = Auth::user();

        $notificationItem = $user
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($notificationItem->read_at)) {
            $notificationItem->markAsRead();
        }

        $data = $notificationItem->data ?? [];

        // Notification trạng thái đơn hàng:
        // sau khi đọc sẽ đưa khách về danh sách đơn hàng của chính mình.
        if (!empty($data['order_id'])) {
            $orderExists = Order::whereKey($data['order_id'])
                ->where('user_id', $user->id)
                ->exists();

            if ($orderExists) {
                return redirect()
                    ->route('orders.index');
            }
        }

        if (!empty($data['url'])) {
            return redirect()->to($data['url']);
        }

        return redirect()
            ->route('orders.index');
    }


    // ==========================================
    // 🔔 USER - ĐÁNH DẤU TẤT CẢ ĐÃ ĐỌC
    // ==========================================
    public function readAll(Request $request)
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back()->with(
            'success',
            'Đã đánh dấu tất cả thông báo là đã đọc.'
        );
    }
}
