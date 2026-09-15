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

</style>

<div class="orders-page">

    <div class="mb-4">
        <h2 class="orders-heading mb-1">
            📋 Đơn hàng của tôi
        </h2>
        <p class="text-muted mb-0">
            Xem danh sách đơn hàng và bấm “Xem chi tiết” để theo dõi từng đơn.
        </p>
    </div>

    {{-- THỐNG KÊ NHANH --}}
<div class="row g-3 mb-4">

    {{-- TỔNG ĐƠN HÀNG --}}
    <div class="col-md-4">
        <div class="summary-box">
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
        <div class="summary-box">
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
        <div class="summary-box">
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
    <div class="d-flex flex-wrap gap-2 mb-4">
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
