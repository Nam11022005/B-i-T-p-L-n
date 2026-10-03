{{-- =========================================================
    NAVBAR ADMIN DÙNG CHUNG
    Dùng cho cả:
    - resources/views/layouts/app.blade.php
    - resources/views/admin/layouts/app.blade.php
========================================================= --}}

<style>
    :root {
        --tb-brown: #5f341d;
        --tb-brown-dark: #2c1810;
        --tb-green: #48633b;
        --tb-red: #a83b2d;
        --tb-gold: #f2c15c;
        --tb-soft: #f8efe2;
        --tb-text: #2f241e;
    }

    .main-navbar {
        height: 64px;
        min-height: 64px;
        padding: 0;

        background: linear-gradient(
            90deg,
            #35180d 0%,
            #66391f 55%,
            #48633b 100%
        ) !important;

        box-shadow: 0 5px 18px rgba(44, 24, 16, 0.16);
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .main-navbar .navbar-container {
        width: 100%;
        max-width: 1440px;
        height: 64px;

        margin: 0 auto;
        padding: 0 32px;

        display: flex;
        align-items: center;
    }

    .main-navbar .navbar-brand {
        width: 250px;
        height: 64px;

        margin: 0 24px 0 0;
        padding: 0;

        display: flex;
        align-items: center;

        color: #fff !important;

        font-size: 21px;
        font-weight: 800;
        line-height: 1;

        letter-spacing: .3px;
        white-space: nowrap;
        text-decoration: none;
    }

    .main-navbar .navbar-brand:hover {
        color: var(--tb-gold) !important;
    }

    .brand-leaf {
        margin-right: 10px;
        font-size: 22px;
        line-height: 1;
    }

    .main-navbar .navbar-collapse {
        height: 64px;
    }

    .main-navbar .navbar-nav {
        height: 64px;
        align-items: center;
        gap: 3px;
    }

    .main-navbar .nav-link {
        height: 42px;
        padding: 0 13px !important;

        display: flex;
        align-items: center;

        border-radius: 10px;

        color: rgba(255,255,255,.88) !important;

        font-size: 14px;
        font-weight: 600;
        line-height: 1;

        white-space: nowrap;

        transition: .2s ease;
    }

    .main-navbar .nav-link:hover {
        color: #fff !important;
        background: rgba(255,255,255,.08);
    }

    .main-navbar .nav-link.active {
        color: var(--tb-gold) !important;
        background: rgba(255,255,255,.10);
    }

    .admin-user-nav {
        margin-left: 8px !important;
        padding-left: 14px;

        border-left: 1px solid rgba(255,255,255,.15);
    }

    .main-navbar .dropdown-menu {
        min-width: 220px;
        padding: 8px;

        border: 1px solid #eee0ce;
        border-radius: 14px;

        box-shadow: 0 16px 40px rgba(44,24,16,.16);
    }

    .main-navbar .dropdown-item {
        padding: 10px 12px;
        border-radius: 9px;
        color: var(--tb-text);
        font-weight: 500;
    }

    .main-navbar .dropdown-item:hover {
        background: var(--tb-soft);
        color: var(--tb-brown-dark);
    }


    /* =========================================================
    🔔 THÔNG BÁO ADMIN
    ========================================================= */
    .admin-notification-nav {
        margin-left: auto !important;
        padding-left: 18px;
        display: flex;
        align-items: center;
    }

    .notification-toggle {
        position: relative;
        width: 44px;
        height: 42px;
        padding: 0 !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 12px !important;
        font-size: 19px !important;
    }

    .notification-badge {
        position: absolute;
        top: 1px;
        right: 1px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 20px;
        background: #dc3545;
        color: #fff;
        border: 2px solid #5d3420;
        font-size: 10px;
        font-weight: 800;
        line-height: 14px;
        text-align: center;
    }

    .notification-menu {
        width: 370px;
        max-width: calc(100vw - 24px);
        padding: 0 !important;
        overflow: hidden;
    }

    .notification-header {
        padding: 14px 16px;
        background: #fffaf0;
        border-bottom: 1px solid #eee0ce;
    }

    .notification-list {
        max-height: 360px;
        overflow-y: auto;
    }

    .notification-item {
        display: block;
        padding: 13px 16px;
        color: var(--tb-text);
        text-decoration: none;
        border-bottom: 1px solid #f2e7d8;
        transition: .18s ease;
    }

    .notification-item:hover {
        background: var(--tb-soft);
        color: var(--tb-text);
    }

    .notification-item.unread {
        background: #fff7e7;
        border-left: 4px solid var(--tb-gold);
        padding-left: 12px;
    }

    .notification-title {
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .notification-message {
        font-size: 13px;
        color: #6b625c;
        line-height: 1.45;
    }

    .notification-time {
        margin-top: 5px;
        font-size: 11px;
        color: #9a8d83;
    }

    .notification-empty {
        padding: 28px 18px;
        text-align: center;
        color: #8b7d74;
    }

    .notification-footer {
        padding: 10px;
        background: #fff;
        border-top: 1px solid #eee0ce;
    }

    @media (max-width: 1199px) {
        .main-navbar .navbar-container {
            padding-left: 22px;
            padding-right: 22px;
        }

        .main-navbar .navbar-brand {
            width: 230px;
            margin-right: 16px;
        }

        .main-navbar .nav-link {
            padding-left: 10px !important;
            padding-right: 10px !important;
            font-size: 13px;
        }
    }

    @media (max-width: 991px) {
        .main-navbar {
            height: auto;
            min-height: 64px;
        }

        .main-navbar .navbar-container {
            height: auto;
            min-height: 64px;

            padding-left: 16px;
            padding-right: 16px;

            flex-wrap: wrap;
        }

        .main-navbar .navbar-brand {
            width: auto;
            height: 64px;
            margin-right: 0;
        }

        .main-navbar .navbar-collapse {
            width: 100%;
            height: auto;

            padding-top: 4px;
            padding-bottom: 12px;
        }

        .main-navbar .navbar-nav {
            height: auto;
            align-items: stretch;
            gap: 4px;
        }

        .main-navbar .nav-link {
            height: 42px;
            padding: 0 12px !important;
        }

        .admin-user-nav {
            margin-left: 0 !important;
            margin-top: 6px;
            padding-left: 0;
            padding-top: 6px;

            border-left: none;
            border-top: 1px solid rgba(255,255,255,.12);
        }


        .admin-notification-nav {
            margin-left: 0 !important;
            padding-left: 0;
            padding-top: 6px;
        }

        .notification-toggle {
            width: 100%;
            justify-content: flex-start;
            padding: 0 12px !important;
        }

        .notification-badge {
            position: static;
            margin-left: 8px;
            border-color: transparent;
        }

        .notification-menu {
            width: 100%;
            max-width: 100%;
        }
    }

    /* =========================================================
       CUSTOMER MENU UPGRADE
    ========================================================= */
    .main-navbar .nav-link[href*="/admin/customers"] {
        position: relative;
    }

    .main-navbar .nav-link[href*="/admin/customers"].active::after {
        content: "";
        position: absolute;
        left: 18%;
        right: 18%;
        bottom: 5px;
        height: 2px;
        border-radius: 999px;
        background: var(--tb-gold, #f2c15c);
        box-shadow: 0 0 10px rgba(242,193,92,.35);
    }

    @media (min-width: 992px) and (max-width: 1320px) {
        .main-navbar .navbar-brand {
            width: 205px;
            margin-right: 10px;
            font-size: 17px;
        }

        .main-navbar .nav-link {
            padding-left: 8px !important;
            padding-right: 8px !important;
            font-size: 12.5px;
        }
    }


    /* =========================================================
       ADMIN NAV DATA SYNC
       Hiển thị cùng nhãn với navbar ở trang chủ.
    ========================================================= */
    .notification-toggle {
        gap: 7px;
    }

    .notification-label {
        display: inline-block;
        font-weight: 700;
    }

    @media (min-width: 992px) and (max-width: 1320px) {
        .notification-label {
            display: none;
        }
    }

</style>


<nav class="navbar navbar-expand-lg navbar-dark main-navbar">

    <div class="navbar-container">

        {{-- =========================
            LOGO
        ========================== --}}
        <a
            class="navbar-brand"
            href="{{ url('/') }}"
        >
            <span class="brand-leaf" aria-hidden="true">
                @include('layouts.partials.brand-mark', ['variant' => 'footer'])
            </span>
            Tinh Hoa Tây Bắc
        </a>


        {{-- =========================
            MOBILE BUTTON
        ========================== --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sharedAdminNavbar"
            aria-controls="sharedAdminNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <div
            class="collapse navbar-collapse"
            id="sharedAdminNavbar"
        >

            {{-- =========================
                MENU ADMIN
            ========================== --}}
            <ul class="navbar-nav">

                {{-- TRANG CHỦ --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ url('/') }}"
                    >
                        🏠&nbsp; Trang chủ
                    </a>
                </li>


                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}"
                    >
                        📊&nbsp; Dashboard
                    </a>
                </li>


                {{-- KHÁCH HÀNG --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                        href="{{ route('admin.customers.index') }}"
                        title="Quản lý khách hàng"
                    >
                        👥&nbsp; Khách hàng
                    </a>
                </li>


                {{-- SẢN PHẨM --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}"
                    >
                        🥩&nbsp; Sản phẩm
                    </a>
                </li>


                {{-- DANH MỤC --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}"
                    >
                        🧺&nbsp; Danh mục
                    </a>
                </li>


                {{-- KHUYẾN MẠI --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"
                        href="{{ route('admin.promotions.index') }}"
                    >
                        🔥&nbsp; Khuyến mại
                    </a>
                </li>


                {{-- ĐƠN HÀNG --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}"
                    >
                        📦&nbsp; Đơn hàng
                    </a>
                </li>


                {{-- VOUCHER --}}
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}"
                        href="{{ route('admin.vouchers.index') }}"
                    >
                        🎟️&nbsp; Voucher
                    </a>
                </li>

            </ul>


            {{-- =========================
                🔔 THÔNG BÁO ADMIN
            ========================== --}}
            @php
                $adminUser = Auth::user();

                $unreadNotificationCount =
                    $adminUser->unreadNotifications()->count();

                $latestNotifications =
                    $adminUser->notifications()
                        ->latest()
                        ->take(6)
                        ->get();
            @endphp

            <ul class="navbar-nav admin-notification-nav">

                <li class="nav-item dropdown">

                    <a
                        class="nav-link notification-toggle"
                        href="#"
                        id="sharedAdminNotificationDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="Thông báo"
                    >
                        🔔
                        <span class="notification-label">Thông báo</span>

                        @if($unreadNotificationCount > 0)
                            <span class="notification-badge">
                                {{
                                    $unreadNotificationCount > 99
                                        ? '99+'
                                        : $unreadNotificationCount
                                }}
                            </span>
                        @endif
                    </a>

                    <div
                        class="dropdown-menu dropdown-menu-end notification-menu"
                        aria-labelledby="sharedAdminNotificationDropdown"
                    >

                        <div
                            class="
                                notification-header
                                d-flex
                                justify-content-between
                                align-items-center
                                gap-3
                            "
                        >
                            <div>
                                <div class="fw-bold">
                                    🔔 Thông báo
                                </div>

                                <small class="text-muted">
                                    {{ $unreadNotificationCount }}
                                    thông báo chưa đọc
                                </small>
                            </div>

                            @if($unreadNotificationCount > 0)
                                <span class="badge bg-danger rounded-pill">
                                    {{ $unreadNotificationCount }}
                                </span>
                            @endif
                        </div>

                        <div class="notification-list">

                            @forelse($latestNotifications as $notification)

                                @php
                                    $notificationData =
                                        $notification->data ?? [];

                                    $notificationUrl =
                                        $notificationData['url']
                                        ?? route('admin.orders.index');

                                    $notificationTitle =
                                        $notificationData['title']
                                        ?? 'Thông báo';

                                    $notificationMessage =
                                        $notificationData['message']
                                        ?? 'Bạn có một thông báo mới.';
                                @endphp

                                <a
                                    href="{{ $notificationUrl }}"
                                    class="
                                        notification-item
                                        {{ is_null($notification->read_at) ? 'unread' : '' }}
                                    "
                                >
                                    <div class="notification-title">
                                        🛒 {{ $notificationTitle }}
                                    </div>

                                    <div class="notification-message">
                                        {{ $notificationMessage }}
                                    </div>

                                    <div class="notification-time">
                                        {{
                                            optional($notification->created_at)
                                                ->diffForHumans()
                                        }}

                                        @if(is_null($notification->read_at))
                                            ·
                                            <span class="text-danger fw-semibold">
                                                Chưa đọc
                                            </span>
                                        @endif
                                    </div>
                                </a>

                            @empty

                                <div class="notification-empty">
                                    <div class="fs-3 mb-2">
                                        🔕
                                    </div>

                                    Chưa có thông báo nào.
                                </div>

                            @endforelse

                        </div>

                        <div class="notification-footer">

                            <a
                                href="{{ route('admin.orders.index') }}"
                                class="btn btn-outline-secondary btn-sm w-100"
                            >
                                📦 Xem danh sách đơn hàng
                            </a>

                        </div>

                    </div>

                </li>

            </ul>


            {{-- =========================
                ADMIN ACCOUNT
            ========================== --}}
            <ul class="navbar-nav admin-user-nav">

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="sharedAdminDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        👑&nbsp; {{ Auth::user()->name }}
                    </a>


                    <ul
                        class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="sharedAdminDropdown"
                    >

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('admin.customers.index') }}"
                            >
                                👥 Quản lý khách hàng
                            </a>
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('admin.profile') }}"
                            >
                                👤 Hồ sơ Admin
                            </a>
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>

                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item text-danger"
                                >
                                    🚪 Đăng xuất
                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>
