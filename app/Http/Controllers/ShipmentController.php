<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShipmentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ShipmentController extends Controller
{
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'shipping_carrier' => ['required', 'string', 'max:100'],
            'tracking_number' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\pN._\-\/ ]+$/u'],
            'shipment_status' => ['required', Rule::in(array_keys(ShipmentEvent::STATUSES))],
            'estimated_delivery_at' => ['nullable', 'date_format:Y-m-d'],
            'location' => ['nullable', 'string', 'max:150'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'shipping_carrier' => 'đơn vị giao hàng', 'tracking_number' => 'mã vận đơn',
            'shipment_status' => 'trạng thái giao hàng', 'estimated_delivery_at' => 'ngày giao dự kiến',
            'location' => 'vị trí', 'note' => 'ghi chú',
        ]);

        DB::transaction(function () use ($order, $request, $data) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if (in_array($locked->status, ['cancelled', 'delivered'], true)) {
                throw ValidationException::withMessages(['shipment_status' => 'Đơn đã kết thúc, không thể cập nhật vận chuyển.']);
            }
            if ($data['shipment_status'] !== 'preparing' && $locked->status !== 'shipped') {
                throw ValidationException::withMessages(['shipment_status' => 'Hãy chuyển đơn sang Đang giao hàng trước khi cập nhật hành trình vận chuyển.']);
            }
            if ($data['shipment_status'] !== 'preparing' && empty(trim($data['tracking_number'] ?? ''))) {
                throw ValidationException::withMessages(['tracking_number' => 'Vui lòng nhập mã vận đơn hoặc mã giao hàng nội bộ.']);
            }
            foreach (['shipping_carrier', 'tracking_number', 'shipment_status', 'estimated_delivery_at'] as $key) {
                $locked->{$key} = $data[$key] ?? null;
            }
            if (!$locked->isDirty() && empty($data['note']) && empty($data['location'])) return;
            $locked->save();
            $locked->shipmentEvents()->create([
                'user_id' => $request->user()->id,
                'status' => $data['shipment_status'],
                'carrier' => $data['shipping_carrier'],
                'tracking_number' => $data['tracking_number'] ?? null,
                'location' => $data['location'] ?? null,
                'note' => $data['note'] ?? null,
            ]);
        });

        return redirect()->route('admin.orders.show', $order)->with('success', 'Đã cập nhật thông tin giao hàng.');
    }
}
