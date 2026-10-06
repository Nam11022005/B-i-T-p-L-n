@php
    $shipmentAdmin = $shipmentAdmin ?? false;
    $shipmentEvents = $order->shipmentEvents;
    $shipmentClosed = in_array($order->status, ['delivered', 'cancelled'], true);
@endphp
<section class="shipment-panel" aria-labelledby="shipment-heading">
    <style>
        .shipment-panel{max-width:1320px;margin:24px auto;padding:24px;border:1px solid #e3d9c9;border-radius:18px;background:#fffdf8;color:#302e27}
        .shipment-panel header{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
        .shipment-panel h2{font-size:21px;margin:0;font-weight:750}.shipment-panel .ship-kicker{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:#777464;margin-bottom:5px}
        .shipment-panel .ship-badge{background:#eaf0e3;color:#355331;border-radius:30px;padding:8px 14px;font-size:13px;font-weight:650}
        .shipment-panel .ship-summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;padding-bottom:20px;border-bottom:1px solid #e3d9c9}
        .shipment-panel dt{font-size:12px;font-weight:400;color:#787568;margin-bottom:6px}.shipment-panel dd{margin:0;font-weight:650;overflow-wrap:anywhere}
        .shipment-panel .ship-number{font-family:monospace;user-select:all;font-size:17px}.shipment-panel .ship-hint{font-size:12px;color:#787568;margin:12px 0}
        .shipment-panel details{margin-top:18px}.shipment-panel summary{cursor:pointer;font-weight:650;padding:8px 0}
        .shipment-panel .ship-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:14px}
        .shipment-panel label{display:block;font-size:13px;margin-bottom:5px}.shipment-panel input,.shipment-panel select,.shipment-panel textarea{width:100%;border:1px solid #d9d0bf;border-radius:8px;padding:10px;background:#fff;color:#302e27}
        .shipment-panel .ship-wide{grid-column:1/-1}.shipment-panel .ship-save{border:0;border-radius:8px;background:#355331;color:#fff;padding:11px 20px;margin-top:14px;font-weight:650}
        .shipment-panel .ship-timeline{list-style:none;padding:0;margin:16px 0 0}.shipment-panel .ship-timeline li{position:relative;margin-left:6px;padding:0 0 18px 23px;border-left:1px solid #d3ddca}.shipment-panel .ship-timeline li:before{content:'';position:absolute;left:-5px;top:5px;width:9px;height:9px;border-radius:50%;background:#638454}.shipment-panel .ship-timeline p{margin:4px 0;font-size:14px;overflow-wrap:anywhere}.shipment-panel time{font-size:12px;color:#787568}.shipment-panel .ship-error{color:#ae3429;font-size:13px;margin-top:6px}
        @media(max-width:700px){.shipment-panel{margin:16px 12px;padding:18px}.shipment-panel header{align-items:flex-start;flex-direction:column}.shipment-panel .ship-summary,.shipment-panel .ship-fields{grid-template-columns:1fr;gap:12px}}
    </style>
    <header>
        <div><div class="ship-kicker">Theo dõi đơn #{{ $order->id }}</div><h2 id="shipment-heading">Thông tin giao hàng</h2></div>
        <span class="ship-badge">{{ $order->shipmentLabel() }}</span>
    </header>
    <dl class="ship-summary">
        <div><dt>Đơn vị giao hàng</dt><dd>{{ $order->shipping_carrier ?: 'Chưa được chỉ định' }}</dd></div>
        <div><dt>Mã vận đơn</dt><dd class="ship-number">{{ $order->tracking_number ?: 'Chưa có mã vận đơn' }}</dd></div>
        <div><dt>Ngày giao dự kiến</dt><dd>{{ $order->estimated_delivery_at?->format('d/m/Y') ?? 'Đang chờ cập nhật' }}</dd></div>
    </dl>
    <p class="ship-hint">Thông tin do cửa hàng cập nhật. Bạn có thể chọn mã vận đơn để sao chép.</p>
    @if($shipmentAdmin && !$shipmentClosed)
        <details @if($errors->any()) open @endif>
            <summary>Cập nhật vận đơn và hành trình</summary>
            <form method="POST" action="{{ route('admin.orders.shipment.update', $order) }}">
                @csrf @method('PATCH')
                <div class="ship-fields">
                    <div><label for="shipping_carrier">Đơn vị giao hàng *</label><input id="shipping_carrier" name="shipping_carrier" list="ship-carriers" maxlength="100" required value="{{ old('shipping_carrier', $order->shipping_carrier) }}" placeholder="Chọn hoặc nhập đơn vị giao hàng"><datalist id="ship-carriers"><option value="Giao Hàng Nhanh"><option value="Giao Hàng Tiết Kiệm"><option value="Viettel Post"><option value="Vietnam Post"><option value="J&T Express"><option value="Shop tự giao"></datalist>@error('shipping_carrier')<p class="ship-error">{{ $message }}</p>@enderror</div>
                    <div><label for="tracking_number">Mã vận đơn / mã giao hàng</label><input id="tracking_number" name="tracking_number" maxlength="100" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Ví dụ: GHN123456789">@error('tracking_number')<p class="ship-error">{{ $message }}</p>@enderror</div>
                    <div><label for="shipment_status">Tiến trình giao hàng *</label><select id="shipment_status" name="shipment_status" required>@foreach(\App\Models\ShipmentEvent::STATUSES as $value => $label)<option value="{{ $value }}" @selected(old('shipment_status', $order->shipment_status ?? 'preparing') === $value)>{{ $label }}</option>@endforeach</select>@error('shipment_status')<p class="ship-error">{{ $message }}</p>@enderror</div>
                    <div><label for="estimated_delivery_at">Ngày giao dự kiến</label><input type="date" id="estimated_delivery_at" name="estimated_delivery_at" value="{{ old('estimated_delivery_at', $order->estimated_delivery_at?->format('Y-m-d')) }}">@error('estimated_delivery_at')<p class="ship-error">{{ $message }}</p>@enderror</div>
                    <div class="ship-wide"><label for="ship-location">Vị trí hiện tại</label><input id="ship-location" name="location" maxlength="150" value="{{ old('location') }}" placeholder="Ví dụ: Kho trung chuyển Hà Nội">@error('location')<p class="ship-error">{{ $message }}</p>@enderror</div>
                    <div class="ship-wide"><label for="ship-note">Ghi chú cho khách</label><textarea id="ship-note" name="note" rows="2" maxlength="1000" placeholder="Ví dụ: Khách hẹn giao lại vào chiều mai">{{ old('note') }}</textarea>@error('note')<p class="ship-error">{{ $message }}</p>@enderror</div>
                </div>
                <p class="ship-hint">Chuyển đơn sang “Đang giao hàng” trước khi ghi nhận bàn giao. Khi khách nhận hàng, xác nhận “Đã giao hàng” ở phần trạng thái đơn bên dưới.</p>
                <button class="ship-save" type="submit">Lưu thông tin giao hàng</button>
            </form>
        </details>
    @endif
    <details @if($shipmentEvents->isNotEmpty()) open @endif>
        <summary>Lịch sử vận chuyển <span class="ship-hint">({{ $shipmentEvents->count() }} cập nhật)</span></summary>
        <ol class="ship-timeline">
            @if($shipmentClosed)
                <li><strong>{{ $order->shipmentLabel() }}</strong></li>
            @endif
            @forelse($shipmentEvents as $event)
                <li><strong>{{ \App\Models\ShipmentEvent::STATUSES[$event->status] ?? $event->status }}</strong> <time datetime="{{ $event->created_at->toIso8601String() }}">{{ $event->created_at->format('d/m/Y · H:i') }}</time>
                    @if($event->location)<p>{{ $event->location }}</p>@endif
                    @if($event->note)<p>{{ $event->note }}</p>@endif
                    <p class="ship-hint">{{ $event->carrier }}@if($event->tracking_number) · {{ $event->tracking_number }}@endif</p>
                </li>
            @empty
                <li>Chưa có cập nhật hành trình. Cửa hàng sẽ bổ sung khi chuẩn bị giao đơn.</li>
            @endforelse
        </ol>
    </details>
</section>
