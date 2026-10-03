@extends('admin.layouts.app')

@section('title', 'Khách hàng | Tinh Hoa Tây Bắc')

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

    .customers-admin-page {
        position: relative;
        isolation: isolate;
        padding: 30px 0 72px;
    }

    .customers-admin-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -35px;
        left: 50%;
        width: min(100vw, 1760px);
        height: 700px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.17), transparent 23%),
            radial-gradient(circle at 94% 12%, rgba(72,99,59,.12), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.94),rgba(255,255,255,0));
    }

    .customers-hero {
        position: relative;
        overflow: hidden;
        min-height: 175px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 32px 35px;
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 15%, rgba(242,193,92,.22), transparent 29%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.27), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
        box-shadow: 0 22px 56px rgba(44,24,16,.18);
    }

    .customers-hero::after {
        content: "✦";
        position: absolute;
        right: 55px;
        bottom: -18px;
        font-size: 118px;
        opacity: .07;
        pointer-events: none;
    }

    .customers-kicker {
        display: inline-flex;
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

    .customers-hero h1 {
        font-size: clamp(30px,3vw,42px);
        letter-spacing: -.7px;
    }

    .customers-hero p {
        color: rgba(255,255,255,.76);
    }

    .customers-back-btn {
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
    }

    .customers-back-btn:hover {
        color: #fff;
        background: rgba(255,255,255,.14);
    }

    .customer-stat {
        height: 100%;
        border: 1px solid var(--tb-border);
        border-radius: 19px;
        background: linear-gradient(180deg,#fff,#fffdfa);
        box-shadow: 0 13px 34px rgba(95,52,29,.07);
    }

    .customer-stat .icon {
        width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        border-radius: 15px;
        background: linear-gradient(135deg,#fff1ce,#f6dfb0);
        font-size: 23px;
    }

    .customer-filter,
    .customer-table-card {
        border: 1px solid var(--tb-border);
        border-radius: 21px;
        background: #fff;
        box-shadow: 0 16px 40px rgba(95,52,29,.075);
    }

    .customer-filter {
        padding: 22px;
    }

    .customer-filter .form-control,
    .customer-filter .form-select {
        min-height: 45px;
        border-radius: 11px;
        border-color: #dfcbae;
        background: #fffdf9;
    }

    .customer-filter .btn {
        min-height: 44px;
        border-radius: 11px;
        font-weight: 800;
    }

    .customer-table-card {
        overflow: hidden;
    }

    .customer-table th {
        padding: 15px 14px;
        background: linear-gradient(180deg,#fff8e9,#f8efe2);
        color: var(--tb-brown);
        border-bottom-color: #e3ceb0;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .customer-table td {
        padding: 15px 14px;
        border-color: #f0e4d5;
        vertical-align: middle;
    }

    .customer-table tbody tr:hover {
        background: #fffaf2;
    }

    .customer-avatar {
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        outline: 1px solid #dfc8a8;
        box-shadow: 0 5px 12px rgba(95,52,29,.10);
    }

    .customer-avatar-fallback {
        display: grid;
        place-items: center;
        background: linear-gradient(135deg,#f4eadc,#e4efdf);
        color: var(--tb-green);
        font-weight: 900;
        font-size: 17px;
    }

    .customer-name-link {
        color: var(--tb-brown-dark);
        font-weight: 900;
        text-decoration: none;
    }

    .customer-name-link:hover {
        color: var(--tb-red);
    }

    .customer-detail-btn {
        border-radius: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .pagination {
        gap: 6px;
    }

    .page-link {
        border-radius: 10px !important;
        border-color: #dfc8a8;
        color: var(--tb-brown);
    }

    @media (max-width: 767.98px) {
        .customers-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .customers-hero::after {
            display: none;
        }

        .customer-filter,
        .customer-table-card {
            border-radius: 18px;
        }
    }

    /* =========================================================
       CUSTOMER ADMIN V2 - UI ONLY
       Nâng chiều sâu, filter, bảng và trạng thái.
    ========================================================= */

    .customers-admin-page {
        padding-top: 36px;
    }

    .customers-hero {
        min-height: 205px;
        padding: 38px 42px;
        border-radius: 30px;
        box-shadow:
            0 30px 72px rgba(44,24,16,.19),
            inset 0 1px 0 rgba(255,255,255,.06);
    }

    .customers-hero::before {
        content: "";
        position: absolute;
        right: -40px;
        bottom: -72px;
        width: 400px;
        height: 235px;
        opacity: .10;
        clip-path: polygon(
            0 100%,17% 58%,34% 73%,53% 25%,
            69% 58%,85% 34%,100% 66%,100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .customers-hero h1 {
        font-size: clamp(34px,3.4vw,48px);
    }

    .customer-stat {
        position: relative;
        overflow: hidden;
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .customer-stat::after {
        content: "";
        position: absolute;
        width: 110px;
        height: 110px;
        right: -34px;
        bottom: -46px;
        border-radius: 50%;
        background: radial-gradient(circle,rgba(242,193,92,.12),transparent 70%);
        pointer-events: none;
    }

    .customer-stat:hover {
        transform: translateY(-3px);
        border-color: #d9ba8d;
        box-shadow: 0 19px 40px rgba(95,52,29,.11);
    }

    .customer-stat h3 {
        color: var(--tb-brown-dark);
        font-size: 31px;
        letter-spacing: -.4px;
    }

    .customer-filter {
        position: relative;
        overflow: hidden;
        padding: 26px;
        background:
            radial-gradient(circle at 100% 0%,rgba(242,193,92,.08),transparent 24%),
            linear-gradient(180deg,#fff,#fffdfa);
    }

    .customer-filter::before {
        content: "🔍 Bộ lọc khách hàng";
        display: block;
        margin-bottom: 18px;
        color: var(--tb-brown-dark);
        font-size: 16px;
        font-weight: 900;
    }

    .customer-filter .form-label {
        color: #584034;
        font-size: 12px;
        letter-spacing: .015em;
    }

    .customer-filter .form-control,
    .customer-filter .form-select {
        min-height: 49px;
        border-radius: 13px;
        background: linear-gradient(180deg,#fffefb,#fff9f0);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.95);
        transition:
            border-color .17s ease,
            box-shadow .17s ease,
            transform .17s ease;
    }

    .customer-filter .form-control:focus,
    .customer-filter .form-select:focus {
        border-color: #d0a05d;
        box-shadow: 0 0 0 .2rem rgba(217,119,6,.09);
        transform: translateY(-1px);
    }

    .customer-filter .btn-dark {
        border: 0;
        background: linear-gradient(135deg,#a83b2d,#5f341d 54%,#48633b);
        box-shadow: 0 10px 22px rgba(95,52,29,.18);
    }

    .customer-filter .btn-dark:hover {
        transform: translateY(-1px);
        box-shadow: 0 13px 27px rgba(95,52,29,.23);
    }

    .customer-table-card {
        border-radius: 24px;
    }

    .customer-table-card > .p-4.border-bottom {
        background:
            radial-gradient(circle at 100% 0%,rgba(242,193,92,.08),transparent 25%),
            linear-gradient(180deg,#fffdf9,#fff9f1);
    }

    .customer-table-card > .p-4.border-bottom h5 {
        color: var(--tb-brown-dark);
        font-size: 19px;
    }

    .customer-table-card .badge.bg-dark {
        border: 1px solid #d5b78d;
        color: #5f341d !important;
        background: linear-gradient(135deg,#fff4d7,#f6dfa9) !important;
    }

    .customer-table {
        margin: 0;
    }

    .customer-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .customer-table tbody tr {
        transition:
            background .15s ease,
            box-shadow .15s ease;
    }

    .customer-table tbody tr:hover {
        background: #fff8ed;
        box-shadow: inset 3px 0 0 #d7a557;
    }

    .customer-avatar {
        width: 54px;
        height: 54px;
        flex-basis: 54px;
        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }

    .customer-table tbody tr:hover .customer-avatar {
        transform: scale(1.045);
        box-shadow: 0 8px 17px rgba(95,52,29,.14);
    }

    .customer-table .badge.bg-success {
        border: 1px solid #bdd8c1;
        color: #2f6639 !important;
        background: #eef8ef !important;
    }

    .customer-table .badge.bg-warning {
        border: 1px solid #ead39e;
        color: #79591c !important;
        background: #fff5d9 !important;
    }

    .customer-detail-btn {
        min-height: 38px;
        padding-inline: 13px;
        border-color: #caae88;
        color: var(--tb-brown);
        background: #fffdf9;
    }

    .customer-detail-btn:hover {
        border-color: var(--tb-brown);
        color: #fff;
        background: var(--tb-brown);
    }

    .page-item.active .page-link {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg,#5f341d,#48633b);
    }

    @media (max-width: 767.98px) {
        .customers-admin-page {
            padding-top: 22px;
        }

        .customers-hero {
            padding: 28px 22px;
        }

        .customer-filter {
            padding: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .customers-admin-page *,
        .customers-admin-page *::before,
        .customers-admin-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="container-fluid customers-admin-page">

    <section class="customers-hero mb-4">
        <div>
            <div class="customers-kicker">⚙️ KHU VỰC QUẢN TRỊ</div>
            <h1 class="fw-bold mb-2">👥 Khách hàng</h1>
            <p class="mb-0">
                Xem tài khoản, thông tin khách hàng đã cung cấp và lịch sử mua hàng.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="customers-back-btn">
            ← Dashboard
        </a>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="customer-stat p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">👥</div>
                    <div>
                        <div class="text-muted small">Tổng khách hàng</div>
                        <h3 class="fw-bold mb-0">{{ $totalCustomers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="customer-stat p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">✅</div>
                    <div>
                        <div class="text-muted small">Đã xác thực email</div>
                        <h3 class="fw-bold mb-0">{{ $verifiedCustomers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="customer-stat p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">📦</div>
                    <div>
                        <div class="text-muted small">Đã từng đặt hàng</div>
                        <h3 class="fw-bold mb-0">{{ $customersWithOrders }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.customers.index') }}" class="customer-filter mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5">
                <label class="form-label fw-bold">Tìm khách hàng</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Tên, email hoặc ID khách hàng..."
                >
            </div>

            <div class="col-lg-3">
                <label class="form-label fw-bold">Xác thực email</label>
                <select name="verified" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }}>
                        Đã xác thực
                    </option>
                    <option value="no" {{ request('verified') === 'no' ? 'selected' : '' }}>
                        Chưa xác thực
                    </option>
                </select>
            </div>

            <div class="col-lg-2">
                <label class="form-label fw-bold">Sắp xếp</label>
                <select name="sort" class="form-select">
                    <option value="">Mới nhất</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên A → Z</option>
                    <option value="orders_desc" {{ request('sort') === 'orders_desc' ? 'selected' : '' }}>Nhiều đơn nhất</option>
                    <option value="spent_desc" {{ request('sort') === 'spent_desc' ? 'selected' : '' }}>Chi tiêu cao nhất</option>
                </select>
            </div>

            <div class="col-lg-2 d-grid">
                <button class="btn btn-dark">🔍 Lọc</button>
            </div>
        </div>
    </form>

    <div class="customer-table-card">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <h5 class="fw-bold mb-1">Danh sách khách hàng</h5>
                <div class="text-muted small">
                    Bấm tên hoặc nút “Xem chi tiết” để mở hồ sơ khách hàng.
                </div>
            </div>

            <span class="badge bg-dark rounded-pill px-3 py-2">
                {{ $customers->total() }} khách hàng
            </span>
        </div>

        @if($customers->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:58px;">👤</div>
                <h5 class="fw-bold mt-3">Không tìm thấy khách hàng</h5>
                <p class="text-muted mb-0">Thử thay đổi điều kiện tìm kiếm.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table customer-table mb-0">
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th class="text-center">Xác thực</th>
                            <th class="text-center">Đơn hàng</th>
                            <th>Đã chi tiêu</th>
                            <th>Ngày đăng ký</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($customer->avatar)
                                            <img
                                                src="{{ asset('storage/' . $customer->avatar) }}"
                                                alt="{{ $customer->name }}"
                                                class="customer-avatar"
                                            >
                                        @else
                                            <div class="customer-avatar customer-avatar-fallback">
                                                {{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <a
                                                href="{{ route('admin.customers.show', $customer) }}"
                                                class="customer-name-link"
                                            >
                                                {{ $customer->name }}
                                            </a>
                                            <div class="text-muted small">ID #{{ $customer->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $customer->email }}</td>

                                <td class="text-center">
                                    @if($customer->email_verified_at)
                                        <span class="badge bg-success rounded-pill">✓ Đã xác thực</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill">Chưa xác thực</span>
                                    @endif
                                </td>

                                <td class="text-center fw-bold">
                                    {{ $customer->orders_count }}
                                </td>

                                <td class="fw-bold" style="color:#a83b2d;">
                                    {{ number_format((float) ($customer->delivered_total_spent ?? 0), 0, ',', '.') }} đ
                                </td>

                                <td>
                                    {{ optional($customer->created_at)->format('d/m/Y H:i') }}
                                </td>

                                <td class="text-center">
                                    <a
                                        href="{{ route('admin.customers.show', $customer) }}"
                                        class="btn btn-sm btn-outline-dark customer-detail-btn"
                                    >
                                        👁 Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($customers->hasPages())
            <div class="p-4 border-top d-flex justify-content-center">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
