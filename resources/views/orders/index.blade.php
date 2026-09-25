@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')

<style>
    .orders-page {
        max-width: 1380px;
        margin: 0 auto;
    }

    .orders-heading {
        font-weight: 900;
        color: #2f241e;
    }

    .filter-btn {
        border-radius: 999px;
        padding: 9px 16px;
        font-weight: 600;
    }

    .order-list-card {
        border: 1px solid #ead8bf !important;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .order-list-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(95, 52, 29, .10) !important;
    }

    .order-list-header {
        padding: 18px 22px;
        background: linear-gradient(90deg, #fffaf0, #f8efe2);
        border-bottom: 1px solid #ead8bf;
    }

    .order-code {
        font-size: 20px;
        font-weight: 900;
        color: #2f241e;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 14px;
        font-weight: 800;
    }

    .order-product-thumb {
        width: 58px;
        height: 58px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #ead8bf;
        background: #fffaf0;
    }

    .order-total {
        color: #dc3545;
        font-size: 23px;
        font-weight: 900;
    }

    .view-detail-btn {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 800;
        color: #fff;
        border: 0;
        text-decoration: none;
        background: linear-gradient(135deg, #a83b2d, #5f341d);
    }

    .view-detail-btn:hover {
        color: #fff;
        opacity: .92;
    }

    .summary-box {
        background: #fff;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 8px 22px rgba(95, 52, 29, .06);
    }

    .orders-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 35px;
        margin-bottom: 45px;
    }

    .page-btn {
        min-width: 44px;
        height: 44px;
        padding: 0 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #8b3a25;
        border-radius: 10px;
        background: #fff;
        color: #8b3a25;
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        transition: all .2s ease;
    }

    .page-btn:hover {
        background: #8b3a25;
        color: #fff;
        transform: translateY(-2px);
    }

    .page-btn.active {
        background: linear-gradient(135deg, #a83b2d, #5f341d);
        color: #fff;
        border-color: #5f341d;
        box-shadow: 0 5px 14px rgba(95, 52, 29, .25);
    }

    .page-btn.disabled {
        color: #aaa;
        background: #f5f5f5;
        border-color: #ddd;
        cursor: not-allowed;
    }



    /* =========================================================
       ORDERS INDEX PREMIUM UI
       CHỈ NÂNG GIAO DIỆN - KHÔNG ĐỔI ROUTE / DATA / LOGIC
    ========================================================= */

    .orders-page {
        position: relative;
        isolation: isolate;
        padding: 34px 12px 72px;
    }

    .orders-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -30px;
        left: 50%;
        width: min(100vw, 1680px);
        height: 680px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 10%, rgba(242,193,92,.18), transparent 24%),
            radial-gradient(circle at 94% 13%, rgba(72,99,59,.13), transparent 28%),
            linear-gradient(180deg, rgba(255,250,240,.98), rgba(255,255,255,0));
    }

    .orders-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        top: 120px;
        right: -45px;
        width: 205px;
        height: 205px;
        opacity: .11;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.34) 0 1px,
                transparent 1px 13px
            );
    }

    .orders-hero {
        position: relative;
        overflow: hidden;
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
        padding: 34px 38px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 87% 18%, rgba(242,193,92,.23), transparent 28%),
            radial-gradient(circle at 10% 120%, rgba(168,59,45,.28), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 53%,#48633b 100%);
        box-shadow:
            0 23px 58px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
    }

    .orders-hero::before {
        content: "";
        position: absolute;
        right: -30px;
        bottom: -55px;
        width: 320px;
        height: 180px;
        opacity: .10;
        clip-path: polygon(
            0 100%,
            18% 56%,
            36% 73%,
            53% 25%,
            70% 58%,
            86% 34%,
            100% 66%,
            100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .orders-hero-copy,
    .orders-hero-art {
        position: relative;
        z-index: 2;
    }

    .orders-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        margin-bottom: 9px;
        border-radius: 999px;
        border: 1px solid rgba(242,193,92,.30);
        color: #f6d98c;
        background: rgba(255,255,255,.055);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .orders-hero .orders-heading {
        color: #fff;
        font-size: clamp(30px,3.2vw,44px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .orders-hero p {
        max-width: 720px;
        color: rgba(255,255,255,.77);
        line-height: 1.65;
    }

    .orders-hero-art {
        width: 118px;
        height: 118px;
        flex: 0 0 118px;
        display: grid;
        place-items: center;
        border-radius: 32px;
        border: 1px solid rgba(255,255,255,.10);
        background: rgba(255,255,255,.06);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.08);
        transform: rotate(4deg);
    }

    .orders-hero-art span {
        font-size: 60px;
        filter: drop-shadow(0 8px 12px rgba(0,0,0,.16));
        transform: rotate(-4deg);
    }

    /* SUMMARY */
    .orders-page .summary-box {
        position: relative;
        overflow: hidden;
        min-height: 116px;
        padding: 21px 22px;
        border-radius: 20px;
        border-color: #e7d3b8;
        box-shadow:
            0 14px 35px rgba(95,52,29,.075),
            inset 0 1px 0 rgba(255,255,255,.95);
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .orders-page .summary-box:hover {
        transform: translateY(-4px);
        border-color: #dec092;
        box-shadow: 0 18px 40px rgba(95,52,29,.11);
    }

    .orders-page .summary-box::after {
        position: absolute;
        right: 18px;
        bottom: 8px;
        font-size: 48px;
        opacity: .09;
        pointer-events: none;
    }

    .summary-box-total {
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.16), transparent 34%),
            linear-gradient(180deg,#fff,#fffaf2);
    }

    .summary-box-total::after {
        content: "📋";
    }

    .summary-box-shipped {
        background:
            radial-gradient(circle at 100% 0%, rgba(13,110,253,.08), transparent 34%),
            linear-gradient(180deg,#fff,#fbfdff);
    }

    .summary-box-shipped::after {
        content: "🚚";
    }

    .summary-box-delivered {
        background:
            radial-gradient(circle at 100% 0%, rgba(72,99,59,.12), transparent 34%),
            linear-gradient(180deg,#fff,#fbfff9);
    }

    .summary-box-delivered::after {
        content: "✅";
    }

    .orders-page .summary-box .fs-3 {
        margin-top: 5px;
        color: #32241d;
        letter-spacing: -.5px;
    }

    /* FILTER */
    .orders-filter-bar {
        padding: 10px;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background: rgba(255,255,255,.82);
        box-shadow: 0 10px 28px rgba(95,52,29,.055);
        backdrop-filter: blur(10px);
    }

    .orders-filter-bar .filter-btn {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        border-width: 1px;
        font-weight: 800;
        transition:
            transform .16s ease,
            box-shadow .16s ease,
            filter .16s ease;
    }

    .orders-filter-bar .filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(95,52,29,.08);
    }

    /* ORDER CARD */
    .orders-page .order-list-card {
        position: relative;
        border-radius: 24px;
        border-color: #e6d1b5 !important;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 14px 38px rgba(95,52,29,.075) !important,
            inset 0 1px 0 rgba(255,255,255,.92);
        transition:
            transform .23s ease,
            box-shadow .23s ease,
            border-color .23s ease;
    }

    .orders-page .order-list-card::before {
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

    .orders-page .order-list-card:hover {
        transform: translateY(-6px);
        border-color: #ddbd8e !important;
        box-shadow: 0 23px 50px rgba(95,52,29,.13) !important;
    }

    .orders-page .order-list-header {
        padding: 20px 24px;
        background:
            radial-gradient(circle at 94% 12%, rgba(242,193,92,.12), transparent 24%),
            linear-gradient(90deg,#fffaf0,#f8efe2);
    }

    .orders-page .order-code {
        font-size: 22px;
        letter-spacing: -.35px;
    }

    .orders-page .status-pill {
        box-shadow: 0 6px 14px rgba(0,0,0,.08);
    }

    .orders-page .order-product-thumb {
        width: 64px;
        height: 64px;
        border-radius: 15px;
        box-shadow: 0 6px 14px rgba(95,52,29,.07);
    }

    .orders-page .card-body > .mb-3 > .d-flex {
        padding: 11px 8px !important;
        border-radius: 12px;
        transition: background .17s ease, transform .17s ease;
    }

    .orders-page .card-body > .mb-3 > .d-flex:hover {
        background: #fff9ef;
        transform: translateX(2px);
    }

    .orders-page .order-total {
        font-size: 26px;
        letter-spacing: -.6px;
        color: #a83b2d;
    }

    .orders-page .view-detail-btn {
        position: relative;
        overflow: hidden;
        min-height: 44px;
        padding: 11px 20px;
        border-radius: 13px;
        box-shadow: 0 8px 18px rgba(168,59,45,.16);
        transition:
            transform .17s ease,
            box-shadow .17s ease,
            filter .17s ease;
    }

    .orders-page .view-detail-btn:hover {
        transform: translateY(-2px);
        opacity: 1;
        box-shadow: 0 12px 24px rgba(168,59,45,.22);
    }

    /* EMPTY */
    .orders-page > .card.shadow-sm.border-0 {
        overflow: hidden;
        border: 1px dashed #dcbf95 !important;
        border-radius: 26px !important;
        background:
            radial-gradient(circle at 50% 0%, rgba(242,193,92,.14), transparent 31%),
            linear-gradient(180deg,#fffdf9,#fff9ee);
        box-shadow: 0 16px 38px rgba(95,52,29,.065) !important;
    }

    .orders-page > .card.shadow-sm.border-0 .btn-primary {
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg,#a83b2d,#5f341d);
        font-weight: 800;
    }

    /* PAGINATION */
    .orders-page .page-btn {
        border-radius: 12px;
        border-color: #b67757;
        box-shadow: 0 4px 10px rgba(95,52,29,.04);
    }

    .orders-page .page-btn.active {
        background: linear-gradient(135deg,#5f341d,#48633b);
        border-color: transparent;
    }

    @media (max-width: 767.98px) {
        .orders-page {
            padding-top: 22px;
        }

        .orders-page::after {
            display: none;
        }

        .orders-hero {
            padding: 27px 23px;
            border-radius: 22px;
        }

        .orders-hero-art {
            display: none;
        }

        .orders-filter-bar {
            padding: 8px;
        }

        .orders-filter-bar .filter-btn {
            flex: 1 1 auto;
            justify-content: center;
        }

        .orders-page .order-list-card {
            border-radius: 20px;
        }

        .orders-page .order-list-header {
            padding: 18px;
        }

        .orders-page .order-product-thumb {
            width: 56px;
            height: 56px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .orders-page *,
        .orders-page *::before,
        .orders-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="orders-page">

    <section class="orders-hero mb-4">
        <div class="orders-hero-copy">
            <div class="orders-kicker">🌿 TINH HOA TÂY BẮC</div>
            <h2 class="orders-heading mb-2">
                📋 Đơn hàng của tôi
            </h2>
            <p class="mb-0">
                Theo dõi hành trình đơn hàng, trạng thái giao nhận và lịch sử mua sắm của bạn.
            </p>
        </div>

        <div class="orders-hero-art" aria-hidden="true">
            <span>📦</span>
        </div>
    </section>

    {{-- THỐNG KÊ NHANH --}}
<div class="row g-3 mb-4">

    {{-- TỔNG ĐƠN HÀNG --}}
    <div class="col-md-4">
        <div class="summary-box summary-box-total">
            <div class="text-muted small">
                Tổng đơn hàng
            </div>

            <div class="fs-3 fw-bold">
                {{ $totalOrders }}
            </div>
        </div>
    </div>

    {{-- ĐANG GIAO --}}
    <div class="col-md-4">
        <div class="summary-box summary-box-shipped">
            <div class="text-muted small">
                Đang giao
            </div>

            <div class="fs-3 fw-bold text-primary">
                {{ $totalShipped }}
            </div>
        </div>
    </div>

    {{-- ĐÃ GIAO --}}
    <div class="col-md-4">
        <div class="summary-box summary-box-delivered">
            <div class="text-muted small">
                Đã giao
            </div>

            <div class="fs-3 fw-bold text-success">
                {{ $totalDelivered }}
            </div>
        </div>
    </div>

</div>
    {{-- BỘ LỌC --}}
    <div class="orders-filter-bar d-flex flex-wrap gap-2 mb-4">
        <a
            href="{{ route('orders.index') }}"
            class="btn filter-btn {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}"
        >
            📋 Tất cả
        </a>

        <a
            href="{{ route('orders.index', ['status' => 'pending']) }}"
            class="btn filter-btn {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}"
        >
            ⏳ Chờ xác nhận
        </a>

        <a
            href="{{ route('orders.index', ['status' => 'confirmed']) }}"
            class="btn filter-btn {{ request('status') === 'confirmed' ? 'btn-info' : 'btn-outline-info' }}"
        >
            ✓ Đã xác nhận
        </a>

        <a
            href="{{ route('orders.index', ['status' => 'shipped']) }}"
            class="btn filter-btn {{ request('status') === 'shipped' ? 'btn-primary' : 'btn-outline-primary' }}"
        >
            🚚 Đang giao
        </a>

        <a
            href="{{ route('orders.index', ['status' => 'delivered']) }}"
            class="btn filter-btn {{ request('status') === 'delivered' ? 'btn-success' : 'btn-outline-success' }}"
        >
            ✅ Đã giao
        </a>

        <a
            href="{{ route('orders.index', ['status' => 'cancelled']) }}"
            class="btn filter-btn {{ request('status') === 'cancelled' ? 'btn-danger' : 'btn-outline-danger' }}"
        >
            ❌ Đã hủy
        </a>
    </div>

    @if($orders->isEmpty())

        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <div style="font-size:60px;">📭</div>

                <h4 class="fw-bold mt-3">
                    {{ request('status') ? 'Không có đơn hàng nào' : 'Bạn chưa có đơn hàng' }}
                </h4>

                <p class="text-muted">
                    {{ request('status')
                        ? 'Không tìm thấy đơn hàng với trạng thái này.'
                        : 'Hãy lựa chọn sản phẩm và đặt đơn hàng đầu tiên.'
                    }}
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    🛍️ Mua sắm ngay
                </a>
            </div>
        </div>

    @else

        @foreach($orders as $order)

            @php
                $statusClass = [
                    'pending' => 'warning text-dark',
                    'confirmed' => 'info text-dark',
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

                $firstItems = $order->items->take(3);
                $remainingItems = max(0, $order->items->count() - 3);
            @endphp

            <div class="card order-list-card shadow-sm mb-4">

                <div class="order-list-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <div class="text-muted small">Mã đơn hàng</div>

                            <div class="order-code">
                                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="text-muted small mt-1">
                                🕐 {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <span class="badge bg-{{ $statusClass }} status-pill">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- XEM NHANH TỐI ĐA 3 SẢN PHẨM --}}
                    <div class="mb-3">
                        @foreach($firstItems as $item)
                            <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                @if($item->product && $item->product->image)
                                    <img
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                        class="order-product-thumb"
                                    >
                                @else
                                    <div class="order-product-thumb d-flex align-items-center justify-content-center">
                                        🥩
                                    </div>
                                @endif

                                <div class="flex-grow-1">
                                    <div class="fw-bold">
                                        {{ $item->product->name ?? 'Sản phẩm' }}
                                    </div>

                                    <div class="text-muted small">
                                        {{ $item->quantity }}
                                        {{ $item->product->unit ?? 'sản phẩm' }}
                                        ×
                                        {{ number_format($item->price, 0, ',', '.') }} đ
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($remainingItems > 0)
                            <div class="text-muted small mt-2">
                                + {{ $remainingItems }} sản phẩm khác
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">

                        <div>
                            <div class="text-muted small">
                                {{ $order->items->count() }} dòng sản phẩm
                            </div>

                            <div class="text-muted small">
                                Cập nhật: {{ $order->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="text-md-end">
                            <div class="text-muted small">
                                Tổng thanh toán
                            </div>

                            <div class="order-total mb-3">
                                {{ number_format($order->total_price, 0, ',', '.') }} đ
                            </div>

                            <a
                                href="{{ route('orders.show', $order->id) }}"
                                class="view-detail-btn d-inline-block"
                            >
                                👁️ Xem chi tiết
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        @endforeach


        {{-- ============================= --}}
        {{-- PHÂN TRANG ĐƠN HÀNG --}}
        {{-- ============================= --}}
        @if ($orders->hasPages())

            <div class="orders-pagination">

                @if ($orders->onFirstPage())
                    <span class="page-btn disabled">
                        ‹ Trước
                    </span>
                @else
                    <a
                        href="{{ $orders->previousPageUrl() }}"
                        class="page-btn"
                    >
                        ‹ Trước
                    </a>
                @endif

                @for ($page = 1; $page <= $orders->lastPage(); $page++)

                    @if ($page == $orders->currentPage())
                        <span class="page-btn active">
                            {{ $page }}
                        </span>
                    @else
                        <a
                            href="{{ $orders->url($page) }}"
                            class="page-btn"
                        >
                            {{ $page }}
                        </a>
                    @endif

                @endfor

                @if ($orders->hasMorePages())
                    <a
                        href="{{ $orders->nextPageUrl() }}"
                        class="page-btn"
                    >
                        Sau ›
                    </a>
                @else
                    <span class="page-btn disabled">
                        Sau ›
                    </span>
                @endif

            </div>

        @endif

    @endif

</div>

@endsection
