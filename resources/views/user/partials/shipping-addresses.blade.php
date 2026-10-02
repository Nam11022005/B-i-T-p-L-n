<section class="pf-card" id="shipping-addresses" aria-labelledby="shipping-addresses-title">
    <style>
        #shipping-addresses { scroll-margin-top: 24px; }
        .pf-address-list { display: grid; gap: 14px; }
        .pf-address-item { padding: 16px; border: 1px solid #e7dfd5; background: #fffdf9; }
        .pf-address-item.is-default { border-left: 4px solid #35562f; }
        .pf-address-item h3 { font-size: 16px; margin: 0 0 8px; }
        .pf-address-item p { margin: 4px 0; overflow-wrap: anywhere; }
        .pf-address-badge { display: inline-block; margin-left: 8px; padding: 3px 8px; background: #e9f3e5; color: #35562f; font-size: 12px; }
        .pf-address-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
        .pf-address-edit { margin-top: 12px; }
        .pf-address-edit summary { cursor: pointer; color: #633820; font-weight: 700; }
        .pf-address-form { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 12px; margin-top: 14px; }
        .pf-address-form .full { grid-column: 1 / -1; }
        .pf-address-form label { display: block; margin-bottom: 5px; font-size: 13px; font-weight: 700; }
        .pf-address-form input:not([type="checkbox"]):not([type="hidden"]) { width: 100%; padding: 10px 12px; border: 1px solid #dacebf; border-radius: 6px; }
        .pf-address-form .pf-address-check { display: flex; align-items: center; gap: 8px; }
        .pf-address-add { margin-top: 18px; padding-top: 16px; border-top: 1px solid #e7dfd5; }
        html[data-theme="dark"] .pf-address-item { background: #2b241f; color: #f5e8d9; }
        html[data-theme="dark"] .pf-address-edit summary { color: #f3d398; }
        html[data-theme="dark"] .pf-address-form input:not([type="checkbox"]) { background: #241e1a; color: #f5e8d9; }
        @media(max-width:575px) { .pf-address-form { grid-template-columns: 1fr; } }
    </style>
    <div class="pf-card-head">
        <div>
            <h2 class="pf-card-title" id="shipping-addresses-title">Địa chỉ giao hàng</h2>
            <div class="pf-card-subtitle">Quản lý địa chỉ nhận hàng và chọn địa chỉ mặc định khi thanh toán.</div>
        </div>
    </div>
    <div class="pf-card-body">
        @if(!$emailVerified)
            <p>Vui lòng <a href="{{ route('verification.notice') }}">xác thực email</a> để quản lý địa chỉ giao hàng.</p>
        @else
            @if($errors->getBag('addresses')->any())
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->getBag('addresses')->all() as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                </div>
            @endif
            <div class="pf-address-list">
                @forelse($addresses as $address)
                    <article class="pf-address-item {{ $address->is_default ? 'is-default' : '' }}">
                        <h3>{{ $address->label }} @if($address->is_default)<span class="pf-address-badge">Mặc định</span>@endif</h3>
                        <p><strong>{{ $address->receiver_name }}</strong> · {{ $address->phone }}</p>
                        <p>{{ $address->full_address }}</p>
                        <div class="pf-address-actions">
                            @unless($address->is_default)
                                <form action="{{ route('addresses.default', $address) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success" type="submit">Đặt làm mặc định</button>
                                </form>
                            @endunless
                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Bạn muốn xóa địa chỉ này?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Xóa địa chỉ</button>
                            </form>
                        </div>
                        <details class="pf-address-edit" @if($errors->getBag('addresses')->any() && (string) old('address_form') === (string) $address->id) open @endif>
                            <summary>Sửa địa chỉ</summary>
                            @include('user.partials.address-form', ['address' => $address])
                        </details>
                    </article>
                @empty
                    <p class="text-muted mb-0">Bạn chưa lưu địa chỉ giao hàng nào.</p>
                @endforelse
            </div>
            <details class="pf-address-edit pf-address-add" @if($addresses->isEmpty() || ($errors->getBag('addresses')->any() && old('address_form') === 'new')) open @endif>
                <summary>+ Thêm địa chỉ mới</summary>
                @include('user.partials.address-form', ['address' => null])
            </details>
        @endif
    </div>
</section>
