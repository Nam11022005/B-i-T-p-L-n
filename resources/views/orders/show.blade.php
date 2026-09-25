@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<style>

    .order-card {
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .order-header {
        background: linear-gradient(90deg, #f8f9ff, #eef2ff);
        border-bottom: 1px solid #e5e7eb;
    }

    .status-badge {
        font-size: 14px;
        padding: 9px 15px;
        border-radius: 30px;
    }

    .tracking-wrapper {
        position: relative;
        margin-top: 25px;
        margin-bottom: 30px;
    }

    .tracking-line {
        position: absolute;
        top: 23px;
        left: 12.5%;
        right: 12.5%;
        height: 4px;
        background: #e5e7eb;
        z-index: 1;
    }

    .tracking-progress {
        position: absolute;
        top: 23px;
        left: 12.5%;
        height: 4px;
        background: #198754;
        z-index: 2;
        transition: width 0.4s ease;
    }

    .tracking-step {
        position: relative;
        z-index: 3;
        text-align: center;
    }

    .tracking-circle {
        width: 48px;
        height: 48px;
        margin: auto;
        border-radius: 50%;
        background: #e5e7eb;
        color: #6c757d;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        border: 4px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    .tracking-circle.active {
        background: #198754;
        color: white;
    }

    .tracking-circle.current {
        background: #0d6efd;
        color: white;
    }

    .tracking-label {
        margin-top: 8px;
        font-size: 13px;
        color: #6c757d;
    }

    .tracking-label.active {
        color: #198754;
        font-weight: bold;
    }

    .tracking-label.current {
        color: #0d6efd;
        font-weight: bold;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 18px;
        height: 100%;
    }

    .product-table th {
        white-space: nowrap;
    }

    .filter-btn {
        border-radius: 25px;
        padding-left: 15px;
        padding-right: 15px;
    }

    @media (max-width: 768px) {
        .tracking-label {
            font-size: 11px;
        }

        .tracking-circle {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .tracking-line,
        .tracking-progress {
            top: 19px;
        }
    }


    .review-action-btn {
        border-radius: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .order-review-box {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 14px;
        padding: 18px;
    }

    .order-review-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
    }

    .order-review-stars input {
        display: none;
    }

    .order-review-stars label {
        cursor: pointer;
        font-size: 30px;
        color: #d6d3d1;
        transition: .15s ease;
        margin: 0;
    }

    .order-review-stars label:hover,
    .order-review-stars label:hover ~ label,
    .order-review-stars input:checked ~ label {
        color: #f59e0b;
    }



    /* =========================================================
       ORDER DETAIL PREMIUM UI
       CHỈ NÂNG GIAO DIỆN - KHÔNG ĐỔI ROUTE / DATA / JS / FORM
    ========================================================= */

    .order-detail-premium-page {
        position: relative;
        isolation: isolate;
        padding-top: 34px;
        padding-bottom: 76px;
    }

    .order-detail-premium-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -30px;
        left: 50%;
        width: min(100vw, 1680px);
        height: 800px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.18), transparent 24%),
            radial-gradient(circle at 94% 12%, rgba(72,99,59,.13), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.98),rgba(255,255,255,0));
    }

    .order-detail-premium-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 145px;
        right: -55px;
        width: 215px;
        height: 215px;
        opacity: .10;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.35) 0 1px,
                transparent 1px 13px
            );
    }

    /* HERO */
    .order-detail-hero {
        position: relative;
        overflow: hidden;
        min-height: 170px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 32px 35px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 16%, rgba(242,193,92,.22), transparent 29%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.28), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 53%,#48633b 100%);
        box-shadow:
            0 23px 58px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
    }

    .order-detail-hero::before {
        content: "";
        position: absolute;
        right: -26px;
        bottom: -50px;
        width: 310px;
        height: 174px;
        opacity: .10;
        pointer-events: none;
        clip-path: polygon(0 100%,18% 57%,35% 73%,54% 25%,70% 58%,86% 33%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
    }

    .order-detail-hero > * {
        position: relative;
        z-index: 2;
    }

    .order-detail-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        margin-bottom: 9px;
        border: 1px solid rgba(242,193,92,.30);
        border-radius: 999px;
        color: #f6d98c;
        background: rgba(255,255,255,.055);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .order-detail-hero h2 {
        color: #fff;
        font-size: clamp(29px,3vw,42px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .order-detail-hero p {
        color: rgba(255,255,255,.76);
        line-height: 1.65;
    }

    .order-back-btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        padding: 9px 17px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,.26);
        color: #fff;
        background: rgba(255,255,255,.08);
        font-weight: 800;
        backdrop-filter: blur(10px);
        transition:
            background .18s ease,
            transform .18s ease,
            border-color .18s ease;
    }

    .order-back-btn:hover {
        color: #fff;
        background: rgba(255,255,255,.15);
        border-color: rgba(255,255,255,.40);
        transform: translateY(-1px);
    }

    /* AUTO PAYMENT */
    .auto-payment-premium-card {
        overflow: hidden;
        border: 1px solid #dcc096 !important;
        border-radius: 24px !important;
        box-shadow: 0 18px 45px rgba(95,52,29,.10) !important;
    }

    .auto-payment-premium-card > .card-header {
        border: 0;
        padding: 15px 20px !important;
        background:
            linear-gradient(135deg,#5f341d,#48633b) !important;
    }

    .auto-payment-premium-card .bg-white.border.rounded-4 {
        border-color: #ead8bf !important;
        box-shadow: 0 13px 30px rgba(95,52,29,.10) !important;
    }

    .auto-payment-premium-card .input-group {
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(95,52,29,.05);
    }

    /* ORDER MAIN CARD */
    .order-detail-premium-page .order-card {
        position: relative;
        border: 1px solid #e5d0b3 !important;
        border-radius: 26px;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 20px 52px rgba(95,52,29,.09) !important,
            inset 0 1px 0 rgba(255,255,255,.94);
    }

    .order-detail-premium-page .order-card::before {
        content: "";
        position: absolute;
        z-index: 2;
        top: 0;
        left: 7%;
        right: 7%;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,transparent,#f2c15c,#d97706,#48633b,transparent);
        opacity: .60;
    }

    .order-detail-premium-page .order-card:hover {
        transform: none;
        box-shadow:
            0 24px 58px rgba(95,52,29,.115) !important;
    }

    .order-detail-premium-page .order-header {
        padding: 24px !important;
        border-bottom-color: #ead8bf;
        background:
            radial-gradient(circle at 94% 10%, rgba(242,193,92,.14), transparent 24%),
            linear-gradient(90deg,#fffaf0,#f8efe2);
    }

    .order-detail-premium-page .status-badge {
        box-shadow: 0 6px 14px rgba(0,0,0,.08);
    }

    /* TRACKING */
    .order-detail-premium-page .tracking-wrapper {
        margin-top: 32px;
        padding: 24px 10px 8px;
        border: 1px solid #ead8bf;
        border-radius: 20px;
        background:
            linear-gradient(180deg,#fffdf9,#fff9ef);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.95);
    }

    .order-detail-premium-page .tracking-line {
        top: 47px;
        height: 5px;
        border-radius: 999px;
        background: #eee3d5;
    }

    .order-detail-premium-page .tracking-progress {
        top: 47px;
        height: 5px;
        border-radius: 999px;
        background: linear-gradient(90deg,#48633b,#68a15a);
        box-shadow: 0 0 0 2px rgba(72,99,59,.06);
    }

    .order-detail-premium-page .tracking-circle {
        width: 52px;
        height: 52px;
        border: 5px solid #fff;
        background: #eee7df;
        color: #8e8177;
        box-shadow:
            0 5px 15px rgba(95,52,29,.09),
            0 0 0 1px #ead8bf;
        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }

    .order-detail-premium-page .tracking-circle.active {
        background: linear-gradient(135deg,#48633b,#5f8b4d);
    }

    .order-detail-premium-page .tracking-circle.current {
        background: linear-gradient(135deg,#a83b2d,#d97706);
        box-shadow:
            0 7px 18px rgba(168,59,45,.18),
            0 0 0 5px rgba(242,193,92,.12);
        transform: scale(1.06);
    }

    .order-detail-premium-page .tracking-label.active {
        color: #48633b;
    }

    .order-detail-premium-page .tracking-label.current {
        color: #a83b2d;
    }

    /* INFO BOXES */
    .order-detail-premium-page .info-box {
        position: relative;
        overflow: hidden;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.10), transparent 28%),
            linear-gradient(180deg,#fffdf9,#fff9f1);
        box-shadow: 0 8px 22px rgba(95,52,29,.055);
    }

    .order-detail-premium-page .info-box::after {
        content: "🌿";
        position: absolute;
        right: 13px;
        bottom: -8px;
        font-size: 60px;
        opacity: .035;
        transform: rotate(-14deg);
        pointer-events: none;
    }

    .order-detail-premium-page .info-box h5 {
        position: relative;
        padding-bottom: 11px;
        color: #392820;
    }

    .order-detail-premium-page .info-box h5::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 62px;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,#d97706,#48633b);
    }

    .order-detail-premium-page .info-box .badge {
        padding: 7px 10px;
        border-radius: 999px;
    }

    /* PRODUCT TABLE */
    .order-detail-premium-page .table-responsive {
        overflow: hidden;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(95,52,29,.055);
    }

    .order-detail-premium-page .product-table thead th {
        padding: 15px 16px;
        border-bottom-color: #e8d7c0;
        background: linear-gradient(180deg,#fff8ea,#f8efe2);
        color: #5f341d;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .order-detail-premium-page .product-table tbody td {
        padding: 17px 16px;
        border-color: #f0e4d5;
    }

    .order-detail-premium-page .product-table tbody tr {
        transition: background .17s ease;
    }

    .order-detail-premium-page .product-table tbody tr:hover {
        background: #fffaf2;
    }

    .order-detail-premium-page .product-table .badge.bg-light {
        padding: 7px 10px;
        border-radius: 999px;
        background: #fff8eb !important;
        border-color: #e6cfad !important;
    }

    /* REVIEW */
    .order-detail-premium-page .review-action-btn {
        border-radius: 999px;
        padding: 7px 12px;
    }

    .order-detail-premium-page .order-review-box {
        border-radius: 18px;
        border-color: #e4c99e;
        background:
            radial-gradient(circle at 96% 8%, rgba(242,193,92,.12), transparent 25%),
            linear-gradient(180deg,#fffaf0,#fff6e7);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .order-detail-premium-page .order-review-stars label {
        transition: transform .14s ease, color .14s ease;
    }

    .order-detail-premium-page .order-review-stars label:hover {
        transform: scale(1.10);
    }

    /* FOOTER */
    .order-detail-premium-page .order-card .card-footer {
        padding: 16px 20px !important;
        border-top-color: #ead8bf !important;
        background:
            linear-gradient(180deg,#fffaf4,#f8efe2) !important;
    }

    .order-detail-premium-page .order-card .card-footer .btn-primary {
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg,#a83b2d,#5f341d);
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(168,59,45,.15);
    }

    /* ALERTS */
    .order-detail-premium-page .alert {
        border-radius: 15px;
        border-width: 1px;
    }

    @media (max-width: 768px) {
        .order-detail-premium-page {
            padding-top: 22px;
        }

        .order-detail-premium-page::after {
            display: none;
        }

        .order-detail-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .order-detail-premium-page .order-card {
            border-radius: 20px;
        }

        .order-detail-premium-page .tracking-wrapper {
            padding-inline: 2px;
        }

        .order-detail-premium-page .tracking-line,
        .order-detail-premium-page .tracking-progress {
            top: 43px;
        }

        .order-detail-premium-page .tracking-circle {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }

        .order-detail-premium-page .table-responsive {
            border-radius: 15px;
        }
    }

    @media (max-width: 575.98px) {
        .order-detail-premium-page .tracking-label {
            font-size: 10px;
        }

        .order-detail-premium-page .tracking-circle {
            width: 40px;
            height: 40px;
            border-width: 4px;
        }

        .order-detail-premium-page .tracking-line,
        .order-detail-premium-page .tracking-progress {
            top: 41px;
        }

        .order-detail-premium-page .info-box {
            padding: 16px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .order-detail-premium-page *,
        .order-detail-premium-page *::before,
        .order-detail-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="order-detail-premium-page row justify-content-center">
    <div class="col-xl-11 col-lg-12">

        <section class="order-detail-hero mb-4">
            <div>
                <div class="order-detail-kicker">🌿 TINH HOA TÂY BẮC</div>

                <h2 class="fw-bold mb-2">
                    📦 Chi tiết đơn hàng
                    #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </h2>

                <p class="mb-0">
                    Theo dõi trạng thái, thanh toán và toàn bộ sản phẩm trong đơn hàng.
                </p>
            </div>

            <a href="{{ route('orders.index') }}" class="order-back-btn btn">
                ← Quay lại danh sách
            </a>
        </section>

        @php
            $statusClass = [
                'pending' => 'warning',
                'confirmed' => 'info',
                'shipped' => 'primary',
                'delivered' => 'success',
                'cancelled' => 'danger',
            ][$order->status] ?? 'secondary';

            $statusText = [
                'pending' => '⏳ Chờ xác nhận',
                'confirmed' => '✓ Đã xác nhận',
                'shipped' => '🚚 Đang giao hàng',
                'delivered' => '✅ Đã giao hàng',
                'cancelled' => '❌ Đã hủy',
            ][$order->status] ?? 'Không xác định';

            $statusStep = [
                'pending' => 1,
                'confirmed' => 2,
                'shipped' => 3,
                'delivered' => 4,
            ][$order->status] ?? 0;

            $progressWidth = match($statusStep) {
                1 => '0%',
                2 => '33.33%',
                3 => '66.66%',
                4 => '75%',
                default => '0%',
            };
        @endphp


        @if($order->payment_method === 'bank')
            <div
                class="card shadow-sm border-0 mb-4 auto-payment-premium-card"
                id="autoPaymentCard"
                data-payment-status-url="{{ route('orders.paymentStatus', $order->id) }}"
            >
                <div class="card-header bg-primary text-white py-3">
                    <strong>💳 Thanh toán QR tự động</strong>
                </div>

                <div class="card-body p-4">

                    @if($order->payment_status === 'paid')

                        <div class="alert alert-success mb-0" id="paymentSuccessBox">
                            <h5 class="fw-bold mb-1">✅ Thanh toán thành công</h5>
                            <div>
                                Hệ thống đã ghi nhận thanh toán cho đơn
                                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}.
                            </div>
                        </div>

                    @else

                        <div id="paymentWaitingBox">
                            <div class="alert alert-warning">
                                ⏳ Đang chờ thanh toán. Hãy chuyển
                                <strong>đúng số tiền</strong> và giữ nguyên
                                <strong>nội dung chuyển khoản</strong>.
                            </div>

                            <div class="row g-4 align-items-center">
                                <div class="col-lg-5 text-center">
                                    @php
                                        $bankCode = 'MB';
                                        $accountNumber = '0385742505';
                                        $accountName = 'DO PHUONG NAM';
                                        $qrAmount = (int) round((float) $order->total_price);
                                        $qrContent = $order->payment_code;

                                        $qrUrl =
                                            'https://img.vietqr.io/image/' .
                                            $bankCode . '-' .
                                            $accountNumber .
                                            '-compact2.png?amount=' .
                                            $qrAmount .
                                            '&addInfo=' .
                                            urlencode($qrContent) .
                                            '&accountName=' .
                                            urlencode($accountName);
                                    @endphp

                                    <div class="bg-white border rounded-4 p-3 d-inline-block shadow-sm">
                                        <img
                                            src="{{ $qrUrl }}"
                                            alt="QR thanh toán đơn hàng"
                                            class="img-fluid"
                                            style="width:300px;max-width:100%;"
                                        >
                                    </div>

                                    <div class="small text-muted mt-2">
                                        Mở ứng dụng ngân hàng và quét mã QR
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="mb-3">
                                        <div class="text-muted small">Ngân hàng</div>
                                        <div class="fw-bold fs-5">MB BANK</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Số tài khoản</div>
                                        <div class="fw-bold fs-4 text-primary">0385742505</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Chủ tài khoản</div>
                                        <div class="fw-bold">ĐỖ PHƯƠNG NAM</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Số tiền</div>
                                        <div class="fw-bold fs-3 text-danger">
                                            {{ number_format($order->total_price, 0, ',', '.') }} đ
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Nội dung chuyển khoản</div>

                                        <div class="input-group">
                                            <input
                                                type="text"
                                                id="orderPaymentCode"
                                                class="form-control fw-bold"
                                                value="{{ $order->payment_code }}"
                                                readonly
                                            >

                                            <button
                                                class="btn btn-outline-primary"
                                                type="button"
                                                onclick="copyOrderPaymentCode()"
                                            >
                                                📋 Sao chép
                                            </button>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mb-0">
                                        🔄 Trang đang tự kiểm tra trạng thái thanh toán.
                                        Khi SePay nhận giao dịch hợp lệ, thông báo thành công
                                        sẽ tự xuất hiện mà không cần tải lại trang.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="alert alert-success d-none mb-0"
                            id="paymentSuccessBox"
                        >
                            <h5 class="fw-bold mb-1">✅ Thanh toán thành công</h5>
                            <div>
                                Hệ thống đã nhận được tiền và xác nhận thanh toán cho đơn hàng.
                            </div>
                        </div>

                    @endif

                </div>
            </div>
        @endif


                <div class="card order-card shadow-sm border-0 mb-4">


                    {{-- ==============================
                        HEADER ĐƠN HÀNG
                    ============================== --}}
                    <div class="card-header order-header p-4">

                        <div class="row align-items-center">


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Mã đơn hàng
                                </div>

                                <h5 class="fw-bold mb-1">

                                    #{{ str_pad(
                                        $order->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </h5>


                                <small class="text-muted">

                                    🕐 Đặt lúc:

                                    {{ $order->created_at
                                        ->format('d/m/Y H:i') }}

                                </small>

                            </div>


                            <div class="col-md-6 text-md-end mt-3 mt-md-0">

                                <div class="text-muted small mb-2">

                                    Trạng thái hiện tại

                                </div>


                                <span class="
                                    badge
                                    bg-{{ $statusClass }}
                                    status-badge">

                                    {{ $statusText }}

                                </span>

                            </div>


                        </div>

                    </div>



                    <div class="card-body p-4">


                        {{-- ==============================
                            ĐƠN HÀNG BỊ HỦY
                        ============================== --}}
                        @if($order->status === 'cancelled')

                            <div class="alert alert-danger">

                                <div class="d-flex align-items-center">

                                    <div class="fs-2 me-3">
                                        ❌
                                    </div>

                                    <div>

                                        <strong>
                                            Đơn hàng đã bị hủy
                                        </strong>

                                        <div class="small mt-1">

                                            Đơn hàng này hiện không còn
                                            trong quá trình giao hàng.

                                        </div>

                                    </div>

                                </div>

                            </div>


                        @else


                            {{-- ==============================
                                THEO DÕI ĐƠN HÀNG
                            ============================== --}}
                            <div class="mb-5">


                                <h5 class="fw-bold mb-1">

                                    🚚 Theo dõi đơn hàng

                                </h5>


                                <p class="text-muted small">

                                    Trạng thái được cập nhật bởi cửa hàng

                                </p>



                                <div class="tracking-wrapper">


                                    {{-- Đường xám --}}
                                    <div class="tracking-line"></div>


                                    {{-- Đường xanh --}}
                                    <div class="tracking-progress"
                                         style="width: {{ $progressWidth }};">
                                    </div>



                                    <div class="row g-0">


                                        {{-- =====================
                                            BƯỚC 1
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle
                                                {{ $statusStep > 1
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 1
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                🛒

                                            </div>


                                            <div class="
                                                tracking-label
                                                {{ $statusStep > 1
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 1
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Chờ xác nhận

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 2
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep > 2
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 2
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                ✓

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep > 2
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 2
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Đã xác nhận

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 3
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep > 3
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 3
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                🚚

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep > 3
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 3
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Đang giao

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 4
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep >= 4
                                                    ? 'active'
                                                    : '' }}
                                            ">

                                                ✅

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep >= 4
                                                    ? 'active'
                                                    : '' }}
                                            ">

                                                Đã giao

                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </div>

                        @endif



                        {{-- ==============================
                            THÔNG TIN ĐƠN HÀNG
                        ============================== --}}
                        <div class="row g-4 mb-4">


                            {{-- GIAO HÀNG --}}
                            <div class="col-md-7">

                                <div class="info-box">

                                    <h5 class="fw-bold mb-3">

                                        📍 Thông tin giao hàng

                                    </h5>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Người nhận:

                                        </span>

                                        <strong>

                                            {{ $order->customer_name
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Số điện thoại:

                                        </span>

                                        <strong>

                                            {{ $order->customer_phone
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Địa chỉ:

                                        </span>

                                        <strong>

                                            {{ $order->shipping_address
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    @if($order->notes)

                                        <div class="mt-3">

                                            <span class="text-muted">

                                                Ghi chú:

                                            </span>

                                            {{ $order->notes }}

                                        </div>

                                    @endif


                                </div>

                            </div>



{{-- THANH TOÁN --}}
<div class="col-md-5">

    <div class="info-box">

        <h5 class="fw-bold mb-3">
            💳 Thanh toán
        </h5>


        {{-- PHƯƠNG THỨC THANH TOÁN --}}
        <div class="mb-3">

            <div class="text-muted small mb-1">
                Phương thức
            </div>

            @if($order->payment_method === 'cod')

                <span class="badge bg-secondary">
                    💵 Thanh toán khi nhận hàng
                </span>

            @elseif($order->payment_method === 'bank')

                <span class="badge bg-primary">
                    🏦 Chuyển khoản ngân hàng
                </span>

            @else

                <span class="badge bg-secondary">
                    {{ strtoupper(
                        $order->payment_method ?? 'Không xác định'
                    ) }}
                </span>

            @endif

        </div>


        <hr>


        {{-- TRẠNG THÁI THANH TOÁN --}}
        <div class="mb-3">

            <div class="text-muted small mb-2">
                Trạng thái thanh toán
            </div>


            {{-- ĐÃ THANH TOÁN --}}
            @if($order->payment_status === 'paid')

                <div class="alert alert-success mb-0">

                    <strong>
                        ✅ Đã thanh toán
                    </strong>

                    <div class="small mt-1">
                        Shop đã xác nhận nhận được tiền.
                    </div>

                </div>


            {{-- CHỜ ADMIN XÁC NHẬN --}}
            @elseif($order->payment_status === 'pending_confirmation')

                <div class="alert alert-warning">

                    <strong>
                        ⏳ Chờ xác nhận chuyển khoản
                    </strong>

                    <div class="small mt-1">
                        Shop đang kiểm tra giao dịch chuyển khoản của bạn.
                        Trạng thái sẽ được cập nhật sau khi thanh toán được xác nhận.
                    </div>

                </div>


            {{-- CHƯA THANH TOÁN --}}
            @else

                <div class="alert alert-secondary mb-0">

                    <strong>
                        💵 Chưa thanh toán
                    </strong>

                    @if($order->payment_method === 'cod')

                        <div class="small mt-1">
                            Khách hàng sẽ thanh toán khi nhận hàng.
                        </div>

                    @endif

                </div>

            @endif

        </div>


        <hr>


        {{-- TỔNG THANH TOÁN --}}
        <div class="text-muted small">
            Tổng thanh toán
        </div>

        <h3 class="text-danger fw-bold mb-0">

            {{ number_format(
                $order->total_price,
                0,
                ',',
                '.'
            ) }} đ

        </h3>

    </div>

</div>


                        </div>



                        {{-- ==============================
                            DANH SÁCH SẢN PHẨM
                        ============================== --}}
                        <div>

                            <h5 class="fw-bold mb-3">

                                📦 Sản phẩm trong đơn hàng

                            </h5>


                            <div class="table-responsive">

                                <table class="
                                    table
                                    table-hover
                                    product-table
                                    align-middle
                                    mb-0">


                                    <thead class="table-light">

                                        <tr>

                                            <th>
                                                Sản phẩm
                                            </th>

                                            <th>
                                                Đơn giá
                                            </th>

                                            <th class="text-center">
                                                Số lượng
                                            </th>

                                            <th class="text-end">
                                                Thành tiền
                                            </th>

                                            @if($order->status === 'delivered')
                                                <th class="text-center">
                                                    Đánh giá
                                                </th>
                                            @endif

                                        </tr>

                                    </thead>


                                    <tbody>


                                        @forelse(
                                            $order->items
                                            as $item
                                        )

                                            <tr>

                                                <td>

                                                    <strong>

                                                        {{ $item->product->name
                                                            ?? 'Sản phẩm' }}

                                                    </strong>

                                                </td>


                                                <td>

                                                    {{ number_format(
                                                        $item->price,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }} đ

                                                </td>


                                                <td class="text-center">

                                                    <span class="
                                                        badge
                                                        bg-light
                                                        text-dark
                                                        border">

                                                        {{ $item->quantity }}

                                                    </span>

                                                </td>


                                                <td class="
                                                    fw-bold
                                                    text-danger
                                                    text-end">

                                                    {{ number_format(
                                                        $item->price
                                                        *
                                                        $item->quantity,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }} đ

                                                </td>

                                                @if($order->status === 'delivered')
                                                    @php
                                                        $myReview = \App\Models\Review::where(
                                                                'user_id',
                                                                Auth::id()
                                                            )
                                                            ->where(
                                                                'product_id',
                                                                $item->product_id
                                                            )
                                                            ->first();

                                                        $reviewCollapseId =
                                                            'review-order-item-' . $item->id;
                                                    @endphp

                                                    <td class="text-center">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm review-action-btn
                                                                {{ $myReview
                                                                    ? 'btn-outline-success'
                                                                    : 'btn-outline-warning'
                                                                }}"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#{{ $reviewCollapseId }}"
                                                            aria-expanded="false"
                                                        >
                                                            @if($myReview)
                                                                ⭐ Đã đánh giá
                                                            @else
                                                                ⭐ Đánh giá
                                                            @endif
                                                        </button>
                                                    </td>
                                                @endif

                                            </tr>

                                            @if($order->status === 'delivered')
                                                <tr class="border-0">
                                                    <td
                                                        colspan="5"
                                                        class="p-0 border-0"
                                                    >
                                                        <div
                                                            class="collapse"
                                                            id="{{ $reviewCollapseId }}"
                                                        >
                                                            <div class="order-review-box m-3 mt-2">

                                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                                                    <div>
                                                                        <h6 class="fw-bold mb-1">
                                                                            ⭐ {{
                                                                                $myReview
                                                                                    ? 'Chỉnh sửa đánh giá'
                                                                                    : 'Đánh giá sản phẩm'
                                                                            }}
                                                                        </h6>

                                                                        <div class="text-muted small">
                                                                            {{ $item->product->name ?? 'Sản phẩm' }}
                                                                        </div>
                                                                    </div>

                                                                    @if($myReview)
                                                                        <span class="badge bg-success">
                                                                            Đã đánh giá {{ $myReview->rating }}/5 sao
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                <form
                                                                    action="{{ route(
                                                                        'reviews.store',
                                                                        $item->product_id
                                                                    ) }}"
                                                                    method="POST"
                                                                >
                                                                    @csrf

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">
                                                                            Chọn số sao
                                                                        </label>

                                                                        <div class="order-review-stars">
                                                                            @for($star = 5; $star >= 1; $star--)
                                                                                <input
                                                                                    type="radio"
                                                                                    id="orderItem{{ $item->id }}Rating{{ $star }}"
                                                                                    name="rating"
                                                                                    value="{{ $star }}"
                                                                                    {{ (int) old(
                                                                                        'rating',
                                                                                        $myReview?->rating ?? 0
                                                                                    ) === $star
                                                                                        ? 'checked'
                                                                                        : ''
                                                                                    }}
                                                                                    required
                                                                                >

                                                                                <label
                                                                                    for="orderItem{{ $item->id }}Rating{{ $star }}"
                                                                                    title="{{ $star }} sao"
                                                                                >
                                                                                    ★
                                                                                </label>
                                                                            @endfor
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="orderItemComment{{ $item->id }}"
                                                                            class="form-label fw-bold"
                                                                        >
                                                                            Nhận xét
                                                                        </label>

                                                                        <textarea
                                                                            id="orderItemComment{{ $item->id }}"
                                                                            name="comment"
                                                                            class="form-control"
                                                                            rows="3"
                                                                            maxlength="1000"
                                                                            placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                                                                        >{{ old(
                                                                            'comment',
                                                                            $myReview?->comment
                                                                        ) }}</textarea>
                                                                    </div>

                                                                    <button
                                                                        type="submit"
                                                                        class="btn btn-success"
                                                                    >
                                                                        @if($myReview)
                                                                            ⭐ Cập nhật đánh giá
                                                                        @else
                                                                            ⭐ Gửi đánh giá
                                                                        @endif
                                                                    </button>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif


                                        @empty


                                            <tr>

                                                <td colspan="{{ $order->status === 'delivered' ? 5 : 4 }}"
                                                    class="
                                                        text-center
                                                        text-muted
                                                        py-4">

                                                    Không có sản phẩm
                                                    trong đơn hàng.

                                                </td>

                                            </tr>


                                        @endforelse


                                    </tbody>

                                </table>

                            </div>

                        </div>


                    </div>



                    {{-- ==============================
                        FOOTER
                    ============================== --}}
                    <div class="
                        card-footer
                        bg-light
                        border-top
                        p-3">


                        <div class="
                            d-flex
                            justify-content-between
                            align-items-center
                            flex-wrap
                            gap-3">


                            <small class="text-muted">

                                🔄 Cập nhật gần nhất:

                                <strong>

                                    {{ $order->updated_at
                                        ->format('d/m/Y H:i') }}

                                </strong>

                            </small>


                            <a href="{{ route('products.index') }}"
                               class="btn btn-primary">

                                🛍️ Tiếp tục mua sắm

                            </a>


                        </div>

                    </div>


                </div>

    </div>
</div>


<script>
function copyOrderPaymentCode()
{
    const input = document.getElementById('orderPaymentCode');

    if (!input) {
        return;
    }

    navigator.clipboard.writeText(input.value).then(function () {
        alert('Đã sao chép mã thanh toán!');
    });
}

(function startPaymentPolling()
{
    const card = document.getElementById('autoPaymentCard');
    const waitingBox = document.getElementById('paymentWaitingBox');
    const successBox = document.getElementById('paymentSuccessBox');

    if (!card || !waitingBox || !successBox) {
        return;
    }

    const statusUrl = card.dataset.paymentStatusUrl;

    let timer = null;

    async function checkPayment()
    {
        try {
            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            if (data.paid === true) {
                waitingBox.classList.add('d-none');
                successBox.classList.remove('d-none');

                if (timer) {
                    clearInterval(timer);
                }
            }
        } catch (error) {
            console.warn('Không kiểm tra được trạng thái thanh toán:', error);
        }
    }

    checkPayment();
    timer = setInterval(checkPayment, 3000);
})();
</script>


@endsection
