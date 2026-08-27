@extends('layouts.app')

@section('title', 'Dashboard người dùng')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="mb-5">
            <h1 class="fw-bold mb-2">👋 Chào mừng, {{ Auth::user()->name }}!</h1>
            <p class="text-muted fs-5">Quản lý tài khoản và đơn hàng của bạn</p>
        </div>

        <!-- Thống kê nhanh -->
        <div class="row g-4 mb-5">
            <!-- Tổng đơn hàng -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2" style="color: #2563eb;">📋</div>
                        <h6 class="text-muted mb-2">Tổng đơn hàng</h6>
                        <h3 class="fw-bold">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng đang xử lý -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2" style="color: #f59e0b;">⏳</div>
                        <h6 class="text-muted mb-2">Đang xử lý</h6>
                        <h3 class="fw-bold text-warning">{{ $pendingOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng đã giao -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2" style="color: #10b981;">✅</div>
                        <h6 class="text-muted mb-2">Đã giao</h6>
                        <h3 class="fw-bold text-success">{{ $deliveredOrders }}</h3>
                    </div>
                </div>
            </div>

            <!-- Tổng chi tiêu -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2" style="color: #8b5cf6;">💰</div>
                        <h6 class="text-muted mb-2">Tổng chi tiêu</h6>
                        <h3 class="fw-bold text-danger">{{ number_format($totalSpent, 0, ',', '.') }} đ</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hành động nhanh -->
        <div class="mb-5">
            <h5 class="fw-bold mb-3">Hành động nhanh</h5>
            <div class="row g-2">
                <div class="col-md-6">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg w-100">
                        🛍️ Tiếp tục mua sắm
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('orders.index') }}" class="btn btn-info btn-lg w-100">
                        📦 Xem tất cả đơn hàng
                    </a>
                </div>
            </div>
        </div>

        <!-- Đơn hàng gần đây -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">📦 Đơn hàng gần đây</h5>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="fs-1 mb-3">📭</div>
                        <p class="text-muted mb-3">Bạn chưa có đơn hàng nào.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Mua sắm ngay</a>
                    </div>
                </div>
            @else
                <div class="row g-3">
                    @foreach($recentOrders->take(3) as $order)
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1">Đơn #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                            <small class="text-muted">{{ $order->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'confirmed' => 'info',
                                                'shipped' => 'primary',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger',
                                            ][$order->status] ?? 'secondary';
                                            
                                            $statusText = [
                                                'pending' => '⏳',
                                                'confirmed' => '✓',
                                                'shipped' => '📦',
                                                'delivered' => '✅',
                                                'cancelled' => '❌',
                                            ][$order->status] ?? '?';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    </div>

                                    <div class="mb-3 pb-3 border-bottom">
                                        @foreach($order->items->take(2) as $item)
                                            <small class="d-block text-muted">
                                                • {{ $item->product->name ?? 'Sản phẩm' }} x{{ $item->quantity }}
                                            </small>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <small class="d-block text-muted">
                                                • +{{ $order->items->count() - 2 }} sản phẩm khác
                                            </small>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</strong>
                                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
