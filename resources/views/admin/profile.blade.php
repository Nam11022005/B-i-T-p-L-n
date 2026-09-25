@extends('admin.layouts.app')

@section('title', 'Hồ sơ Admin | Tinh Hoa Tây Bắc')

@section('content')

<style>
    :root {
        --ap-brown: #5f341d;
        --ap-dark: #2c1810;
        --ap-red: #a83b2d;
        --ap-gold: #f2c15c;
        --ap-green: #48633b;
        --ap-cream: #fffaf0;
        --ap-soft: #f8efe2;
        --ap-border: #ead8bf;
        --ap-text: #2f241e;
    }

    .admin-profile-page {
        position: relative;
        isolation: isolate;
        padding: 34px 0 78px;
    }

    .admin-profile-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -36px;
        left: 50%;
        width: min(100vw, 1760px);
        height: 720px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 8% 9%, rgba(242,193,92,.20), transparent 24%),
            radial-gradient(circle at 94% 10%, rgba(72,99,59,.14), transparent 29%),
            radial-gradient(circle at 50% 24%, rgba(168,59,45,.05), transparent 30%),
            linear-gradient(180deg, rgba(255,250,240,.98), rgba(255,255,255,0));
    }

    .admin-profile-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 155px;
        right: -60px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        opacity: .085;
        pointer-events: none;
        background:
            repeating-radial-gradient(circle at center, rgba(95,52,29,.35) 0 1px, transparent 1px 13px);
    }

    .admin-profile-hero {
        position: relative;
        overflow: hidden;
        min-height: 230px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 40px 42px;
        margin-bottom: 28px;
        border-radius: 30px;
        color: #fff;
        background:
            radial-gradient(circle at 86% 12%, rgba(242,193,92,.27), transparent 30%),
            radial-gradient(circle at 12% 118%, rgba(168,59,45,.32), transparent 36%),
            linear-gradient(135deg, #25130c 0%, #5f341d 52%, #48633b 100%);
        box-shadow: 0 28px 68px rgba(44,24,16,.17);
    }

    .admin-profile-hero::before {
        content: "";
        position: absolute;
        right: -36px;
        bottom: -72px;
        width: 400px;
        height: 235px;
        opacity: .12;
        clip-path: polygon(
            0 100%, 17% 58%, 34% 73%, 53% 25%,
            69% 58%, 85% 34%, 100% 66%, 100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
    }

    .admin-profile-hero::after {
        content: "👑";
        position: absolute;
        right: 42px;
        top: 14px;
        font-size: 112px;
        opacity: .06;
        transform: rotate(-10deg);
    }

    .admin-profile-hero > * {
        position: relative;
        z-index: 2;
    }

    .admin-profile-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        margin-bottom: 14px;
        border: 1px solid rgba(242,193,92,.33);
        border-radius: 999px;
        color: #f7dc96;
        background: rgba(255,255,255,.06);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .admin-profile-hero h1 {
        margin-bottom: 10px;
        font-size: clamp(34px,4vw,52px);
        line-height: 1.05;
        font-weight: 950;
        letter-spacing: -.9px;
        text-shadow: 0 2px 16px rgba(0,0,0,.18);
    }

    .admin-profile-hero p {
        margin: 0;
        color: rgba(255,255,255,.76);
        line-height: 1.7;
    }

    .admin-avatar-shell {
        width: 118px;
        height: 118px;
        flex: 0 0 118px;
        display: grid;
        place-items: center;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,.24);
        border-radius: 30px;
        background: rgba(255,255,255,.09);
        box-shadow: 0 16px 30px rgba(0,0,0,.16);
        backdrop-filter: blur(10px);
    }

    .admin-avatar-shell img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .admin-avatar-fallback {
        font-size: 48px;
    }

    .admin-profile-grid {
        display: grid;
        grid-template-columns: minmax(300px,.82fr) minmax(0,1.18fr);
        gap: 24px;
    }

    .admin-profile-card {
        overflow: hidden;
        border: 1px solid #e5d0b3;
        border-radius: 22px;
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.07), transparent 25%),
            linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 14px 36px rgba(95,52,29,.07),
            inset 0 1px 0 rgba(255,255,255,.95);
    }

    .admin-profile-card-body {
        padding: 26px;
    }

    .admin-profile-card-title {
        margin-bottom: 18px;
        color: var(--ap-dark);
        font-size: 18px;
        font-weight: 950;
    }

    .admin-info-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 15px 0;
        border-bottom: 1px solid #f0e3d2;
    }

    .admin-info-row:last-child {
        border-bottom: 0;
    }

    .admin-info-label {
        color: #837267;
        font-size: 13px;
        font-weight: 750;
    }

    .admin-info-value {
        color: var(--ap-text);
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .admin-role-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border: 1px solid #e2c98f;
        border-radius: 999px;
        color: #704b12;
        background: linear-gradient(135deg,#fff4d2,#f6dfa9);
        font-size: 12px;
        font-weight: 900;
    }

    .admin-active-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border: 1px solid #bdd8c1;
        border-radius: 999px;
        color: #2f6639;
        background: #eef8ef;
        font-size: 12px;
        font-weight: 900;
    }

    .admin-profile-summary {
        padding: 22px;
        margin-bottom: 20px;
        border: 1px solid #e9d3ac;
        border-radius: 18px;
        background:
            radial-gradient(circle at 94% 10%, rgba(242,193,92,.16), transparent 27%),
            linear-gradient(135deg,#fff9e7,#fff2cf);
    }

    .admin-profile-summary strong {
        display: block;
        color: var(--ap-dark);
        font-size: 20px;
        font-weight: 950;
    }

    .admin-profile-summary p {
        margin: 5px 0 0;
        color: #725e47;
        line-height: 1.6;
    }

    .admin-quick-links {
        display: grid;
        grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 12px;
    }

    .admin-quick-link {
        min-height: 82px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border: 1px solid #e2ccb0;
        border-radius: 16px;
        color: var(--ap-text);
        background: #fff;
        text-decoration: none;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .admin-quick-link:hover {
        color: var(--ap-text);
        transform: translateY(-2px);
        border-color: #d3ae78;
        box-shadow: 0 12px 26px rgba(95,52,29,.08);
    }

    .admin-quick-link-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        border: 1px solid #e4c99e;
        border-radius: 13px;
        background: linear-gradient(135deg,#fff1cf,#f7dfad);
        font-size: 20px;
    }

    .admin-quick-link strong {
        display: block;
        color: var(--ap-dark);
        font-size: 14px;
    }

    .admin-quick-link small {
        color: #86756a;
        line-height: 1.35;
    }

    @media (max-width: 991.98px) {
        .admin-profile-grid {
            grid-template-columns: 1fr;
        }

        .admin-profile-hero {
            min-height: 0;
            padding: 34px 30px;
            border-radius: 24px;
        }
    }

    @media (max-width: 767.98px) {
        .admin-profile-page {
            padding-top: 22px;
        }

        .admin-profile-page::after {
            display: none;
        }

        .admin-profile-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 28px 22px;
            border-radius: 21px;
        }

        .admin-quick-links {
            grid-template-columns: 1fr;
        }

        .admin-info-row {
            flex-direction: column;
            gap: 5px;
        }

        .admin-info-value {
            text-align: left;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-profile-page *,
        .admin-profile-page *::before,
        .admin-profile-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<div class="container admin-profile-page">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">

            <section class="admin-profile-hero">
                <div>
                    <div class="admin-profile-kicker">👑 TÀI KHOẢN QUẢN TRỊ</div>

                    <h1>{{ $user->name }}</h1>

                    <p>
                        Hồ sơ quản trị viên của Tinh Hoa Tây Bắc.
                        Từ đây bạn có thể nhanh chóng truy cập các khu vực quản trị chính.
                    </p>
                </div>

                <div class="admin-avatar-shell">
                    @if($user->avatar)
                        <img
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="{{ $user->name }}"
                        >
                    @else
                        <div class="admin-avatar-fallback">👑</div>
                    @endif
                </div>
            </section>

            <div class="admin-profile-grid">

                <section class="admin-profile-card">
                    <div class="admin-profile-card-body">
                        <h2 class="admin-profile-card-title">
                            👤 Thông tin tài khoản
                        </h2>

                        <div class="admin-info-row">
                            <div class="admin-info-label">Họ và tên</div>
                            <div class="admin-info-value">{{ $user->name }}</div>
                        </div>

                        <div class="admin-info-row">
                            <div class="admin-info-label">Email</div>
                            <div class="admin-info-value">{{ $user->email }}</div>
                        </div>

                        <div class="admin-info-row">
                            <div class="admin-info-label">Vai trò</div>
                            <div class="admin-info-value">
                                <span class="admin-role-pill">
                                    👑 {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>

                        <div class="admin-info-row">
                            <div class="admin-info-label">Trạng thái</div>
                            <div class="admin-info-value">
                                <span class="admin-active-pill">
                                    ● Đang hoạt động
                                </span>
                            </div>
                        </div>

                        <div class="admin-info-row">
                            <div class="admin-info-label">Ngày tạo tài khoản</div>
                            <div class="admin-info-value">
                                {{ $user->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </div>
                        </div>
                    </div>
                </section>

                <section class="admin-profile-card">
                    <div class="admin-profile-card-body">
                        <h2 class="admin-profile-card-title">
                            ⚡ Khu vực quản trị nhanh
                        </h2>

                        <div class="admin-profile-summary">
                            <strong>Quản trị Tinh Hoa Tây Bắc</strong>
                            <p>
                                Theo dõi hoạt động cửa hàng và di chuyển nhanh tới
                                những khu vực quản trị thường xuyên sử dụng.
                            </p>
                        </div>

                        <div class="admin-quick-links">

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">📊</span>
                                <span>
                                    <strong>Dashboard</strong>
                                    <small>Tổng quan hoạt động cửa hàng</small>
                                </span>
                            </a>

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">🥩</span>
                                <span>
                                    <strong>Sản phẩm</strong>
                                    <small>Quản lý sản phẩm và khuyến mãi</small>
                                </span>
                            </a>

                            <a
                                href="{{ route('admin.customers.index') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">👥</span>
                                <span>
                                    <strong>Khách hàng</strong>
                                    <small>Xem tài khoản và lịch sử mua hàng</small>
                                </span>
                            </a>

                            <a
                                href="{{ route('admin.orders.index') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">📦</span>
                                <span>
                                    <strong>Đơn hàng</strong>
                                    <small>Kiểm tra và xử lý đơn hàng</small>
                                </span>
                            </a>

                            <a
                                href="{{ route('admin.categories.index') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">🧺</span>
                                <span>
                                    <strong>Danh mục</strong>
                                    <small>Phân loại sản phẩm cửa hàng</small>
                                </span>
                            </a>

                            <a
                                href="{{ route('admin.vouchers.index') }}"
                                class="admin-quick-link"
                            >
                                <span class="admin-quick-link-icon">🎟️</span>
                                <span>
                                    <strong>Voucher</strong>
                                    <small>Quản lý chương trình ưu đãi</small>
                                </span>
                            </a>

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

@endsection
