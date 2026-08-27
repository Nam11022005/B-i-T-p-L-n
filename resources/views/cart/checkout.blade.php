@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">
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

        <div class="checkout-section mb-4">

            <div class="checkout-section-header">

                <div class="checkout-section-icon">
                    📍
                </div>

                <div>
                    <h4 class="fw-bold mb-1">
                        Địa chỉ nhận hàng
                    </h4>

                    <p class="text-muted mb-0">
                        Vui lòng nhập chính xác thông tin để shop giao hàng
                    </p>
                </div>

            </div>


            <div class="row g-4 mt-1">

                {{-- HỌ VÀ TÊN --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Họ và tên
                        <span class="text-danger">*</span>
                    </label>

                    <div class="input-group checkout-input">

                        <span class="input-group-text">
                            👤
                        </span>

                        <input
                            type="text"
                            name="customer_name"
                            class="form-control"
                            value="{{ old('customer_name', Auth::user()->name) }}"
                            placeholder="Nhập họ và tên người nhận"
                            required
                        >

                    </div>

                </div>


                {{-- SỐ ĐIỆN THOẠI --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Số điện thoại
                        <span class="text-danger">*</span>
                    </label>

                    <div class="input-group checkout-input">

                        <span class="input-group-text">
                            📞
                        </span>

                        <input
                            type="text"
                            name="customer_phone"
                            class="form-control"
                            value="{{ old('customer_phone') }}"
                            placeholder="Ví dụ: 0385742505"
                            required
                        >

                    </div>

                </div>


                {{-- ĐỊA CHỈ GIAO HÀNG --}}
                <div class="col-12">

                    <label class="form-label fw-semibold">
                        Địa chỉ giao hàng
                        <span class="text-danger">*</span>
                    </label>

                    <div class="input-group checkout-input align-items-stretch">

                        <span class="input-group-text align-items-start pt-3">
                            🏠
                        </span>

                        <textarea
                            name="shipping_address"
                            class="form-control"
                            rows="3"
                            placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố..."
                            required
                        >{{ old('shipping_address') }}</textarea>

                    </div>

                </div>

            </div>


            <div class="delivery-note mt-4">

                <span class="me-2">💡</span>

                <span>
                    Shop sẽ sử dụng thông tin này để giao hàng. Hãy kiểm tra kỹ số điện thoại và địa chỉ trước khi đặt hàng.
                </span>

            </div>

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


                <div class="small text-muted mt-2">

                    Mã thử:

                    <strong>SHOPEE10</strong>
                    -
                    <strong>FREESHIP</strong>
                    -
                    <strong>GIAM50K</strong>

                </div>


                <div
                    id="voucherMessage"
                    class="mt-2"
                ></div>

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
    THÔNG TIN CHUYỂN KHOẢN
========================================== --}}
<div
    id="bankTransferInfo"
    class="card border-primary mt-3"
    style="display: none;"
>

    <div class="card-header bg-primary text-white">

        <strong>
            🏦 Thông tin chuyển khoản
        </strong>

    </div>

    <div class="card-body">

        <div class="alert alert-info">

            Vui lòng chuyển khoản đúng số tiền và nội dung
            bên dưới trước khi bấm đặt hàng.

        </div>


        <div class="row g-3">

            <div class="col-md-6">

                <small class="text-muted">
                    Ngân hàng
                </small>

                <div class="fw-bold fs-5">
                    MB BANK
                </div>

            </div>


            <div class="col-md-6">

                <small class="text-muted">
                    Chủ tài khoản
                </small>

                <div class="fw-bold fs-5">
                    ĐỖ PHƯƠNG NAM
                </div>

            </div>


            <div class="col-md-6">

                <small class="text-muted">
                    Số tài khoản
                </small>

                <div class="fw-bold fs-4 text-primary">
                    0385742505 
                </div>

            </div>


            <div class="col-md-6">

                <small class="text-muted">
                    Số tiền cần chuyển
                </small>

                <div
                    id="bankTransferAmount"
                    class="fw-bold fs-4 text-danger"
                >
                    0đ
                </div>

            </div>

        </div>

{{-- QR CHUYỂN KHOẢN --}}
<div class="text-center mt-4">

    <h6 class="fw-bold mb-3">
        📱 Quét mã QR để chuyển khoản
    </h6>

    <div class="bg-white border rounded-3 p-3 d-inline-block shadow-sm">

        <img
            id="bankQrCode"
            src=""
            alt="QR chuyển khoản"
            class="img-fluid"
            style="width: 280px; max-width: 100%;"
        >

    </div>

    <div class="small text-muted mt-2">
        Mở ứng dụng ngân hàng và quét mã QR
    </div>

</div>
        <hr>


        <div>

            <small class="text-muted">
                Nội dung chuyển khoản
            </small>

            <div class="input-group mt-1">

                <input
                    type="text"
                    id="bankTransferContent"
                    class="form-control fw-bold"
                    value="PHUONGNAM {{ Auth::id() }}"
                    readonly
                >

                <button
                    type="button"
                    class="btn btn-outline-primary"
                    onclick="copyTransferContent()"
                >
                    📋 Sao chép
                </button>

            </div>

        </div>


        <div class="alert alert-warning mt-3 mb-0">

            ⚠️ Sau khi đặt hàng, trạng thái thanh toán
            sẽ là <strong>Chờ xác nhận chuyển khoản</strong>.
            Shop sẽ kiểm tra và xác nhận sau khi nhận được tiền.

        </div>

    </div>

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

/* ==========================================
   ĐỊA CHỈ NHẬN HÀNG
========================================== */
.checkout-section {
    background: #ffffff;
    border-radius: 22px;
    padding: 28px;
    border: 1px solid #eef2f7;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
}

.checkout-section-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eef2f7;
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
    background: linear-gradient(135deg, #fee2e2, #fff1f2);
}

.checkout-input .input-group-text {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-right: none;
    min-width: 48px;
    justify-content: center;
}

.checkout-input .form-control {
    min-height: 48px;
    border: 1px solid #e2e8f0;
    box-shadow: none;
}

.checkout-input .form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
}

.checkout-input:focus-within .input-group-text {
    border-color: #4f46e5;
}

.checkout-input textarea.form-control {
    min-height: 105px;
    resize: vertical;
}

.delivery-note {
    background: #eff6ff;
    color: #475569;
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
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    transition: 0.2s;
}

.shipping-option:hover {
    border-color: #dc3545;
    background: #fff8f8;
}

.shipping-option input {
    margin-right: 10px;
}

.shipping-option label {
    cursor: pointer;
}

</style>


{{-- ==========================================
     JAVASCRIPT
========================================== --}}

<script>

const subtotal = {{ $subtotal }};

let discount = 0;

let voucherApplied = false;


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
                discount = 0;

                voucherApplied = false;

                document.getElementById(
                    'voucherMessage'
                ).innerHTML = '';

                updateTotal();
            }
        );
    });


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


    if (code === '')
    {
        message.innerHTML =
            '<span class="text-danger">Vui lòng nhập mã voucher.</span>';

        updateTotal();

        return;
    }


    if (code === 'SHOPEE10')
    {
        discount =
            subtotal * 0.10;

        message.innerHTML =
            '<span class="text-success">✓ Giảm 10% thành công!</span>';
    }

    else if (code === 'FREESHIP')
    {
        discount =
            Math.min(
                25000,
                shippingFee
            );

        message.innerHTML =
            '<span class="text-success">✓ Đã áp dụng mã miễn phí vận chuyển!</span>';
    }

    else if (code === 'GIAM50K')
    {
        discount =
            Math.min(
                50000,
                subtotal
            );

        message.innerHTML =
            '<span class="text-success">✓ Giảm 50.000đ thành công!</span>';
    }

    else
    {
        message.innerHTML =
            '<span class="text-danger">✕ Mã voucher không hợp lệ.</span>';
    }


    voucherApplied = true;

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
            '🏦 Tôi đã chuyển khoản & đặt hàng';

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