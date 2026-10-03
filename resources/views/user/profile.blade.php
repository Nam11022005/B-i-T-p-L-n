@extends('layouts.app')

@section('title', 'Hồ sơ của tôi | Tinh Hoa Tây Bắc')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | AVATAR
    |--------------------------------------------------------------------------
    */

    $avatarExists =
        $user->avatar
        &&
        \Illuminate\Support\Facades\Storage::disk('public')
            ->exists($user->avatar);


    $avatarUrl =
        $avatarExists
        ? asset('storage/' . $user->avatar)
        : null;


    $userInitial =
        mb_strtoupper(
            mb_substr(
                trim($user->name),
                0,
                1
            )
        );


    /*
    |--------------------------------------------------------------------------
    | ROLE
    |--------------------------------------------------------------------------
    */

    $roleLabel =
        match ($user->role) {
            'admin' => 'Quản trị viên',
            'customer' => 'Khách hàng',
            'user' => 'Khách hàng',
            default => ucfirst($user->role),
        };


    /*
    |--------------------------------------------------------------------------
    | ORDER STATS
    |--------------------------------------------------------------------------
    */

    $profileOrders =
        $user
            ->orders()
            ->select([
                'id',
                'status',
            ])
            ->get();


    $profileTotalOrders =
        $profileOrders->count();


    $profileProcessingOrders =
        $profileOrders
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                    'shipped',
                ]
            )
            ->count();


    $profileDeliveredOrders =
        $profileOrders
            ->where(
                'status',
                'delivered'
            )
            ->count();


    $emailVerified =
        !is_null(
            $user->email_verified_at
        );
@endphp


