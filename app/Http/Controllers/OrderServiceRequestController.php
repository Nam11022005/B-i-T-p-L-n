<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderServiceRequest;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use App\Models\WalletTransaction;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderServiceRequestController extends Controller
{
    public function store(Request $request, Order $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);

        $data = $request->validate([
            'type' => ['required', 'in:cancel,refund'],
            'reason' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'reason.required' => 'Hãy cho shop biết lý do yêu cầu.',
            'reason.min' => 'Lý do cần có ít nhất 10 ký tự.',
        ]);

        if (OrderServiceRequest::where('order_id', $order->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'Đơn hàng đang có một yêu cầu chờ shop xử lý.');
        }

        if ($data['type'] === 'cancel' && !in_array($order->status, ['pending', 'confirmed'], true)) {
            return back()->with('error', 'Chỉ có thể gửi yêu cầu hủy khi đơn chưa được bàn giao vận chuyển.');
        }

        if ($data['type'] === 'refund' && !($order->status === 'delivered' && $order->payment_status === 'paid')) {
            return back()->with('error', 'Yêu cầu hoàn tiền chỉ áp dụng cho đơn đã giao và đã thanh toán.');
        }

        OrderServiceRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'status' => 'pending',
            'reason' => trim($data['reason']),
        ]);

        return back()->with('success', 'Đã gửi yêu cầu. Shop sẽ phản hồi trong thời gian sớm nhất.');
    }

    public function process(Request $request, OrderServiceRequest $orderServiceRequest)
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $statusChange = null;
        $customerToNotify = null;

        DB::transaction(function () use ($orderServiceRequest, $data, &$statusChange, &$customerToNotify) {
            $serviceRequest = OrderServiceRequest::query()
                ->whereKey($orderServiceRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($serviceRequest->status !== 'pending') {
                throw new \RuntimeException('Yêu cầu này đã được xử lý trước đó.');
            }

            $order = Order::query()
                ->whereKey($serviceRequest->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($data['decision'] === 'approved' && $serviceRequest->type === 'cancel') {
                $oldStatus = $this->approveCancellation($order, $serviceRequest->reason);
                $statusChange = ['old' => $oldStatus, 'new' => 'cancelled', 'order' => $order];
                $customerToNotify = $order->user;
            }

            if ($data['decision'] === 'approved' && $serviceRequest->type === 'refund') {
                $this->approveRefund($order, $serviceRequest->reason);
            }

            $serviceRequest->status = $data['decision'];
            $serviceRequest->admin_note = filled($data['admin_note'] ?? null) ? trim($data['admin_note']) : null;
            $serviceRequest->processed_by = Auth::id();
            $serviceRequest->processed_at = now();
            $serviceRequest->save();
        });

        if ($statusChange && $customerToNotify) {
            $customerToNotify->notify(new OrderStatusChangedNotification(
                $statusChange['order'],
                $statusChange['old'],
                $statusChange['new']
            ));
        }

        return back()->with('success', 'Đã xử lý yêu cầu của khách hàng.');
    }

    private function approveCancellation(Order $order, string $reason): string
    {
        if (!in_array($order->status, ['pending', 'confirmed'], true)) {
            throw new \RuntimeException('Đơn không còn đủ điều kiện để hủy theo yêu cầu này.');
        }

        $order->load('items');

        foreach ($order->items as $item) {
            $product = Product::query()->whereKey($item->product_id)->lockForUpdate()->first();
            if ($product) {
                $product->quantity = round((float) $product->quantity + (float) $item->quantity, 2);
                $product->save();
            }
        }

        if ($order->voucher_code) {
            $voucher = Voucher::query()->where('code', $order->voucher_code)->lockForUpdate()->first();
            if ($voucher && (int) $voucher->used_count > 0) {
                $voucher->decrement('used_count');
            }
        }

        if ($order->payment_method === 'bank' && $order->payment_status !== 'paid') {
            $order->payment_status = 'unpaid';
            $order->payment_expires_at = null;
        }

        if ($order->payment_status === 'paid') {
            $this->creditWalletRefund($order, 'Hoàn tiền đơn hàng #' . $order->id . ' theo yêu cầu hủy của khách hàng.');
        }

        $oldStatus = $order->status;
        $order->status = 'cancelled';
        $order->save();

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => 'cancelled',
            'title' => 'Đã duyệt yêu cầu hủy đơn',
            'note' => 'Lý do khách hàng: ' . $reason,
        ]);

        return $oldStatus;
    }

    private function approveRefund(Order $order, string $reason): void
    {
        if ($order->status !== 'delivered' || $order->payment_status !== 'paid') {
            throw new \RuntimeException('Đơn không còn đủ điều kiện để hoàn tiền.');
        }

        $this->creditWalletRefund($order, 'Hoàn tiền đơn hàng #' . $order->id . '. Lý do khách hàng: ' . $reason);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => 'delivered',
            'title' => 'Đã hoàn tiền về Ví Tinh Hoa',
            'note' => 'Lý do khách hàng: ' . $reason,
        ]);
    }

    private function creditWalletRefund(Order $order, string $description): void
    {
        if (WalletTransaction::where('order_id', $order->id)->where('type', 'refund')->exists()) {
            throw new \RuntimeException('Đơn hàng này đã được hoàn tiền trước đó.');
        }

        $customer = User::query()->whereKey($order->user_id)->lockForUpdate()->firstOrFail();
        $customer->wallet_balance = round((float) $customer->wallet_balance + (float) $order->total_price, 2);
        $customer->save();

        WalletTransaction::create([
            'user_id' => $customer->id,
            'order_id' => $order->id,
            'type' => 'refund',
            'status' => 'completed',
            'amount' => $order->total_price,
            'balance_after' => $customer->wallet_balance,
            'description' => $description,
        ]);
    }
}
