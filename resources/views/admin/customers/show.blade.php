@extends('admin.layouts.app')

@section('title', 'Chi tiết khách hàng | Tinh Hoa Tây Bắc')

@section('content')

<style>
    :root {
        --tb-brown: #5f341d;
        --tb-brown-dark: #2c1810;
        --tb-red: #a83b2d;
        --tb-gold: #f2c15c;
        --tb-green: #48633b;
        --tb-cream: #fffaf0;
        --tb-soft: #f8efe2;
        --tb-border: #ead8bf;
    }

    .customer-detail-page {
        position: relative;
        isolation: isolate;
        padding: 30px 0 72px;
    }

    .customer-detail-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -35px;
        left: 50%;
        width: min(100vw,1760px);
        height: 760px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%,rgba(242,193,92,.17),transparent 23%),
            radial-gradient(circle at 94% 12%,rgba(72,99,59,.12),transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.94),rgba(255,255,255,0));
    }

    .customer-detail-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 26px;
        min-height: 190px;
        padding: 34px 36px;
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 15%,rgba(242,193,92,.22),transparent 29%),
            radial-gradient(circle at 12% 120%,rgba(168,59,45,.27),transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
        box-shadow: 0 22px 56px rgba(44,24,16,.18);
    }

    .customer-detail-hero::after {
        content: "•";
        position: absolute;
        right: 30px;
        bottom: -28px;
        font-size: 130px;
        opacity: .055;
    }

    .hero-customer-avatar {
        width: 92px;
        height: 92px;
        flex: 0 0 92px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255,255,255,.92);
        outline: 1px solid rgba(242,193,92,.45);
        background: linear-gradient(135deg,#fff3d8,#dfeeda);
        color: var(--tb-green);
        font-size: 34px;
        font-weight: 900;
        box-shadow: 0 12px 28px rgba(0,0,0,.16);
    }

    .detail-kicker {
        display: inline-flex;
        padding: 6px 11px;
        margin-bottom: 8px;
        border: 1px solid rgba(242,193,92,.30);
        border-radius: 999px;
        color: #f6d98c;
        background: rgba(255,255,255,.055);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
    }

    .customer-detail-hero h1 {
        font-size: clamp(29px,3vw,42px);
        letter-spacing: -.7px;
    }

    .customer-detail-hero .sub {
        color: rgba(255,255,255,.76);
    }

    .detail-back-btn {
        position: relative;
        z-index: 2;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        padding: 9px 17px;
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 999px;
        color: #fff;
        background: rgba(255,255,255,.08);
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .detail-back-btn:hover {
        color: #fff;
        background: rgba(255,255,255,.14);
    }

    .customer-mini-stat,
    .customer-detail-card {
        border: 1px solid var(--tb-border);
        background: linear-gradient(180deg,#fff,#fffdfa);
        box-shadow: 0 14px 38px rgba(95,52,29,.075);
    }

    .customer-mini-stat {
        height: 100%;
        border-radius: 18px;
        padding: 20px;
    }

    .customer-mini-stat .value {
        color: var(--tb-brown-dark);
        font-size: 27px;
        font-weight: 900;
    }

    .customer-detail-card {
        border-radius: 22px;
        overflow: hidden;
    }

    .customer-detail-card .card-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--tb-border);
        background:
            radial-gradient(circle at 96% 0%,rgba(242,193,92,.10),transparent 25%),
            linear-gradient(180deg,#fffdf8,#fff9ef);
    }

    .customer-detail-card .card-body {
        padding: 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        padding: 11px 0;
        border-bottom: 1px dashed #ead8bf;
    }

    .info-row:last-child {
        border-bottom: 0;
    }

    .info-label {
        color: #85746a;
    }

    .info-value {
        color: #35261f;
        font-weight: 800;
        text-align: right;
    }

    .address-card-admin {
        position: relative;
        height: 100%;
        padding: 18px;
        border: 1px solid #e4cfb1;
        border-radius: 17px;
        background: linear-gradient(180deg,#fff,#fffaf2);
    }

    .address-card-admin.default {
        border-color: #8aaa7b;
        background: linear-gradient(180deg,#fbfff9,#f1f8ed);
    }

    .address-label-admin {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 999px;
        border: 1px solid #e3c99f;
        background: #fff4df;
        color: var(--tb-brown);
        font-size: 12px;
        font-weight: 900;
    }

    .latest-shipping-box {
        border: 1px solid #e4cfb1;
        border-radius: 17px;
        background:
            radial-gradient(circle at 95% 5%,rgba(242,193,92,.12),transparent 25%),
            linear-gradient(180deg,#fffdf8,#fff9ee);
        padding: 20px;
    }

    .orders-table th {
        padding: 14px 13px;
        background: linear-gradient(180deg,#fff8e9,#f8efe2);
        color: var(--tb-brown);
        border-bottom-color: #e3ceb0;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .orders-table td {
        padding: 14px 13px;
        border-color: #f0e4d5;
        vertical-align: middle;
    }

    .orders-table tbody tr:hover {
        background: #fffaf2;
    }

    .order-link {
        color: var(--tb-brown);
        font-weight: 900;
        text-decoration: none;
    }

    .order-link:hover {
        color: var(--tb-red);
    }

    @media (max-width: 767.98px) {
        .customer-detail-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .customer-detail-hero::after {
            display: none;
        }

        .customer-detail-card {
            border-radius: 18px;
        }

        .info-row {
            flex-direction: column;
            gap: 4px;
        }

        .info-value {
            text-align: left;
        }
    }

    /* =========================================================
       CUSTOMER DETAIL V2 - UI ONLY
       Nâng hero, stat, thông tin, địa chỉ và lịch sử đơn.
    ========================================================= */

    .customer-detail-page {
        padding-top: 36px;
    }

    .customer-detail-hero {
        min-height: 220px;
        padding: 40px 42px;
        border-radius: 30px;
        box-shadow:
            0 30px 72px rgba(44,24,16,.19),
            inset 0 1px 0 rgba(255,255,255,.06);
    }

    .customer-detail-hero::before {
        content: "";
        position: absolute;
        right: -42px;
        bottom: -74px;
        width: 410px;
        height: 240px;
        opacity: .10;
        clip-path: polygon(
            0 100%,17% 58%,34% 73%,53% 25%,
            69% 58%,85% 34%,100% 66%,100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .hero-customer-avatar {
        width: 108px;
        height: 108px;
        flex-basis: 108px;
        border-width: 4px;
        box-shadow:
            0 16px 32px rgba(0,0,0,.18),
            0 0 0 7px rgba(255,255,255,.055);
    }

    .customer-detail-hero h1 {
        font-size: clamp(33px,3.4vw,48px);
    }

    .customer-mini-stat {
        position: relative;
        overflow: hidden;
        padding: 22px;
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .customer-mini-stat::after {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -45px;
        width: 105px;
        height: 105px;
        border-radius: 50%;
        background: radial-gradient(circle,rgba(242,193,92,.13),transparent 70%);
        pointer-events: none;
    }

    .customer-mini-stat:hover {
        transform: translateY(-3px);
        border-color: #d9ba8d;
        box-shadow: 0 19px 40px rgba(95,52,29,.11);
    }

    .customer-mini-stat .value {
        margin-top: 5px;
        font-size: 30px;
        letter-spacing: -.4px;
    }

    .customer-detail-card {
        border-radius: 24px;
        transition:
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .customer-detail-card:hover {
        border-color: #dec39d;
        box-shadow: 0 19px 42px rgba(95,52,29,.095);
    }

    .customer-detail-card .card-header {
        padding: 20px 24px;
    }

    .customer-detail-card .card-header h5 {
        color: var(--tb-brown-dark);
        font-size: 18px;
    }

    .customer-detail-card .card-body {
        padding: 24px;
    }

    .info-row {
        padding: 13px 0;
    }

    .info-label {
        font-size: 13px;
        font-weight: 750;
    }

    .info-value {
        max-width: 62%;
    }

    .latest-shipping-box {
        position: relative;
        overflow: hidden;
        padding: 23px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .latest-shipping-box::after {
        content: "•";
        position: absolute;
        right: 16px;
        bottom: -13px;
        font-size: 65px;
        opacity: .045;
        pointer-events: none;
    }

    .latest-shipping-box .btn-outline-dark {
        border-color: #c9aa80;
        color: var(--tb-brown);
        background: #fff;
        border-radius: 11px;
        font-weight: 800;
    }

    .latest-shipping-box .btn-outline-dark:hover {
        border-color: var(--tb-brown);
        color: #fff;
        background: var(--tb-brown);
    }

    .address-card-admin {
        overflow: hidden;
        padding: 20px;
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .address-card-admin::after {
        content: "•";
        position: absolute;
        right: 13px;
        bottom: -12px;
        font-size: 58px;
        opacity: .045;
        pointer-events: none;
    }

    .address-card-admin:hover {
        transform: translateY(-2px);
        border-color: #d6b789;
        box-shadow: 0 14px 30px rgba(95,52,29,.08);
    }

    .address-card-admin.default {
        box-shadow: inset 4px 0 0 #66815a;
    }

    .orders-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .orders-table tbody tr {
        transition: background .15s ease;
    }

    .orders-table tbody tr:hover {
        background: #fff8ed;
        box-shadow: inset 3px 0 0 #d7a557;
    }

    .orders-table .badge {
        padding: 6px 10px;
        font-weight: 800;
    }

    .customer-detail-card .badge.bg-dark {
        border: 1px solid #d5b78d;
        color: #5f341d !important;
        background: linear-gradient(135deg,#fff4d7,#f6dfa9) !important;
    }

    .pagination {
        gap: 6px;
    }

    .page-link {
        border-radius: 10px !important;
        border-color: #dfc8a8;
        color: var(--tb-brown);
    }

    .page-item.active .page-link {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg,#5f341d,#48633b);
    }

    @media (max-width: 767.98px) {
        .customer-detail-page {
            padding-top: 22px;
        }

        .customer-detail-hero {
            padding: 28px 22px;
        }

        .hero-customer-avatar {
            width: 92px;
            height: 92px;
            flex-basis: 92px;
        }

        .info-value {
            max-width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .customer-detail-page *,
        .customer-detail-page *::before,
        .customer-detail-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="container-fluid customer-detail-page">

    <section class="customer-detail-hero mb-4">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            @if($customer->avatar)
                <img
                    src="{{ asset('storage/' . $customer->avatar) }}"
                    alt="{{ $customer->name }}"
                    class="hero-customer-avatar"
                >
            @else
                <div class="hero-customer-avatar">
                    {{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}
                </div>
            @endif

            <div>
                <div class="detail-kicker">• KHÁCH HÀNG #{{ $customer->id }}</div>
                <h1 class="fw-bold mb-2">{{ $customer->name }}</h1>
                <div class="sub">
                    {{ $customer->email }}
                    ·
                    @if($customer->email_verified_at)
                        • Đã xác thực email
                    @else
                        Chưa xác thực email
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('admin.customers.index') }}" class="detail-back-btn">
            ← Danh sách khách hàng
        </a>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="customer-mini-stat">
                <div class="text-muted small">• Tổng đơn</div>
                <div class="value">{{ $totalOrders }}</div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="customer-mini-stat">
                <div class="text-muted small">• Đang xử lý</div>
                <div class="value">{{ $pendingOrders }}</div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="customer-mini-stat">
                <div class="text-muted small">• Đã giao</div>
                <div class="value">{{ $deliveredOrders }}</div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="customer-mini-stat">
                <div class="text-muted small">• Đã chi tiêu</div>
                <div class="value" style="color:#a83b2d;font-size:22px;">
                    {{ number_format((float) $totalSpent, 0, ',', '.') }} đ
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-5">
            <div class="customer-detail-card h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-1">• Thông tin tài khoản</h5>
                    <div class="text-muted small">
                        Dữ liệu khách hàng cung cấp khi tạo và sử dụng tài khoản.
                    </div>
                </div>

                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Họ và tên</span>
                        <span class="info-value">{{ $customer->name }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $customer->email }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Trạng thái email</span>
                        <span class="info-value">
                            @if($customer->email_verified_at)
                                <span class="text-success">• Đã xác thực</span>
                            @else
                                <span class="text-warning">Chưa xác thực</span>
                            @endif
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Ngày đăng ký</span>
                        <span class="info-value">
                            {{ optional($customer->created_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Lần cập nhật tài khoản</span>
                        <span class="info-value">
                            {{ optional($customer->updated_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="customer-detail-card h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-1">• Thông tin giao hàng gần nhất</h5>
                    <div class="text-muted small">
                        Thông tin khách hàng nhập khi đặt đơn gần đây nhất.
                    </div>
                </div>

                <div class="card-body">
                    @if($latestOrder)
                        <div class="latest-shipping-box">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-muted small">Người nhận</div>
                                    <div class="fw-bold">
                                        {{ $latestOrder->customer_name ?: 'Chưa cung cấp' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted small">Số điện thoại</div>
                                    <div class="fw-bold">
                                        {{ $latestOrder->customer_phone ?: 'Chưa cung cấp' }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-muted small">Địa chỉ giao hàng</div>
                                    <div class="fw-bold">
                                        {{ $latestOrder->shipping_address ?: 'Chưa cung cấp' }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-muted small">Ghi chú đơn hàng</div>
                                    <div>
                                        {{ $latestOrder->notes ?: 'Không có ghi chú' }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <a
                                        href="{{ route('admin.orders.show', $latestOrder) }}"
                                        class="btn btn-sm btn-outline-dark"
                                    >
                                        • Mở đơn hàng gần nhất
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div style="font-size:48px;">•</div>
                            <div class="fw-bold mt-2">Khách hàng chưa đặt đơn nào</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="customer-detail-card mb-4">
        <div class="card-header">
            <h5 class="fw-bold mb-1">• Địa chỉ khách hàng đã lưu</h5>
            <div class="text-muted small">
                Đây là các địa chỉ do chính khách hàng thêm trong mục “Địa chỉ của tôi”.
            </div>
        </div>

        <div class="card-body">
            @if($addresses->isEmpty())
                <div class="text-center py-4">
                    <div style="font-size:48px;">•</div>
                    <div class="fw-bold mt-2">Khách hàng chưa lưu địa chỉ</div>
                </div>
            @else
                <div class="row g-3">
                    @foreach($addresses as $address)
                        @php
                            $fullAddress = collect([
                                data_get($address, 'address_detail'),
                                data_get($address, 'ward'),
                                data_get($address, 'district'),
                                data_get($address, 'province'),
                            ])->filter()->implode(', ');
                        @endphp

                        <div class="col-lg-6">
                            <div class="address-card-admin {{ data_get($address, 'is_default') ? 'default' : '' }}">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <span class="address-label-admin">
                                        {{ data_get($address, 'label', 'Địa chỉ') }}
                                    </span>

                                    @if(data_get($address, 'is_default'))
                                        <span class="badge bg-success rounded-pill">• Mặc định</span>
                                    @endif
                                </div>

                                <div class="fw-bold">
                                    {{ data_get($address, 'receiver_name', 'Chưa có tên người nhận') }}
                                </div>

                                <div class="mt-1">
                                    • {{ data_get($address, 'phone', 'Chưa có số điện thoại') }}
                                </div>

                                <div class="text-muted mt-2">
                                    • {{ $fullAddress ?: 'Chưa có địa chỉ chi tiết' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="customer-detail-card">
        <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <h5 class="fw-bold mb-1">• Lịch sử đơn hàng</h5>
                <div class="text-muted small">
                    Bấm mã đơn để xem toàn bộ chi tiết đơn hàng.
                </div>
            </div>

            <span class="badge bg-dark rounded-pill px-3 py-2">
                {{ $totalOrders }} đơn
            </span>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:52px;">•</div>
                <h5 class="fw-bold mt-2">Chưa có đơn hàng</h5>
            </div>
        @else
            <div class="table-responsive">
                <table class="table orders-table mb-0">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Người nhận</th>
                            <th>Điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $statusText = match($order->status) {
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipped' => 'Đang giao',
                                    'delivered' => 'Đã giao',
                                    'cancelled' => 'Đã hủy',
                                    default => $order->status,
                                };

                                $statusClass = match($order->status) {
                                    'pending' => 'bg-warning text-dark',
                                    'confirmed' => 'bg-info text-dark',
                                    'shipped' => 'bg-primary',
                                    'delivered' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="order-link"
                                    >
                                        #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>

                                <td>{{ $order->customer_name ?: '—' }}</td>
                                <td>{{ $order->customer_phone ?: '—' }}</td>

                                <td class="fw-bold" style="color:#a83b2d;">
                                    {{ number_format((float) $order->total_price, 0, ',', '.') }} đ
                                </td>

                                <td>
                                    {{ $order->payment_method === 'bank' ? '• Chuyển khoản' : '• COD' }}
                                </td>

                                <td>
                                    <span class="badge {{ $statusClass }} rounded-pill">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="p-4 border-top d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection
