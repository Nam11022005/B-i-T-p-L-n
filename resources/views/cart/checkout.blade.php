@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4 checkout-page-title">
        🛒 Thanh toán
    </h2>


    {{-- THÔNG BÁO --}}

    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('checkout.process') }}"
        method="POST"
        id="checkoutForm"
    >

        @csrf


        {{-- =====================================
             ĐỊA CHỈ NHẬN HÀNG
        ====================================== --}}
        @php
            $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
            $selectedAddressId = old('selected_address_id', $defaultAddress?->id);
        @endphp

        <div class="checkout-section mb-4">
            <div class="checkout-section-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="checkout-section-icon">📍</div>
                    <div>
                        <h4 class="fw-bold mb-1">Địa chỉ nhận hàng</h4>
                        <p class="text-muted mb-0">Chọn địa chỉ đã lưu hoặc nhập địa chỉ khác.</p>
                    </div>
                </div>
                <a href="{{ route('addresses.index') }}" class="btn btn-outline-danger btn-sm">⚙️ Quản lý địa chỉ</a>
            </div>

            @if($addresses->isNotEmpty())
                <div class="saved-address-grid mt-4">
                    @foreach($addresses as $address)
                        @php
                            $fullAddress = collect([
                                $address->address_detail,
                                $address->ward,
                                $address->province,
                            ])->filter()->implode(', ');
                        @endphp
                        <label class="saved-address-card {{ (string)$selectedAddressId === (string)$address->id ? 'selected' : '' }}">
                            <input type="radio" name="selected_address_id" value="{{ $address->id }}"
                                class="address-radio"
                                data-name="{{ $address->receiver_name }}"
                                data-phone="{{ $address->phone }}"
                                data-address="{{ $fullAddress }}"
                                {{ (string)$selectedAddressId === (string)$address->id ? 'checked' : '' }}>
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-bold">{{ $address->label }}</div>
                                    <div class="mt-1"><strong>{{ $address->receiver_name }}</strong> · {{ $address->phone }}</div>
                                    <div class="text-muted small mt-1">{{ $fullAddress }}</div>
                                </div>
                                @if($address->is_default)
                                    <span class="badge text-bg-success align-self-start">Mặc định</span>
                                @endif
                            </div>
                        </label>
                    @endforeach

                    <label class="saved-address-card {{ old('selected_address_id') === 'other' ? 'selected' : '' }}">
                        <input type="radio" name="selected_address_id" value="other" class="address-radio"
                            {{ old('selected_address_id') === 'other' ? 'checked' : '' }}>
                        <div class="fw-bold">➕ Sử dụng địa chỉ khác</div>
                        <div class="text-muted small mt-1">Nhập thông tin giao hàng cho đơn này.</div>
                    </label>
                </div>
            @else
                <div class="alert alert-warning mt-4 mb-0">
                    Bạn chưa có địa chỉ đã lưu. Có thể nhập bên dưới hoặc
                    <a href="{{ route('addresses.index') }}" class="fw-bold">thêm địa chỉ mới</a>.
                </div>
            @endif

            <div class="row g-4 mt-1" id="manualAddressFields">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                    <div class="input-group checkout-input">
                        <span class="input-group-text">👤</span>
                        <input type="text" id="customerName" name="customer_name" class="form-control"
                            value="{{ old('customer_name', $defaultAddress?->receiver_name ?? Auth::user()->name) }}"
                            placeholder="Nhập họ và tên người nhận" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                    <div class="input-group checkout-input">
                        <span class="input-group-text">📞</span>
                        <input type="text" id="customerPhone" name="customer_phone" class="form-control"
                            value="{{ old('customer_phone', $defaultAddress?->phone) }}"
                            placeholder="Ví dụ: 0385742505" required>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                    <div class="input-group checkout-input align-items-stretch">
                        <span class="input-group-text align-items-start pt-3">🏠</span>
                        <textarea id="shippingAddress" name="shipping_address" class="form-control" rows="3"
                            placeholder="Số nhà, đường, phường/xã, tỉnh/thành phố..." required>{{ old('shipping_address', $defaultAddress ? collect([$defaultAddress->address_detail, $defaultAddress->ward, $defaultAddress->province])->filter()->implode(', ') : '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="delivery-note mt-4"><span class="me-2">💡</span><span>Chọn địa chỉ đã lưu để hệ thống tự điền thông tin. Bạn vẫn có thể chỉnh lại trước khi đặt hàng.</span></div>
        </div>

        {{-- =====================================
             SẢN PHẨM
        ====================================== --}}

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    📦 Sản phẩm
                </h5>


                @foreach($cart as $id => $item)

                    @php

                        $itemTotal =
                            $item['price'] *
                            $item['quantity'];

                    @endphp


                    <div
                        class="d-flex justify-content-between align-items-center border-bottom py-3"
                    >

                        <div>

                            <strong>
                                {{ $item['name'] }}
                            </strong>

                            <div class="text-muted small">

                                {{ number_format($item['price'], 0, ',', '.') }}
                                đ
                                ×
                                {{ $item['quantity'] }}

                            </div>

                        </div>


                        <strong>

                            {{ number_format($itemTotal, 0, ',', '.') }}
                            đ

                        </strong>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- =====================================
             VẬN CHUYỂN
        ====================================== --}}

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    🚚 Phương thức vận chuyển
                </h5>


                <div class="shipping-option mb-2">

                    <input
                        type="radio"
                        name="shipping_method"
                        value="standard"
                        id="standard"
                        data-fee="25000"
                        checked
                    >

                    <label
                        for="standard"
                        class="d-flex justify-content-between w-100"
                    >

                        <span>
                            <strong>Tiết kiệm</strong>
                            <br>
                            <small class="text-muted">
                                Giao hàng từ 3 - 5 ngày
                            </small>
                        </span>

                        <strong>
                            25.000đ
                        </strong>

                    </label>

                </div>


                <div class="shipping-option mb-2">

                    <input
                        type="radio"
                        name="shipping_method"
                        value="fast"
                        id="fast"
                        data-fee="35000"
                    >

                    <label
                        for="fast"
                        class="d-flex justify-content-between w-100"
                    >

                        <span>
                            <strong>Nhanh</strong>
                            <br>
                            <small class="text-muted">
                                Giao hàng từ 1 - 2 ngày
                            </small>
                        </span>

                        <strong>
                            35.000đ
                        </strong>

                    </label>

                </div>


                <div class="shipping-option">

                    <input
                        type="radio"
                        name="shipping_method"
                        value="express"
                        id="express"
                        data-fee="50000"
                    >

                    <label
                        for="express"
                        class="d-flex justify-content-between w-100"
                    >

                        <span>
                            <strong>Hỏa tốc</strong>
                            <br>
                            <small class="text-muted">
                                Nhận hàng trong ngày
                            </small>
                        </span>

                        <strong>
                            50.000đ
                        </strong>

                    </label>

                </div>

            </div>

        </div>


        {{-- =====================================
             VOUCHER
        ====================================== --}}

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    🎟️ Voucher
                </h5>


                <div class="input-group">

                    <input
                        type="text"
                        name="voucher_code"
                        id="voucherCode"
                        class="form-control"
                        value="{{ old('voucher_code') }}"
                        placeholder="Nhập mã giảm giá"
                    >

                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        onclick="applyVoucher()"
                    >
                        Áp dụng
                    </button>

                </div>


                <div
                    id="voucherMessage"
                    class="mt-2"
                ></div>

                {{-- DANH SÁCH VOUCHER KHẢ DỤNG --}}
                <div class="mt-4">
                    <div class="fw-bold mb-2">
                        🎁 Voucher đang khả dụng
                    </div>

                    @forelse($availableVouchers as $voucher)
                        @php
                            $canUseVoucher =
                                $subtotal >= (float) $voucher->min_order_value;

                            if ($voucher->type === 'percent') {
                                $voucherDescription =
                                    'Giảm ' .
                                    rtrim(rtrim(number_format($voucher->value, 2, '.', ''), '0'), '.') .
                                    '%';

                                if ($voucher->max_discount !== null) {
                                    $voucherDescription .=
                                        ', tối đa ' .
                                        number_format($voucher->max_discount, 0, ',', '.') .
                                        'đ';
                                }
                            } elseif ($voucher->type === 'fixed') {
                                $voucherDescription =
                                    'Giảm ' .
                                    number_format($voucher->value, 0, ',', '.') .
                                    'đ';
                            } else {
                                $voucherDescription =
                                    'Giảm phí vận chuyển tối đa ' .
                                    number_format($voucher->value, 0, ',', '.') .
                                    'đ';
                            }
                        @endphp

                        <div
                            class="voucher-option {{ $canUseVoucher ? '' : 'voucher-disabled' }}"
                        >
                            <div class="voucher-option-content">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="voucher-badge">
                                        {{ $voucher->code }}
                                    </span>

                                    <strong>
                                        {{ $voucher->name }}
                                    </strong>
                                </div>

                                <div class="small mt-2">
                                    {{ $voucherDescription }}
                                </div>

                                <div class="small text-muted mt-1">
                                    Đơn tối thiểu:
                                    {{ number_format($voucher->min_order_value, 0, ',', '.') }}đ

                                    @if($voucher->usage_limit !== null)
                                        · Còn
                                        {{ max($voucher->usage_limit - $voucher->used_count, 0) }}
                                        lượt
                                    @endif
                                </div>

                                @unless($canUseVoucher)
                                    <div class="small text-danger mt-1">
                                        Đơn hàng chưa đủ điều kiện áp dụng.
                                    </div>
                                @endunless
                            </div>

                            <button
                                type="button"
                                class="btn btn-sm {{ $canUseVoucher ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                onclick="selectVoucher('{{ $voucher->code }}')"
                                {{ $canUseVoucher ? '' : 'disabled' }}
                            >
                                Áp dụng
                            </button>
                        </div>
                    @empty
                        <div class="text-muted small">
                            Hiện chưa có voucher nào khả dụng.
                        </div>
                    @endforelse
                </div>

            </div>

        </div>


        {{-- =====================================
             THANH TOÁN
        ====================================== --}}

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    💳 Phương thức thanh toán
                </h5>


                <div class="form-check border rounded p-3 mb-2">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="payment_method"
                        value="cod"
                        id="cod"
                        checked
                    >

                    <label
                        class="form-check-label"
                        for="cod"
                    >
                        🚚 Thanh toán khi nhận hàng (COD)
                    </label>

                </div>


     <div class="form-check border rounded p-3">

    <input
        class="form-check-input"
        type="radio"
        name="payment_method"
        value="bank"
        id="bank"
    >

    <label
        class="form-check-label"
        for="bank"
    >
        🏦 Chuyển khoản ngân hàng
    </label>

</div>


{{-- ==========================================
    THANH TOÁN CHUYỂN KHOẢN TỰ ĐỘNG
========================================== --}}
<div
    id="bankTransferInfo"
    class="card border-primary mt-3"
    style="display: none;"
>
    <div class="card-header bg-primary text-white">
        <strong>🏦 Chuyển khoản tự động</strong>
    </div>

    <div class="card-body">
        <div class="alert alert-info mb-3">
            <strong>Bước 1:</strong> Bấm “Tạo đơn & thanh toán QR”.<br>
            <strong>Bước 2:</strong> Hệ thống sẽ tạo đơn hàng và hiển thị mã QR có
            <strong>đúng số tiền + mã thanh toán riêng của đơn</strong>.<br>
            <strong>Bước 3:</strong> Sau khi ngân hàng ghi nhận giao dịch, trang đơn hàng
            sẽ tự chuyển sang <strong>✅ Thanh toán thành công</strong>.
        </div>

        <div class="small text-muted">
            Không chuyển khoản trước khi đơn hàng được tạo để tránh giao dịch
            không có mã đơn tương ứng.
        </div>
    </div>
</div>

        {{-- =====================================
             GHI CHÚ
        ====================================== --}}

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    📝 Ghi chú
                </h5>

                <textarea
                    name="notes"
                    class="form-control"
                    rows="3"
                    placeholder="Ghi chú cho người bán..."
                >{{ old('notes') }}</textarea>

            </div>

        </div>


        {{-- =====================================
             TỔNG THANH TOÁN
        ====================================== --}}

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Tạm tính
                    </span>

                    <span>
                        <strong id="subtotal">
                            {{ number_format($subtotal, 0, ',', '.') }}đ
                        </strong>
                    </span>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Phí vận chuyển
                    </span>

                    <span>
                        <strong id="shippingFee">
                            25.000đ
                        </strong>
                    </span>

                </div>


                <div class="d-flex justify-content-between mb-3">

                    <span>
                        Giảm giá
                    </span>

                    <span class="text-success">

                        -
                        <strong id="discount">
                            0đ
                        </strong>

                    </span>

                </div>


                <hr>


                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <strong class="fs-5">
                            Tổng thanh toán
                        </strong>

                    </div>


                    <div>

                        <strong
                            class="fs-3 text-danger"
                            id="total"
                        >
                            {{ number_format($subtotal + 25000, 0, ',', '.') }}đ
                        </strong>

                    </div>

                </div>


                <div class="text-end mt-4">

                    <a
                        href="{{ route('cart.index') }}"
                        class="btn btn-outline-secondary me-2"
                    >
                        ← Quay lại
                    </a>


                   <button
    type="submit"
    id="orderButton"
    class="btn btn-danger btn-lg px-5"
>
    🛍️ Đặt hàng COD
</button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- ==========================================
     CSS
========================================== --}}

