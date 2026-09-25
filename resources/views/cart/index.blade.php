@extends('layouts.app')

@section('title', 'Giỏ hàng | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .cart-page-title {
        font-weight: 800;
        color: #2f241e;
    }

    .cart-card,
    .summary-card,
    .continue-card {
        border: 1px solid #ead8bf;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(95,52,29,.06);
    }

    .cart-table th {
        white-space: nowrap;
        background: #f8efe2;
        color: #5f341d;
        font-weight: 700;
    }

    .cart-table td {
        vertical-align: middle;
    }

    .product-name {
        font-weight: 700;
        color: #2f241e;
    }

    .money {
        font-weight: 800;
        color: #a83b2d;
    }

    .summary-total {
        font-size: 30px;
        font-weight: 900;
        color: #a83b2d;
    }

    .checkout-btn {
        border: 0;
        border-radius: 12px;
        font-weight: 700;
        padding-top: 13px;
        padding-bottom: 13px;
        background: linear-gradient(135deg,#48633b,#2f4b2b);
    }

    .checkout-btn:hover {
        background: linear-gradient(135deg,#3e5634,#253d22);
    }

    .continue-btn {
        border-radius: 10px;
    }

    .unit-pill {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 999px;
        color: #5f341d;
        background: #fffaf0;
        border: 1px solid #ead8bf;
        font-size: 12px;
        font-weight: 700;
    }


    /* =========================================================
       CART PREMIUM UI 2026
       CHỈ NÂNG GIAO DIỆN - KHÔNG ĐỔI ROUTE / FORM / LOGIC BLADE
    ========================================================= */

    .cart-premium-page {
        position: relative;
        isolation: isolate;
        padding-top: 34px !important;
        padding-bottom: 70px !important;
    }

    /* Nền trang kiểu Tây Bắc nhẹ, không dùng ảnh ngoài */
    .cart-premium-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -30px;
        left: 50%;
        width: min(100vw, 1680px);
        height: 650px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 8% 10%, rgba(242,193,92,.18), transparent 24%),
            radial-gradient(circle at 92% 13%, rgba(72,99,59,.13), transparent 28%),
            linear-gradient(180deg, rgba(255,250,240,.98), rgba(255,255,255,0));
    }

    .cart-premium-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        top: 90px;
        right: -46px;
        width: 220px;
        height: 220px;
        opacity: .13;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.30) 0 1px,
                transparent 1px 13px
            );
    }

    /* Tiêu đề */
    .cart-premium-page .cart-page-title {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: clamp(30px, 3vw, 42px);
        letter-spacing: -.7px;
        color: #2f241e;
        text-shadow: 0 1px 0 #fff;
    }

    .cart-premium-page .cart-page-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -9px;
        width: 92px;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(90deg,#d97706,#a83b2d,#48633b);
    }

    /* Card tổng */
    .cart-premium-page .cart-card,
    .cart-premium-page .summary-card,
    .cart-premium-page .continue-card {
        border-radius: 24px;
        border-color: #e6d0b3;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 18px 46px rgba(95,52,29,.085),
            inset 0 1px 0 rgba(255,255,255,.92);
    }

    /* Bảng giỏ hàng */
    .cart-premium-page .cart-card {
        position: relative;
        overflow: hidden;
    }

    .cart-premium-page .cart-card::before {
        content: "";
        position: absolute;
        z-index: 3;
        top: 0;
        left: 4%;
        right: 4%;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            transparent,
            #f2c15c 24%,
            #d97706 52%,
            #48633b 78%,
            transparent
        );
        opacity: .8;
    }

    .cart-premium-page .cart-table {
        --bs-table-bg: transparent;
    }

    .cart-premium-page .cart-table thead th {
        padding-top: 17px;
        padding-bottom: 17px;
        border-bottom: 1px solid #e6d0b3;
        background:
            linear-gradient(180deg,#fff7e8,#f8efe2);
        color: #5f341d;
        font-size: 13px;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .cart-premium-page .cart-table tbody tr {
        transition:
            background-color .18s ease,
            transform .18s ease;
    }

    .cart-premium-page .cart-table tbody tr:hover {
        --bs-table-hover-bg: #fffaf2;
    }

    .cart-premium-page .cart-table tbody td {
        padding-top: 19px;
        padding-bottom: 19px;
        border-color: #f0e4d5;
    }

    .cart-premium-page .product-name {
        font-size: 16px;
        line-height: 1.4;
        color: #34251d;
    }

    .cart-premium-page .unit-pill {
        padding: 5px 10px;
        background: linear-gradient(180deg,#fffaf0,#fff4df);
        border-color: #e9cfaa;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .cart-premium-page .badge.bg-secondary {
        border-radius: 999px;
        padding: 7px 10px;
        background: #f3eee8 !important;
        color: #5f341d !important;
        border: 1px solid #e5d4bd;
        font-weight: 800;
    }

    .cart-premium-page .money {
        font-size: 17px;
        letter-spacing: -.2px;
    }

    /* Số lượng */
    .cart-premium-page .input-group {
        border-radius: 11px;
        box-shadow: 0 5px 14px rgba(95,52,29,.055);
    }

    .cart-premium-page .input-group .form-control {
        border-color: #dec7a8;
        font-weight: 800;
        text-align: center;
    }

    .cart-premium-page .input-group-text {
        border-color: #dec7a8;
        background: #fff7e8;
        color: #5f341d;
        font-weight: 800;
    }

    .cart-premium-page .btn-primary.btn-sm {
        border: 0;
        border-radius: 9px;
        background: linear-gradient(135deg,#5f341d,#48633b);
        font-weight: 800;
        box-shadow: 0 5px 12px rgba(95,52,29,.11);
    }

    .cart-premium-page .btn-outline-danger.btn-sm {
        border-radius: 9px;
        font-weight: 800;
    }

    /* Card tiếp tục mua */
    .cart-premium-page .continue-card {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 88% 18%, rgba(242,193,92,.20), transparent 28%),
            linear-gradient(145deg,#fffdf9,#fff7e9);
    }

    .cart-premium-page .continue-card::after {
        content: "🌿";
        position: absolute;
        right: 24px;
        bottom: -10px;
        font-size: 96px;
        opacity: .06;
        transform: rotate(-15deg);
        pointer-events: none;
    }

    .cart-premium-page .continue-card .card-body {
        position: relative;
        z-index: 1;
    }

    .cart-premium-page .continue-btn {
        min-height: 43px;
        padding-inline: 18px;
        border-radius: 999px;
        border-color: #cdb18b;
        color: #5f341d;
        font-weight: 800;
        background: rgba(255,255,255,.78);
    }

    .cart-premium-page .continue-btn:hover {
        background: #5f341d;
        border-color: #5f341d;
        color: #fff;
    }

    /* Tổng đơn hàng */
    .cart-premium-page .summary-card {
        position: relative;
        overflow: hidden;
    }

    .cart-premium-page .summary-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        border-radius: 0 0 0 100%;
        background: linear-gradient(
            135deg,
            rgba(242,193,92,.13),
            rgba(72,99,59,.05)
        );
        pointer-events: none;
    }

    .cart-premium-page .summary-card h5 {
        color: #3a291f;
        font-size: 20px;
    }

    .cart-premium-page .summary-card hr {
        border-color: #e7d5bc;
        opacity: 1;
    }

    .cart-premium-page .summary-total {
        font-size: clamp(28px,3vw,38px);
        letter-spacing: -.7px;
        text-shadow: 0 1px 0 #fff;
    }

    .cart-premium-page .checkout-btn {
        position: relative;
        overflow: hidden;
        min-height: 54px;
        border-radius: 14px;
        letter-spacing: .15px;
        box-shadow: 0 10px 24px rgba(72,99,59,.20);
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            filter .18s ease;
    }

    .cart-premium-page .checkout-btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 65%;
        height: 100%;
        transform: skewX(-20deg);
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.18),
            transparent
        );
        transition: left .45s ease;
    }

    .cart-premium-page .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(72,99,59,.25);
    }

    .cart-premium-page .checkout-btn:hover::after {
        left: 145%;
    }

    /* Empty cart */
    .cart-premium-page .card.border-0.shadow-sm {
        position: relative;
        overflow: hidden;
        border: 1px dashed #dcc19a !important;
        border-radius: 26px !important;
        background:
            radial-gradient(circle at 50% 0%, rgba(242,193,92,.14), transparent 30%),
            linear-gradient(180deg,#fffdf9,#fff9ee);
        box-shadow: 0 18px 42px rgba(95,52,29,.07) !important;
    }

    .cart-premium-page .card.border-0.shadow-sm::after {
        content: "🌿";
        position: absolute;
        right: 10%;
        bottom: -35px;
        font-size: 130px;
        opacity: .045;
        transform: rotate(-18deg);
    }

    .cart-premium-page .card.border-0.shadow-sm .card-body {
        position: relative;
        z-index: 1;
    }

    .cart-premium-page .card.border-0.shadow-sm .btn-primary {
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg,#a83b2d,#5f341d);
        font-weight: 800;
        box-shadow: 0 9px 20px rgba(168,59,45,.16);
    }

    /* Alerts */
    .cart-premium-page .alert {
        border-radius: 15px;
        border-width: 1px;
        box-shadow: 0 8px 22px rgba(95,52,29,.06) !important;
    }

    @media (max-width: 991.98px) {
        .cart-premium-page {
            padding-top: 24px !important;
        }

        .cart-premium-page .cart-card,
        .cart-premium-page .summary-card,
        .cart-premium-page .continue-card {
            border-radius: 20px;
        }
    }

    @media (max-width: 767.98px) {
        .cart-premium-page::after {
            display: none;
        }

        .cart-premium-page .cart-table thead {
            display: none;
        }

        .cart-premium-page .cart-table,
        .cart-premium-page .cart-table tbody,
        .cart-premium-page .cart-table tr,
        .cart-premium-page .cart-table td {
            display: block;
            width: 100%;
        }

        .cart-premium-page .cart-table tbody tr {
            padding: 14px 16px;
            border-bottom: 1px solid #ead8bf;
        }

        .cart-premium-page .cart-table tbody tr:last-child {
            border-bottom: 0;
        }

        .cart-premium-page .cart-table tbody td {
            padding: 8px 0 !important;
            border: 0;
            text-align: left !important;
        }

        .cart-premium-page .cart-table tbody td:last-child {
            padding-top: 12px !important;
        }

        .cart-premium-page .input-group {
            max-width: 155px;
        }
    }

    @media (max-width: 575.98px) {
        .cart-premium-page .cart-page-title {
            font-size: 29px;
        }

        .cart-premium-page .summary-card .card-body,
        .cart-premium-page .continue-card .card-body {
            padding: 22px !important;
        }

        .cart-premium-page .summary-total {
            font-size: 28px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .cart-premium-page *,
        .cart-premium-page *::before,
        .cart-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="cart-premium-page container py-4">

    <div class="row justify-content-center">

        <div class="col-xl-11 col-lg-12">

            <div class="mb-4">
                <h2 class="cart-page-title mb-1">
                    🛒 Giỏ hàng của bạn
                </h2>

                <p class="text-muted mb-0">
                    Kiểm tra số lượng hoặc khối lượng
                    trước khi tiến hành đặt hàng
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    ✅ {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    ❌ {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <strong>❌ Có lỗi xảy ra:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(count($cart) > 0)

                @php
                    $total = 0;
                @endphp

                <div class="card cart-card mb-4">

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover cart-table align-middle mb-0">

                                <thead>
                                    <tr>
                                        <th class="ps-4">
                                            Tên sản phẩm
                                        </th>

                                        <th>
                                            Danh mục
                                        </th>

                                        <th>
                                            Đơn giá
                                        </th>

                                        <th style="width: 245px;">
                                            Số lượng / Khối lượng
                                        </th>

                                        <th>
                                            Thành tiền
                                        </th>

                                        <th class="text-center pe-4">
                                            Hành động
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($cart as $id => $details)

                                        @php
                                            $price = (float) $details['price'];
                                            $quantity = (float) $details['quantity'];
                                            $unit = $details['unit'] ?? 'sản phẩm';
                                            $minQty = (float) ($details['min_quantity'] ?? 1);
                                            $stepQty = (float) ($details['quantity_step'] ?? 1);

                                            $subtotal =
                                                $price * $quantity;

                                            $total += $subtotal;

                                            $displayQty =
                                                rtrim(
                                                    rtrim(
                                                        number_format(
                                                            $quantity,
                                                            2,
                                                            '.',
                                                            ''
                                                        ),
                                                        '0'
                                                    ),
                                                    '.'
                                                );
                                        @endphp

                                        <tr>

                                            <td class="ps-4">
                                                <div class="product-name">
                                                    {{ $details['name'] }}
                                                </div>

                                                <span class="unit-pill mt-1">
                                                    Bán theo {{ $unit }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $details['category'] ?? 'Chưa phân loại' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="fw-bold">
                                                    {{
                                                        number_format(
                                                            $price,
                                                            0,
                                                            ',',
                                                            '.'
                                                        )
                                                    }} đ
                                                </div>

                                                <small class="text-muted">
                                                    / {{ $unit }}
                                                </small>
                                            </td>

                                            <td>

                                                <form
                                                    action="{{ route(
                                                        'cart.update',
                                                        ['id' => $id]
                                                    ) }}"
                                                    method="POST"
                                                    class="d-flex align-items-center flex-wrap gap-2"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="input-group input-group-sm"
                                                         style="width:145px;">

                                                        <input
                                                            type="number"
                                                            name="quantity"
                                                            value="{{ $displayQty }}"
                                                            min="{{ $minQty }}"
                                                            step="{{ $stepQty }}"
                                                            required
                                                            class="form-control"
                                                        >

                                                        <span class="input-group-text">
                                                            {{ $unit }}
                                                        </span>

                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary btn-sm"
                                                    >
                                                        Cập nhật
                                                    </button>
                                                </form>

                                                <small class="text-muted d-block mt-1">
                                                    Bước tăng:
                                                    {{ $stepQty }}
                                                    {{ $unit }}
                                                </small>
                                            </td>

                                            <td class="money">
                                                {{
                                                    number_format(
                                                        $subtotal,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }} đ
                                            </td>

                                            <td class="text-center pe-4">

                                                <form
                                                    action="{{ route(
                                                        'cart.destroy',
                                                        ['product' => $id]
                                                    ) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                                    >
                                                        🗑 Xóa
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="row g-4 align-items-stretch">

                    <div class="col-lg-5">

                        <div class="card continue-card h-100">

                            <div class="card-body p-4 d-flex flex-column justify-content-center">

                                <div style="font-size:40px;" class="mb-2">
                                    🌿
                                </div>

                                <h5 class="fw-bold mb-2">
                                    Muốn mua thêm đặc sản?
                                </h5>

                                <p class="text-muted mb-4">
                                    Bạn có thể tiếp tục mua sắm trước
                                    khi tiến hành đặt hàng.
                                </p>

                                <div>
                                    <a
                                        href="{{ route('products.index') }}"
                                        class="btn btn-outline-secondary continue-btn"
                                    >
                                        ← Tiếp tục mua sắm
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-7">

                        <div class="card summary-card h-100">

                            <div class="card-body p-4">

                                <h5 class="fw-bold mb-4">
                                    🧾 Tổng đơn hàng
                                </h5>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">
                                        Tổng tiền sản phẩm
                                    </span>

                                    <strong>
                                        {{
                                            number_format(
                                                $total,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} đ
                                    </strong>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">
                                        Phí vận chuyển
                                    </span>

                                    <span class="text-muted">
                                        Chọn ở bước thanh toán
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">
                                        Voucher
                                    </span>

                                    <span class="text-muted">
                                        Áp dụng ở bước thanh toán
                                    </span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-end mb-4">

                                    <div>
                                        <div class="fw-bold fs-5">
                                            Tạm tính
                                        </div>

                                        <small class="text-muted">
                                            Chưa bao gồm phí vận chuyển
                                            và giảm giá
                                        </small>
                                    </div>

                                    <div class="summary-total">
                                        {{
                                            number_format(
                                                $total,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} đ
                                    </div>

                                </div>

                                <a
                                    href="{{ route('checkout') }}"
                                    class="btn btn-success btn-lg w-100 checkout-btn"
                                >
                                    🛒 Tiến hành đặt hàng
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @else

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <div style="font-size:65px;" class="mb-3">
                            🛒
                        </div>

                        <h4 class="fw-bold">
                            Giỏ hàng đang trống
                        </h4>

                        <p class="text-muted">
                            Bạn chưa thêm sản phẩm nào vào giỏ hàng.
                        </p>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-primary btn-lg"
                        >
                            🌿 Mua sắm ngay
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