<style>
    /* =========================================================
       CUSTOMER PROFILE
       TINH HOA TAY BAC
    ========================================================= */

    .customer-profile {
        --pf-green: #35562f;
        --pf-green-dark: #274522;

        --pf-brown: #633820;
        --pf-brown-dark: #3d2316;

        --pf-red: #b43e2e;
        --pf-red-dark: #8d3025;

        --pf-gold: #e5ad42;
        --pf-gold-soft: #fff0c9;

        --pf-text: #302923;
        --pf-muted: #776d66;

        --pf-border: #e7dfd5;

        --pf-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --pf-shadow-lg:
            0 18px 48px
            rgba(54, 40, 29, .12);

        color:
            var(--pf-text);
    }


    .customer-profile *,
    .customer-profile *::before,
    .customer-profile *::after {
        box-sizing: border-box;
    }


    .customer-profile a {
        text-decoration: none;
    }

    .pf-wallet {
        margin: 24px 0;
        overflow: hidden;
        border: 1px solid #d9c59d;
        border-radius: 20px;
        background: linear-gradient(135deg, #fffaf0, #f4ead6);
        box-shadow: 0 12px 28px rgba(95,52,29,.07);
    }

    .pf-wallet-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        color: #fff;
        background: linear-gradient(135deg, #5f341d, #48633b);
    }

    .pf-wallet-head h2 { margin: 0; color: #fff; font-size: 21px; font-weight: 900; }
    .pf-wallet-balance { font-size: clamp(24px, 3vw, 34px); font-weight: 950; }
    .pf-wallet-body { display: grid; grid-template-columns: minmax(0, 1fr) minmax(280px, .8fr); gap: 22px; padding: 22px; }
    .pf-wallet-form { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 10px; }
    .pf-wallet-input { min-height: 44px; padding: 10px 12px; border: 1px solid #d9c59d; border-radius: 10px; }
    .pf-wallet-button { min-height: 44px; padding: 10px 16px; border: 0; border-radius: 10px; color: #fff; background: #48633b; font-weight: 800; }
    .pf-wallet-history { margin: 15px 0 0; padding: 0; list-style: none; }
    .pf-wallet-history li { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-top: 1px solid rgba(95,52,29,.12); font-size: 13px; }
    .pf-wallet-credit { color: #257042; font-weight: 850; }
    .pf-wallet-debit { color: #a83b2d; font-weight: 850; }
    .pf-wallet-qr { text-align: center; }
    .pf-wallet-qr img { width: min(100%, 250px); border-radius: 14px; background: #fff; box-shadow: 0 8px 18px rgba(95,52,29,.12); }
    .pf-wallet-code { display: inline-block; margin-top: 10px; padding: 7px 10px; border-radius: 8px; color: #5f341d; background: #fff4d9; font-family: monospace; font-weight: 900; letter-spacing: .06em; }
    @media (max-width: 767.98px) { .pf-wallet-body { grid-template-columns: 1fr; } .pf-wallet-form { grid-template-columns: 1fr; } }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .pf-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .pf-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .pf-breadcrumb a:hover {
        color:
            var(--pf-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .pf-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 190px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 28px;

        margin-bottom: 18px;

        padding:
            31px 34px;

        border-radius: 20px;

        color: #fff;

        background:
            radial-gradient(
                circle at 87% 15%,
                rgba(229,173,66,.28),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                #284525 0%,
                #41633a 48%,
                #663820 100%
            );

        box-shadow:
            var(--pf-shadow-lg);
    }


    .pf-hero::before {
        content: "";

        position: absolute;

        z-index: -2;

        inset: 0;

        opacity: .06;

        background-image:
            repeating-linear-gradient(
                135deg,
                #fff 0,
                #fff 1px,
                transparent 1px,
                transparent 24px
            );
    }


    .pf-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -30px;
        bottom: -60px;

        width: 335px;
        height: 190px;

        opacity: .11;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                20% 54%,
                38% 72%,
                58% 23%,
                77% 61%,
                100% 13%,
                100% 100%
            );
    }


    .pf-hero-copy {
        position: relative;

        z-index: 2;

        max-width: 720px;
    }


    .pf-kicker {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffda8b;

        background:
            rgba(255,255,255,.06);

        font-size: 10.5px;

        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .pf-title {
        margin:
            10px 0 0;

        color: #fff;

        font-size:
            clamp(
                30px,
                3vw,
                42px
            );

        line-height: 1.08;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .pf-description {
        max-width: 650px;

        margin-top: 8px;

        color:
            rgba(255,255,255,.74);

        font-size: 13px;

        line-height: 1.65;
    }


    .pf-hero-badge {
        position: relative;

        z-index: 2;

        flex: 0 0 auto;

        padding:
            10px 14px;

        border:
            1px solid
            rgba(255,255,255,.2);

        border-radius: 999px;

        color: #fff;

        background:
            rgba(255,255,255,.08);

        backdrop-filter:
            blur(8px);

        font-size: 11px;

        font-weight: 900;
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .pf-alert {
        margin-bottom: 15px;

        padding:
            12px 14px;

        border-radius: 11px;

        font-size: 11px;

        line-height: 1.55;
    }


    .pf-alert.success {
        border:
            1px solid #bcd4b6;

        color:
            var(--pf-green-dark);

        background:
            #edf7ea;
    }


    .pf-alert.error {
        border:
            1px solid #e8beb7;

        color: #913b32;

        background:
            #fff0ee;
    }


    .pf-alert ul {
        margin:
            6px 0 0;

        padding-left: 18px;
    }


    /* =========================================================
       QUICK STATS
    ========================================================= */

    .pf-stats {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 11px;

        margin-bottom: 18px;
    }


    .pf-stat {
        min-height: 96px;

        display: flex;
        align-items: center;

        gap: 13px;

        padding: 14px;

        border:
            1px solid
            var(--pf-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--pf-shadow);
    }


    .pf-stat-icon {
        width: 46px;
        height: 46px;

        flex: 0 0 46px;

        display: grid;
        place-items: center;

        border-radius: 12px;

        background:
            var(--pf-gold-soft);

        font-size: 20px;
    }


    .pf-stat:nth-child(2)
    .pf-stat-icon {
        background:
            #e8f1ff;
    }


    .pf-stat:nth-child(3)
    .pf-stat-icon {
        background:
            #e9f5e6;
    }


    .pf-stat-label {
        color:
            var(--pf-muted);

        font-size: 10px;

        font-weight: 750;
    }


    .pf-stat-number {
        margin-top: 2px;

        color:
            var(--pf-brown-dark);

        font-size: 24px;

        line-height: 1;

        font-weight: 950;
    }


    /* =========================================================
       LAYOUT
    ========================================================= */

    .pf-layout {
        display: grid;

        grid-template-columns:
            320px
            minmax(0, 1fr);

        gap: 18px;

        align-items: start;
    }


    .pf-sidebar {
        display: grid;

        gap: 13px;
    }


    .pf-content {
        min-width: 0;

        display: grid;

        gap: 15px;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .pf-card {
        overflow: hidden;

        border:
            1px solid
            var(--pf-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--pf-shadow);
    }


    .pf-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            15px 17px;

        border-bottom:
            1px solid
            var(--pf-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf7
            );
    }


    .pf-card-title {
        margin: 0;

        color: #453930;

        font-size: 14px;

        font-weight: 950;
    }


    .pf-card-subtitle {
        margin-top: 2px;

        color:
            var(--pf-muted);

        font-size: 10px;
    }


    .pf-card-body {
        padding: 17px;
    }


    /* =========================================================
       PROFILE SIDEBAR
    ========================================================= */

    .pf-user-card {
        text-align: center;
    }


    .pf-avatar-wrap {
        position: relative;

        width: 154px;
        height: 154px;

        margin:
            2px auto 15px;
    }


    .pf-avatar,
    .pf-avatar-placeholder {
        width: 154px;
        height: 154px;

        display: block;

        border:
            5px solid #fff;

        outline:
            3px solid
            rgba(53,86,47,.76);

        border-radius: 50%;

        box-shadow:
            0 13px 30px
            rgba(54,40,29,.14);

        background:
            linear-gradient(
                135deg,
                #edf6e9,
                #fff2d4
            );

        object-fit: cover;
    }


    .pf-avatar-placeholder {
        display: grid;
        place-items: center;

        color:
            var(--pf-green);

        font-size: 52px;

        font-weight: 950;
    }


    .pf-avatar-camera {
        position: absolute;

        right: 5px;
        bottom: 5px;

        width: 38px;
        height: 38px;

        display: grid;
        place-items: center;

        border:
            4px solid #fff;

        border-radius: 50%;

        color: #fff;

        background:
            var(--pf-red);

        font-size: 15px;
    }


    .pf-user-name {
        color:
            var(--pf-brown-dark);

        font-size: 19px;

        line-height: 1.25;

        font-weight: 950;
    }


    .pf-user-email {
        overflow-wrap: anywhere;

        margin-top: 4px;

        color:
            var(--pf-muted);

        font-size: 11px;
    }


    .pf-user-badges {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;

        gap: 5px;

        margin-top: 10px;
    }


    .pf-user-badge {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        padding:
            5px 8px;

        border-radius: 999px;

        color:
            var(--pf-green-dark);

        background:
            #eaf5e7;

        font-size: 8.5px;

        font-weight: 900;
    }


    .pf-user-badge.verify {
        color: #6d5317;

        background:
            #fff2c9;
    }


    .pf-user-badge.verify.ok {
        color:
            var(--pf-green-dark);

        background:
            #eaf5e7;
    }


    /* =========================================================
       AVATAR FORM
    ========================================================= */

    .pf-avatar-form {
        margin-top: 18px;

        padding-top: 15px;

        border-top:
            1px solid #eee6dd;

        text-align: left;
    }


    .pf-label {
        display: block;

        margin-bottom: 6px;

        color: #51443b;

        font-size: 11px;

        font-weight: 900;
    }


    .pf-file-input {
        width: 100%;

        padding:
            9px;

        border:
            1px solid #ddd1c4;

        border-radius: 9px;

        color: #5c5047;

        background: #fff;

        font-size: 10px;
    }


    .pf-file-note {
        margin-top: 5px;

        color: #92877f;

        font-size: 9px;

        line-height: 1.45;
    }


    .pf-avatar-actions {
        display: grid;

        gap: 7px;

        margin-top: 10px;
    }


    /* =========================================================
       BUTTONS
    ========================================================= */

    .pf-primary-btn,
    .pf-outline-btn,
    .pf-danger-btn {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        padding:
            0 12px;

        border-radius: 9px;

        font-size: 10px;

        font-weight: 900;

        transition:
            transform .17s ease,
            box-shadow .17s ease,
            background .17s ease;
    }


    .pf-primary-btn {
        border: 0;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--pf-red),
                var(--pf-red-dark)
            );
    }


    .pf-primary-btn:hover {
        color: #fff;

        transform:
            translateY(-1px);

        box-shadow:
            0 8px 17px
            rgba(180,62,46,.2);
    }


    .pf-outline-btn {
        border:
            1px solid #d9c8b5;

        color:
            var(--pf-brown);

        background: #fff;
    }


    .pf-outline-btn:hover {
        color: #fff;

        border-color:
            var(--pf-brown);

        background:
            var(--pf-brown);
    }


    .pf-danger-btn {
        width: 100%;

        border:
            1px solid #dfb9b2;

        color:
            var(--pf-red);

        background:
            #fff7f5;
    }


    .pf-danger-btn:hover {
        color: #fff;

        border-color:
            var(--pf-red);

        background:
            var(--pf-red);
    }


    /* =========================================================
       QUICK LINKS
    ========================================================= */

    .pf-links {
        display: grid;

        gap: 7px;
    }


    .pf-link {
        min-height: 50px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        padding:
            9px 11px;

        border:
            1px solid #e9e1d8;

        border-radius: 10px;

        color:
            #54473e;

        background:
            #fbfaf8;

        transition:
            .17s ease;
    }


    .pf-link:hover {
        color:
            var(--pf-red);

        border-color:
            #dec1a2;

        background:
            #fff9f0;

        transform:
            translateX(2px);
    }


    .pf-link-left {
        display: flex;
        align-items: center;

        gap: 9px;
    }


    .pf-link-icon {
        width: 32px;
        height: 32px;

        display: grid;
        place-items: center;

        border-radius: 8px;

        background:
            #fff0cf;

        font-size: 14px;
    }


    .pf-link-title {
        font-size: 10.5px;

        font-weight: 900;
    }


    .pf-link-subtitle {
        margin-top: 1px;

        color:
            var(--pf-muted);

        font-size: 8.5px;
    }


    .pf-link-arrow {
        color: #a29388;

        font-size: 15px;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .pf-form-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 13px;
    }


    .pf-field.full {
        grid-column:
            1 / -1;
    }


    .pf-input-wrap {
        position: relative;
    }


    .pf-input-icon {
        position: absolute;

        z-index: 2;

        top: 50%;
        left: 12px;

        transform:
            translateY(-50%);

        pointer-events: none;

        font-size: 14px;
    }


    .pf-input {
        width: 100%;
        height: 45px;

        padding:
            0 39px;

        border:
            1px solid #ddd2c6;

        border-radius: 10px;

        outline: 0;

        color:
            var(--pf-text);

        background: #fff;

        font-size: 12px;

        transition:
            border-color .17s ease,
            box-shadow .17s ease;
    }


    .pf-input:focus {
        border-color:
            var(--pf-gold);

        box-shadow:
            0 0 0 3px
            rgba(229,173,66,.11);
    }


    .pf-input[disabled] {
        color: #756b64;

        background:
            #f7f5f2;

        cursor: not-allowed;
    }


    .pf-field-note {
        margin-top: 5px;

        color:
            #938881;

        font-size: 9px;

        line-height: 1.45;
    }


    /* =========================================================
       INFO BOX
    ========================================================= */

    .pf-info-box {
        min-height: 45px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        padding:
            9px 11px;

        border:
            1px solid #e9e0d6;

        border-radius: 10px;

        background:
            #fbfaf8;
    }


    .pf-info-label {
        color:
            var(--pf-muted);

        font-size: 10px;
    }


    .pf-info-value {
        color:
            var(--pf-brown-dark);

        font-size: 10.5px;

        font-weight: 900;

        text-align: right;
    }


    .pf-active {
        color:
            var(--pf-green);
    }


    /* =========================================================
       PASSWORD
    ========================================================= */

    .pf-password-note {
        display: flex;
        align-items: flex-start;

        gap: 8px;

        margin-bottom: 14px;

        padding:
            10px 11px;

        border:
            1px solid #e9d5a7;

        border-radius: 9px;

        color: #69543d;

        background:
            #fff9e7;

        font-size: 9.5px;

        line-height: 1.55;
    }


    .pf-password-toggle {
        position: absolute;

        z-index: 3;

        top: 50%;
        right: 7px;

        transform:
            translateY(-50%);

        width: 31px;
        height: 31px;

        display: grid;
        place-items: center;

        border: 0;

        border-radius: 7px;

        color: #796c63;

        background: transparent;

        cursor: pointer;

        font-size: 13px;
    }


    .pf-password-toggle:hover {
        background:
            #f4eee8;
    }


    /* =========================================================
       SECURITY INFO
    ========================================================= */

    .pf-security-grid {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 8px;

        margin-top: 15px;
    }


    .pf-security-item {
        padding:
            10px;

        border:
            1px solid #eee5db;

        border-radius: 9px;

        color: #685950;

        background:
            #fdfbf8;

        font-size: 9px;

        line-height: 1.5;
    }


    .pf-security-item strong {
        display: block;

        margin-bottom: 2px;

        color:
            #493d35;

        font-size: 9.5px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .pf-layout {
            grid-template-columns: 1fr;
        }


        .pf-sidebar {
            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);

            align-items: start;
        }

    }


    @media (max-width: 767.98px) {

        .pf-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                24px 21px;
        }


        .pf-stats {
            grid-template-columns: 1fr;
        }


        .pf-sidebar {
            grid-template-columns: 1fr;
        }


        .pf-form-grid {
            grid-template-columns: 1fr;
        }


        .pf-field.full {
            grid-column: auto;
        }


        .pf-security-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 575.98px) {

        .pf-card-body {
            padding: 14px;
        }


        .pf-avatar-wrap,
        .pf-avatar,
        .pf-avatar-placeholder {
            width: 135px;
            height: 135px;
        }


        .pf-avatar-placeholder {
            font-size: 44px;
        }

    }
</style>


<div class="customer-profile">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="pf-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <span>
            Hồ sơ của tôi
        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="pf-hero">

        <div class="pf-hero-copy">

            <div class="pf-kicker">
                👤 Tài khoản khách hàng
            </div>


            <h1 class="pf-title">
                Hồ sơ của tôi
            </h1>


            <div class="pf-description">

                Quản lý thông tin cá nhân,
                ảnh đại diện,
                bảo mật tài khoản
                và truy cập nhanh
                các chức năng mua sắm của bạn.

            </div>

        </div>


        <div class="pf-hero-badge">

            🌿 {{ $roleLabel }}

        </div>

    </section>


    {{-- =====================================================
        FLASH MESSAGE
    ====================================================== --}}
    @if(session('success'))

        <div class="pf-alert success">

            ✓ {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="pf-alert error">

            <strong>
                ⚠️ Vui lòng kiểm tra lại:
            </strong>


            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="pf-stats">


        <div class="pf-stat">

            <div class="pf-stat-icon">
                📦
            </div>


            <div>

                <div class="pf-stat-label">
                    Tổng đơn hàng
                </div>

                <div class="pf-stat-number">
                    {{ number_format($profileTotalOrders) }}
                </div>

            </div>

        </div>


        <div class="pf-stat">

            <div class="pf-stat-icon">
                🚚
            </div>


            <div>

                <div class="pf-stat-label">
                    Đơn đang xử lý
                </div>

                <div class="pf-stat-number">
                    {{ number_format($profileProcessingOrders) }}
                </div>

            </div>

        </div>


        <div class="pf-stat">

            <div class="pf-stat-icon">
                ✅
            </div>


            <div>

                <div class="pf-stat-label">
                    Đơn đã giao
                </div>

                <div class="pf-stat-number">
                    {{ number_format($profileDeliveredOrders) }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        VÍ TINH HOA
    ====================================================== --}}
    @php
        $walletQrUrl = null;
        if ($walletTopUp) {
            $walletQrUrl = 'https://img.vietqr.io/image/'
                . config('payment.bank_code')
                . '-' . config('payment.bank_account_number')
                . '-compact2.png?amount=' . (int) round((float) $walletTopUp->amount)
                . '&addInfo=' . urlencode($walletTopUp->reference_code)
                . '&accountName=' . urlencode(config('payment.bank_account_name'));
        }
    @endphp
    <section class="pf-wallet" id="wallet">
        <div class="pf-wallet-head">
            <div>
                <h2>💳 Ví Tinh Hoa</h2>
                <div class="small mt-1">Nạp tiền qua chuyển khoản và thanh toán đơn hàng bằng số dư.</div>
            </div>
            <div class="text-end">
                <div class="small">Số dư khả dụng</div>
                <div class="pf-wallet-balance">{{ number_format((float) $user->wallet_balance, 0, ',', '.') }}đ</div>
            </div>
        </div>
        <div class="pf-wallet-body">
            <div>
                <strong>Nạp tiền vào ví</strong>
                <p class="small text-muted mt-1">Nhập số tiền, hệ thống tạo QR và tự cộng vào ví khi nhận được giao dịch chuyển khoản.</p>
                <form action="{{ route('wallet.topup') }}" method="POST" class="pf-wallet-form">
                    @csrf
                    <input class="pf-wallet-input" type="number" name="amount" min="10000" step="1000" placeholder="Ví dụ: 100000" required>
                    <button class="pf-wallet-button" type="submit">Tạo mã nạp</button>
                </form>

                <ul class="pf-wallet-history">
                    @forelse($walletTransactions as $transaction)
                        @php
                            $walletTypeLabels = [
                                'topup' => 'Nạp tiền',
                                'payment' => 'Thanh toán đơn hàng',
                                'refund' => 'Hoàn tiền',
                                'admin_credit' => 'Admin cộng tiền',
                                'admin_debit' => 'Admin trừ tiền',
                            ];
                            $walletIsDebit = in_array($transaction->type, ['payment', 'admin_debit'], true);
                        @endphp
                        <li>
                            <span>
                                <strong>{{ $walletTypeLabels[$transaction->type] ?? 'Giao dịch ví' }}</strong><br>
                                <small class="text-muted">{{ $transaction->created_at->format('d/m/Y H:i') }} · {{ $transaction->status === 'completed' ? 'Hoàn tất' : 'Đang chờ' }}</small>
                            </span>
                            <span class="{{ $walletIsDebit ? 'pf-wallet-debit' : 'pf-wallet-credit' }}">
                                {{ $walletIsDebit ? '-' : '+' }}{{ number_format((float) $transaction->amount, 0, ',', '.') }}đ
                            </span>
                        </li>
                    @empty
                        <li><span class="text-muted">Chưa có giao dịch ví.</span></li>
                    @endforelse
                </ul>
            </div>

            @if($walletTopUp)
                <div class="pf-wallet-qr">
                    <strong>Quét QR để nạp {{ number_format((float) $walletTopUp->amount, 0, ',', '.') }}đ</strong>
                    <p class="small text-muted mb-2">Chuyển đúng số tiền và giữ nguyên nội dung.</p>
                    <img src="{{ $walletQrUrl }}" alt="QR nạp tiền vào ví">
                    <div class="pf-wallet-code">{{ $walletTopUp->reference_code }}</div>
                    <div class="small text-muted mt-2">{{ config('payment.bank_name') }} · {{ config('payment.bank_account_display_name') }}</div>
                </div>
            @else
                <div class="pf-wallet-qr text-muted">
                    <div class="fs-1">🏦</div>
                    <strong>Tạo mã nạp để hiển thị QR</strong>
                </div>
            @endif
        </div>
    </section>


    {{-- =====================================================
        MAIN LAYOUT
    ====================================================== --}}
    <div class="pf-layout">


        {{-- =================================================
            LEFT
        ================================================== --}}
        <aside class="pf-sidebar">


            {{-- =============================================
                AVATAR
            ============================================== --}}
            <section class="pf-card">

                <div class="pf-card-body pf-user-card">


                    <div class="pf-avatar-wrap">


                        @if($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="Ảnh đại diện {{ $user->name }}"
                                class="pf-avatar"
                                id="avatarPreview"
                            >

                        @else

                            <div
                                class="pf-avatar-placeholder"
                                id="avatarPlaceholder"
                            >
                                {{ $userInitial }}
                            </div>


                            <img
                                src=""
                                alt="Xem trước ảnh đại diện"
                                class="pf-avatar"
                                id="avatarPreview"
                                style="display:none;"
                            >

                        @endif


                        <div class="pf-avatar-camera">
                            📷
                        </div>

                    </div>


                    <div class="pf-user-name">
                        {{ $user->name }}
                    </div>


                    <div class="pf-user-email">
                        {{ $user->email }}
                    </div>


                    <div class="pf-user-badges">

                        <span class="pf-user-badge">
                            👤 {{ $roleLabel }}
                        </span>


                        <span
                            class="
                                pf-user-badge
                                verify
                                {{ $emailVerified ? 'ok' : '' }}
                            "
                        >

                            @if($emailVerified)

                                ✓ Email đã xác thực

                            @else

                                ⚠️ Email chưa xác thực

                            @endif

                        </span>

                    </div>


                    {{-- =========================================
                        UPDATE AVATAR
                    ========================================== --}}
                    <form
                        action="{{ route('profile.avatar.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="pf-avatar-form"
                    >

                        @csrf


                        <label
                            for="profileAvatarInput"
                            class="pf-label"
                        >
                            Chọn ảnh đại diện mới
                        </label>


                        <input
                            type="file"
                            id="profileAvatarInput"
                            name="avatar"
                            class="pf-file-input"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            required
                        >


                        <div class="pf-file-note">
                            JPG, JPEG, PNG hoặc WEBP · Tối đa 2MB.
                        </div>


                        <div class="pf-avatar-actions">

                            <button
                                type="submit"
                                class="pf-primary-btn"
                            >
                                📷 Cập nhật ảnh
                            </button>

                        </div>

                    </form>


                    @if($user->avatar)

                        <form
                            action="{{ route('profile.avatar.delete') }}"
                            method="POST"
                            style="margin-top:7px;"
                            onsubmit="
                                return confirm(
                                    'Bạn có chắc muốn xóa ảnh đại diện hiện tại?'
                                );
                            "
                        >

                            @csrf
                            @method('DELETE')


                            <button
                                type="submit"
                                class="pf-danger-btn"
                            >
                                🗑️ Xóa ảnh đại diện
                            </button>

                        </form>

                    @endif

                </div>

            </section>


            {{-- =============================================
                QUICK LINKS
            ============================================== --}}
            <section class="pf-card">

                <div class="pf-card-head">

                    <div>

                        <h2 class="pf-card-title">
                            Truy cập nhanh
                        </h2>

                        <div class="pf-card-subtitle">
                            Các chức năng tài khoản.
                        </div>

                    </div>

                </div>


                <div class="pf-card-body">

                    <div class="pf-links">


                        <a
                            href="{{ route('dashboard') }}"
                            class="pf-link"
                        >

                            <span class="pf-link-left">

                                <span class="pf-link-icon">
                                    📊
                                </span>

                                <span>

                                    <span class="pf-link-title">
                                        Tổng quan
                                    </span>

                                    <span class="pf-link-subtitle">
                                        Hoạt động tài khoản
                                    </span>

                                </span>

                            </span>

                            <span class="pf-link-arrow">
                                ›
                            </span>

                        </a>


                        <a
                            href="{{ route('orders.index') }}"
                            class="pf-link"
                        >

                            <span class="pf-link-left">

                                <span class="pf-link-icon">
                                    📦
                                </span>

                                <span>

                                    <span class="pf-link-title">
                                        Đơn hàng của tôi
                                    </span>

                                    <span class="pf-link-subtitle">
                                        Theo dõi đơn đã đặt
                                    </span>

                                </span>

                            </span>

                            <span class="pf-link-arrow">
                                ›
                            </span>

                        </a>


                        <a
                            href="#shipping-addresses"
                            class="pf-link"
                        >

                            <span class="pf-link-left">

                                <span class="pf-link-icon">
                                    📍
                                </span>

                                <span>

                                    <span class="pf-link-title">
                                        Địa chỉ giao hàng
                                    </span>

                                    <span class="pf-link-subtitle">
                                        Quản lý địa chỉ nhận hàng
                                    </span>

                                </span>

                            </span>

                            <span class="pf-link-arrow">
                                ›
                            </span>

                        </a>


                        <a
                            href="{{ route('products.index') }}"
                            class="pf-link"
                        >

                            <span class="pf-link-left">

                                <span class="pf-link-icon">
                                    🛍
                                </span>

                                <span>

                                    <span class="pf-link-title">
                                        Tiếp tục mua sắm
                                    </span>

                                    <span class="pf-link-subtitle">
                                        Khám phá đặc sản Tây Bắc
                                    </span>

                                </span>

                            </span>

                            <span class="pf-link-arrow">
                                ›
                            </span>

                        </a>

                    </div>

                </div>

            </section>

        </aside>


        {{-- =================================================
            RIGHT
        ================================================== --}}
        <div class="pf-content">


            {{-- =============================================
                PERSONAL INFO
            ============================================== --}}
            <section class="pf-card">

                <div class="pf-card-head">

                    <div>

                        <h2 class="pf-card-title">
                            👤 Thông tin cá nhân
                        </h2>

                        <div class="pf-card-subtitle">
                            Thông tin sử dụng trên tài khoản của bạn.
                        </div>

                    </div>

                </div>


                <div class="pf-card-body">


                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="pf-form-grid">


                            {{-- NAME --}}
                            <div class="pf-field full">

                                <label
                                    for="profileName"
                                    class="pf-label"
                                >
                                    Họ và tên
                                </label>


                                <div class="pf-input-wrap">

                                    <span class="pf-input-icon">
                                        👤
                                    </span>


                                    <input
                                        type="text"
                                        id="profileName"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="pf-input"
                                        maxlength="255"
                                        autocomplete="name"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- EMAIL --}}
                            <div class="pf-field full">

                                <label class="pf-label">
                                    Email đăng nhập
                                </label>


                                <div class="pf-input-wrap">

                                    <span class="pf-input-icon">
                                        ✉
                                    </span>


                                    <input
                                        type="email"
                                        value="{{ $user->email }}"
                                        class="pf-input"
                                        disabled
                                    >

                                </div>


                                <div class="pf-field-note">

                                    Email hiện được giữ nguyên
                                    để không ảnh hưởng tới
                                    đăng nhập và xác thực OTP.

                                </div>

                            </div>


                            {{-- ROLE --}}
                            <div class="pf-field">

                                <label class="pf-label">
                                    Loại tài khoản
                                </label>


                                <div class="pf-info-box">

                                    <span class="pf-info-label">
                                        Vai trò
                                    </span>

                                    <span class="pf-info-value">
                                        {{ $roleLabel }}
                                    </span>

                                </div>

                            </div>


                            {{-- ACCOUNT STATUS --}}
                            <div class="pf-field">

                                <label class="pf-label">
                                    Trạng thái
                                </label>


                                <div class="pf-info-box">

                                    <span class="pf-info-label">
                                        Tài khoản
                                    </span>

                                    <span
                                        class="
                                            pf-info-value
                                            pf-active
                                        "
                                    >
                                        ✅ Đang hoạt động
                                    </span>

                                </div>

                            </div>


                            {{-- EMAIL STATUS --}}
                            <div class="pf-field">

                                <label class="pf-label">
                                    Xác thực email
                                </label>


                                <div class="pf-info-box">

                                    <span class="pf-info-label">
                                        Email
                                    </span>


                                    <span
                                        class="
                                            pf-info-value
                                            {{
                                                $emailVerified
                                                ? 'pf-active'
                                                : ''
                                            }}
                                        "
                                    >

                                        {{
                                            $emailVerified
                                            ? '✓ Đã xác thực'
                                            : '⚠️ Chưa xác thực'
                                        }}

                                    </span>

                                </div>

                            </div>


                            {{-- MEMBER SINCE --}}
                            <div class="pf-field">

                                <label class="pf-label">
                                    Thành viên từ
                                </label>


                                <div class="pf-info-box">

                                    <span class="pf-info-label">
                                        Ngày đăng ký
                                    </span>

                                    <span class="pf-info-value">

                                        {{
                                            $user
                                                ->created_at
                                                ->format(
                                                    'd/m/Y'
                                                )
                                        }}

                                    </span>

                                </div>

                            </div>


                            {{-- BUTTON --}}
                            <div class="pf-field full">

                                <button
                                    type="submit"
                                    class="pf-primary-btn"
                                >
                                    💾 Lưu thay đổi
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </section>


            @include('user.partials.shipping-addresses')

            {{-- =============================================
                PASSWORD
            ============================================== --}}
            <section class="pf-card">

                <div class="pf-card-head">

                    <div>

                        <h2 class="pf-card-title">
                            🔐 Đổi mật khẩu
                        </h2>

                        <div class="pf-card-subtitle">
                            Cập nhật mật khẩu đăng nhập tài khoản.
                        </div>

                    </div>

                </div>


                <div class="pf-card-body">


                    <div class="pf-password-note">

                        <span>
                            🛡️
                        </span>

                        <span>

                            Mật khẩu mới phải có
                            ít nhất <strong>8 ký tự</strong>
                            và phải khác mật khẩu hiện tại.
                            Không chia sẻ mật khẩu
                            hoặc mã OTP cho người khác.

                        </span>

                    </div>


                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                        id="profilePasswordForm"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="pf-form-grid">


                            {{-- CURRENT PASSWORD --}}
                            <div class="pf-field full">

                                <label
                                    for="currentPassword"
                                    class="pf-label"
                                >
                                    Mật khẩu hiện tại
                                </label>


                                <div class="pf-input-wrap">

                                    <span class="pf-input-icon">
                                        🔑
                                    </span>


                                    <input
                                        type="password"
                                        id="currentPassword"
                                        name="current_password"
                                        class="pf-input"
                                        autocomplete="current-password"
                                        required
                                    >


                                    <button
                                        type="button"
                                        class="pf-password-toggle"
                                        data-password-toggle="currentPassword"
                                        aria-label="Hiện mật khẩu"
                                    >
                                        👁
                                    </button>

                                </div>

                            </div>


                            {{-- NEW PASSWORD --}}
                            <div class="pf-field">

                                <label
                                    for="newPassword"
                                    class="pf-label"
                                >
                                    Mật khẩu mới
                                </label>


                                <div class="pf-input-wrap">

                                    <span class="pf-input-icon">
                                        🔒
                                    </span>


                                    <input
                                        type="password"
                                        id="newPassword"
                                        name="password"
                                        class="pf-input"
                                        minlength="8"
                                        autocomplete="new-password"
                                        required
                                    >


                                    <button
                                        type="button"
                                        class="pf-password-toggle"
                                        data-password-toggle="newPassword"
                                        aria-label="Hiện mật khẩu"
                                    >
                                        👁
                                    </button>

                                </div>

                            </div>


                            {{-- CONFIRM PASSWORD --}}
                            <div class="pf-field">

                                <label
                                    for="newPasswordConfirmation"
                                    class="pf-label"
                                >
                                    Xác nhận mật khẩu mới
                                </label>


                                <div class="pf-input-wrap">

                                    <span class="pf-input-icon">
                                        🔒
                                    </span>


                                    <input
                                        type="password"
                                        id="newPasswordConfirmation"
                                        name="password_confirmation"
                                        class="pf-input"
                                        minlength="8"
                                        autocomplete="new-password"
                                        required
                                    >


                                    <button
                                        type="button"
                                        class="pf-password-toggle"
                                        data-password-toggle="newPasswordConfirmation"
                                        aria-label="Hiện mật khẩu"
                                    >
                                        👁
                                    </button>

                                </div>

                            </div>


                            <div class="pf-field full">

                                <button
                                    type="submit"
                                    class="pf-primary-btn"
                                >
                                    🔒 Cập nhật mật khẩu
                                </button>

                            </div>

                        </div>

                    </form>


                    <div class="pf-security-grid">

                        <div class="pf-security-item">

                            <strong>
                                🔐 Mật khẩu
                            </strong>

                            Tối thiểu 8 ký tự.

                        </div>


                        <div class="pf-security-item">

                            <strong>
                                ✉ Email
                            </strong>

                            Được sử dụng cho đăng nhập
                            và xác thực OTP.

                        </div>


                        <div class="pf-security-item">

                            <strong>
                                🛡 Bảo mật
                            </strong>

                            Không chia sẻ mật khẩu
                            hoặc OTP.

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | AVATAR PREVIEW
        |--------------------------------------------------------------------------
        */

        const avatarInput =
            document.getElementById(
                'profileAvatarInput'
            );


        const avatarPreview =
            document.getElementById(
                'avatarPreview'
            );


        const avatarPlaceholder =
            document.getElementById(
                'avatarPlaceholder'
            );


        if (
            avatarInput
            &&
            avatarPreview
        ) {

            avatarInput.addEventListener(
                'change',
                function () {

                    const file =
                        avatarInput.files
                        &&
                        avatarInput.files[0];


                    if (!file) {
                        return;
                    }


                    if (
                        !file.type.startsWith(
                            'image/'
                        )
                    ) {

                        avatarInput.value =
                            '';

                        window.alert(
                            'Vui lòng chọn một tệp hình ảnh.'
                        );

                        return;

                    }


                    if (
                        file.size
                        >
                        2
                        *
                        1024
                        *
                        1024
                    ) {

                        avatarInput.value =
                            '';

                        window.alert(
                            'Ảnh đại diện không được vượt quá 2MB.'
                        );

                        return;

                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            avatarPreview.src =
                                event.target.result;


                            avatarPreview.style.display =
                                'block';


                            if (avatarPlaceholder) {

                                avatarPlaceholder.style.display =
                                    'none';

                            }

                        };


                    reader.readAsDataURL(
                        file
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD VISIBILITY
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '[data-password-toggle]'
            )
            .forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const targetId =
                                button.dataset
                                    .passwordToggle;


                            const input =
                                document.getElementById(
                                    targetId
                                );


                            if (!input) {
                                return;
                            }


                            const showing =
                                input.type
                                ===
                                'text';


                            input.type =
                                showing
                                ? 'password'
                                : 'text';


                            button.textContent =
                                showing
                                ? '👁'
                                : '🙈';


                            button.setAttribute(
                                'aria-label',
                                showing
                                ? 'Hiện mật khẩu'
                                : 'Ẩn mật khẩu'
                            );

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | PASSWORD CONFIRMATION
        |--------------------------------------------------------------------------
        */

        const passwordForm =
            document.getElementById(
                'profilePasswordForm'
            );


        const newPassword =
            document.getElementById(
                'newPassword'
            );


        const confirmation =
            document.getElementById(
                'newPasswordConfirmation'
            );


        if (
            passwordForm
            &&
            newPassword
            &&
            confirmation
        ) {

            passwordForm.addEventListener(
                'submit',
                function (event) {

                    if (
                        newPassword.value
                        !==
                        confirmation.value
                    ) {

                        event.preventDefault();

                        window.alert(
                            'Xác nhận mật khẩu mới không khớp.'
                        );

                        confirmation.focus();

                    }

                }
            );

        }

    }
);
</script>

@endsection