<style>

:root {
    --tb-brown: #5f341d;
    --tb-brown-dark: #2c1810;
    --tb-red: #a83b2d;
    --tb-orange: #d97706;
    --tb-gold: #f2c15c;
    --tb-green: #48633b;
    --tb-cream: #fffaf0;
    --tb-soft: #f8efe2;
    --tb-border: #ead8bf;
    --tb-text: #2f241e;
}

body {
    background: linear-gradient(180deg, #fffaf0 0%, #f8efe2 100%);
    color: var(--tb-text);
}

.checkout-page-title {
    color: var(--tb-brown-dark);
}

.card,
.checkout-section {
    border: 1px solid var(--tb-border) !important;
    background: #fffdf8 !important;
    box-shadow: 0 10px 30px rgba(95, 52, 29, 0.08) !important;
}

.card {
    border-radius: 20px !important;
}

.card h5,
.checkout-section h4 {
    color: var(--tb-brown-dark);
}

.btn-danger,
.btn-tb-primary {
    background: linear-gradient(135deg, var(--tb-red), var(--tb-brown)) !important;
    border-color: var(--tb-red) !important;
    color: #fff !important;
}

.btn-danger:hover,
.btn-tb-primary:hover {
    background: linear-gradient(135deg, #8f3025, var(--tb-brown-dark)) !important;
    border-color: #8f3025 !important;
}

.btn-outline-danger {
    color: var(--tb-red) !important;
    border-color: var(--tb-red) !important;
}

.btn-outline-danger:hover {
    color: #fff !important;
    background: var(--tb-red) !important;
}

.text-danger {
    color: var(--tb-red) !important;
}

.text-success {
    color: var(--tb-green) !important;
}

.form-control,
.form-select {
    border-color: var(--tb-border) !important;
    background: #fff !important;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--tb-red) !important;
    box-shadow: 0 0 0 3px rgba(168, 59, 45, 0.10) !important;
}

.input-group-text {
    border-color: var(--tb-border) !important;
    background: var(--tb-soft) !important;
}

.form-check-input:checked {
    background-color: var(--tb-red) !important;
    border-color: var(--tb-red) !important;
}

/* ==========================================
   ĐỊA CHỈ NHẬN HÀNG
========================================== */
.checkout-section {
    background: #fffdf8;
    border-radius: 22px;
    padding: 28px;
    border: 1px solid var(--tb-border);
    box-shadow: 0 10px 30px rgba(95, 52, 29, 0.08);
}

.checkout-section-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--tb-border);
}

.checkout-section-icon {
    width: 55px;
    height: 55px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    flex-shrink: 0;
    background: linear-gradient(135deg, #f8efe2, #fff3d6);
}

.checkout-input .input-group-text {
    background: var(--tb-soft);
    border: 1px solid var(--tb-border);
    border-right: none;
    min-width: 48px;
    justify-content: center;
}

.checkout-input .form-control {
    min-height: 48px;
    border: 1px solid var(--tb-border);
    box-shadow: none;
}

.checkout-input .form-control:focus {
    border-color: var(--tb-red);
    box-shadow: 0 0 0 3px rgba(168, 59, 45, 0.10);
}

.checkout-input:focus-within .input-group-text {
    border-color: var(--tb-red);
}

.checkout-input textarea.form-control {
    min-height: 105px;
    resize: vertical;
}

.delivery-note {
    background: #fff3d6;
    color: #6b4a36;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 14px;
}

@media (max-width: 767.98px) {
    .checkout-section {
        padding: 20px;
    }

    .checkout-section-header {
        align-items: flex-start;
    }
}

.shipping-option {
    border: 1px solid var(--tb-border);
    border-radius: 14px;
    padding: 15px;
    transition: 0.2s;
    background: #fffdf8;
}

.shipping-option:hover {
    border-color: var(--tb-red);
    background: #fff7f2;
}

.shipping-option input {
    margin-right: 10px;
}

.shipping-option label {
    cursor: pointer;
}


/* ==========================================
   VOUCHER KHẢ DỤNG
========================================== */
.voucher-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 16px;
    margin-top: 10px;
    border: 1px dashed var(--tb-gold);
    border-radius: 14px;
    background: var(--tb-cream);
}

.voucher-option-content {
    min-width: 0;
}

.voucher-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 8px;
    background: var(--tb-soft);
    color: var(--tb-red);
    font-weight: 800;
    letter-spacing: .5px;
}

.voucher-disabled {
    opacity: .62;
    background: #f8f9fa;
}

@media (max-width: 575.98px) {
    .voucher-option {
        align-items: stretch;
        flex-direction: column;
    }
}



#bankTransferInfo {
    border-color: var(--tb-border) !important;
}

#bankTransferInfo .card-header {
    background: linear-gradient(
        135deg,
        var(--tb-brown),
        var(--tb-green)
    ) !important;
    border-color: transparent !important;
}

#bankTransferAmount,
#bankTransferInfo .text-primary {
    color: var(--tb-red) !important;
}

.alert-info {
    background: #fff3d6 !important;
    border-color: #f0d5a4 !important;
    color: #6b4a36 !important;
}

.alert-warning {
    background: #fff7df !important;
    border-color: #efd39b !important;
    color: #6b4a36 !important;
}



.saved-address-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
.saved-address-card { display:block; position:relative; padding:16px; border:1px solid var(--tb-border); border-radius:14px; background:#fff; cursor:pointer; transition:.2s; }
.saved-address-card:hover, .saved-address-card.selected { border-color:var(--tb-red); box-shadow:0 0 0 3px rgba(168,59,45,.08); background:#fffaf7; }
.saved-address-card .address-radio { position:absolute; opacity:0; pointer-events:none; }
@media(max-width:767.98px){ .saved-address-grid{grid-template-columns:1fr;} }

</style>


{{-- ==========================================
     JAVASCRIPT
========================================== --}}

@php
    $voucherJsData = $availableVouchers
        ->map(function ($voucher) {
            return [
                'code' => $voucher->code,
                'type' => $voucher->type,
                'value' => (float) $voucher->value,
                'min_order_value' => (float) $voucher->min_order_value,
                'max_discount' => $voucher->max_discount !== null
                    ? (float) $voucher->max_discount
                    : null,
            ];
        })
        ->values();
@endphp

<script>
function applySavedAddress(input) {
    // Bỏ trạng thái selected khỏi tất cả thẻ địa chỉ
    document
        .querySelectorAll('.saved-address-card')
        .forEach(card => card.classList.remove('selected'));

    // Đánh dấu thẻ vừa chọn
    input
        .closest('.saved-address-card')
        ?.classList.add('selected');

    const name =
        document.getElementById('customerName');

    const phone =
        document.getElementById('customerPhone');

    const address =
        document.getElementById('shippingAddress');


    // ==========================================
    // SỬ DỤNG ĐỊA CHỈ KHÁC
    // => XÓA TRẮNG TOÀN BỘ THÔNG TIN
    // ==========================================
    if (input.value === 'other') {

        if (name) {
            name.value = '';
            name.focus();
        }

        if (phone) {
            phone.value = '';
        }

        if (address) {
            address.value = '';
        }

        return;
    }


    // ==========================================
    // ĐỊA CHỈ ĐÃ LƯU
    // => TỰ ĐIỀN THÔNG TIN
    // ==========================================
    if (name) {
        name.value =
            input.dataset.name || '';
    }

    if (phone) {
        phone.value =
            input.dataset.phone || '';
    }

    if (address) {
        address.value =
            input.dataset.address || '';
    }
}


// Bắt sự kiện chọn địa chỉ
document
    .querySelectorAll('.address-radio')
    .forEach(function(input) {

        input.addEventListener(
            'change',
            function() {
                applySavedAddress(this);
            }
        );

    });


// Nếu trang được load lại do validation,
// đồng bộ form theo địa chỉ đang được chọn.
const checkedAddress =
    document.querySelector(
        '.address-radio:checked'
    );

if (checkedAddress) {
    applySavedAddress(checkedAddress);
}



const subtotal = {{ $subtotal }};

let discount = 0;

let voucherApplied = false;

const availableVouchers = @json($voucherJsData);



// Format tiền Việt Nam
function formatMoney(number)
{
    return new Intl.NumberFormat('vi-VN')
        .format(number) + 'đ';
}


// Lấy phí ship
function getShippingFee()
{
    const selected =
        document.querySelector(
            'input[name="shipping_method"]:checked'
        );

    return Number(
        selected.dataset.fee
    );
}


// Cập nhật tổng tiền
function updateTotal()
{
    const shippingFee =
        getShippingFee();

    const total =
        subtotal +
        shippingFee -
        discount;

    document.getElementById(
        'shippingFee'
    ).innerText =
        formatMoney(shippingFee);


    document.getElementById(
        'discount'
    ).innerText =
        formatMoney(discount);


    document.getElementById(
        'total'
    ).innerText =
        formatMoney(
            Math.max(total, 0)
        );
        const bankAmount =
    document.getElementById(
        'bankTransferAmount'
    );

if (bankAmount)
{
    bankAmount.innerText =
        formatMoney(
            Math.max(total, 0)
        );
}
updateBankQr(
    Math.max(total, 0)
);
}


// Chọn phương thức vận chuyển
document
    .querySelectorAll(
        'input[name="shipping_method"]'
    )
    .forEach(function(input)
    {
        input.addEventListener(
            'change',
            function()
            {
                if (voucherApplied) {
                    applyVoucher();
                } else {
                    updateTotal();
                }
            }
        );
    });


// Chọn voucher từ danh sách
function selectVoucher(code)
{
    document.getElementById(
        'voucherCode'
    ).value = code;

    applyVoucher();
}


// Áp dụng voucher
function applyVoucher()
{
    const code =
        document.getElementById(
            'voucherCode'
        ).value
        .trim()
        .toUpperCase();

    const message =
        document.getElementById(
            'voucherMessage'
        );

    const shippingFee =
        getShippingFee();

    discount = 0;
    voucherApplied = false;

    if (code === '')
    {
        message.innerHTML =
            '<span class="text-danger">Vui lòng nhập mã voucher.</span>';

        updateTotal();
        return;
    }

    const voucher =
        availableVouchers.find(function(item)
        {
            return item.code.toUpperCase() === code;
        });

    if (!voucher)
    {
        message.innerHTML =
            '<span class="text-danger">✕ Voucher không tồn tại hoặc hiện không khả dụng.</span>';

        updateTotal();
        return;
    }

    if (subtotal < voucher.min_order_value)
    {
        message.innerHTML =
            '<span class="text-danger">✕ Đơn hàng phải đạt tối thiểu '
            + formatMoney(voucher.min_order_value)
            + ' để sử dụng voucher này.</span>';

        updateTotal();
        return;
    }

    if (voucher.type === 'percent')
    {
        const percent =
            Math.min(Number(voucher.value), 100);

        discount =
            subtotal * (percent / 100);
    }
    else if (voucher.type === 'fixed')
    {
        discount =
            Math.min(
                Number(voucher.value),
                subtotal
            );
    }
    else if (voucher.type === 'shipping')
    {
        discount =
            Math.min(
                Number(voucher.value),
                shippingFee
            );
    }

    if (voucher.max_discount !== null)
    {
        discount =
            Math.min(
                discount,
                Number(voucher.max_discount)
            );
    }

    voucherApplied = true;

    message.innerHTML =
        '<span class="text-success">✓ Đã áp dụng voucher '
        + code
        + '.</span>';

    updateTotal();
}

updateTotal();
// ==========================================
// PHƯƠNG THỨC THANH TOÁN
// ==========================================

const paymentMethods =
    document.querySelectorAll(
        'input[name="payment_method"]'
    );

const bankTransferInfo =
    document.getElementById(
        'bankTransferInfo'
    );


function updatePaymentMethod()
{
    const selectedPayment =
        document.querySelector(
            'input[name="payment_method"]:checked'
        );


    if (
        selectedPayment
        &&
        selectedPayment.value === 'bank'
    )
    {
        bankTransferInfo.style.display =
            'block';
    }
    else
    {
        bankTransferInfo.style.display =
            'none';
    }


    updateOrderButton();
}


paymentMethods.forEach(
    function(input)
    {
        input.addEventListener(
            'change',
            updatePaymentMethod
        );
    }
);


// ==========================================
// THAY ĐỔI CHỮ NÚT ĐẶT HÀNG
// ==========================================

function updateOrderButton()
{
    const selectedPayment =
        document.querySelector(
            'input[name="payment_method"]:checked'
        );

    const orderButton =
        document.getElementById(
            'orderButton'
        );


    if (!orderButton)
    {
        return;
    }


    if (
        selectedPayment
        &&
        selectedPayment.value === 'bank'
    )
    {
        orderButton.innerHTML =
            '🏦 Tạo đơn & thanh toán QR';

        orderButton.classList.remove(
            'btn-danger'
        );

        orderButton.classList.add(
            'btn-primary'
        );
    }
    else
    {
        orderButton.innerHTML =
            '🛍️ Đặt hàng COD';

        orderButton.classList.remove(
            'btn-primary'
        );

        orderButton.classList.add(
            'btn-danger'
        );
    }
}


// ==========================================
// COPY NỘI DUNG CHUYỂN KHOẢN
// ==========================================

function copyTransferContent()
{
    const input =
        document.getElementById(
            'bankTransferContent'
        );

    navigator.clipboard
        .writeText(
            input.value
        )
        .then(function()
        {
            alert(
                'Đã sao chép nội dung chuyển khoản!'
            );
        });
}

// ==========================================
// CẬP NHẬT QR CHUYỂN KHOẢN
// ==========================================

function updateBankQr(total)
{
    const qr =
        document.getElementById(
            'bankQrCode'
        );

    const content =
        document.getElementById(
            'bankTransferContent'
        );

    if (!qr || !content)
    {
        return;
    }

    const accountNumber = '0385742505';

    const bankCode = 'MB';

    const transferContent =
        content.value;

    const amount =
        Math.round(total);

    qr.src =
        'https://img.vietqr.io/image/'
        + bankCode
        + '-'
        + accountNumber
        + '-compact2.png'
        + '?amount='
        + amount
        + '&addInfo='
        + encodeURIComponent(
            transferContent
        )
        + '&accountName='
        + encodeURIComponent(
            'DO PHUONG NAM'
        );
}
updateTotal();
updatePaymentMethod();

</script>

@endsection