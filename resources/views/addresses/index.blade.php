@extends('layouts.app')

@section('title', 'Địa chỉ giao hàng | Tinh Hoa Tây Bắc')

@section('content')

@php
    $defaultAddress =
        $addresses
            ->firstWhere(
                'is_default',
                true
            );

    $addressCount =
        $addresses->count();
@endphp


<style>
    .address-page {
        --ad-green: #35562f;
        --ad-green-dark: #274522;

        --ad-brown: #633820;
        --ad-brown-dark: #3d2316;

        --ad-red: #b43e2e;
        --ad-red-dark: #8d3025;

        --ad-gold: #e5ad42;
        --ad-gold-soft: #fff0c9;

        --ad-text: #302923;
        --ad-muted: #776d66;

        --ad-border: #e7dfd5;

        --ad-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --ad-shadow-lg:
            0 18px 48px
            rgba(54, 40, 29, .12);

        color: var(--ad-text);
    }


    .address-page *,
    .address-page *::before,
    .address-page *::after {
        box-sizing: border-box;
    }


    .address-page a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .ad-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .ad-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .ad-breadcrumb a:hover {
        color: var(--ad-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .ad-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 190px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;

        margin-bottom: 18px;

        padding:
            31px 34px;

        border-radius: 20px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 15%,
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
            var(--ad-shadow-lg);
    }


    .ad-hero::before {
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


    .ad-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -35px;
        bottom: -60px;

        width: 340px;
        height: 190px;

        opacity: .1;

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


    .ad-hero-copy {
        position: relative;

        z-index: 2;

        max-width: 720px;
    }


    .ad-kicker {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffdb91;

        background:
            rgba(255,255,255,.06);

        font-size: 10.5px;

        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .ad-title {
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


    .ad-description {
        max-width: 650px;

        margin-top: 8px;

        color:
            rgba(255,255,255,.74);

        font-size: 13px;

        line-height: 1.65;
    }


    .ad-hero-actions {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: flex-end;
        flex-direction: column;

        gap: 8px;
    }


    .ad-add-btn {
        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        padding:
            0 14px;

        border:
            1px solid
            rgba(255,255,255,.22);

        border-radius: 10px;

        color:
            var(--ad-brown-dark);

        background:
            #ffdf91;

        font-size: 10.5px;

        font-weight: 950;

        cursor: pointer;
    }


    .ad-add-btn:hover {
        background: #ffcf62;
    }


    .ad-back-profile {
        color:
            rgba(255,255,255,.82);

        font-size: 9.5px;

        font-weight: 850;
    }


    .ad-back-profile:hover {
        color: #fff;
    }


    /* =========================================================
       STATS
    ========================================================= */

    .ad-stats {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 11px;

        margin-bottom: 18px;
    }


    .ad-stat {
        min-height: 95px;

        display: flex;
        align-items: center;

        gap: 12px;

        padding: 14px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--ad-shadow);
    }


    .ad-stat-icon {
        width: 45px;
        height: 45px;

        flex: 0 0 45px;

        display: grid;
        place-items: center;

        border-radius: 12px;

        background:
            var(--ad-gold-soft);

        font-size: 20px;
    }


    .ad-stat:nth-child(2)
    .ad-stat-icon {
        background: #e9f5e6;
    }


    .ad-stat:nth-child(3)
    .ad-stat-icon {
        background: #edf3ff;
    }


    .ad-stat-label {
        color:
            var(--ad-muted);

        font-size: 10px;

        font-weight: 750;
    }


    .ad-stat-value {
        margin-top: 2px;

        color:
            var(--ad-brown-dark);

        font-size: 17px;

        line-height: 1.2;

        font-weight: 950;
    }


    /* =========================================================
       GENERIC CARD
    ========================================================= */

    .ad-panel {
        overflow: hidden;

        margin-bottom: 16px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--ad-shadow);
    }


    .ad-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            15px 17px;

        border-bottom:
            1px solid
            var(--ad-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf7
            );
    }


    .ad-panel-title {
        margin: 0;

        color: #453930;

        font-size: 14px;

        font-weight: 950;
    }


    .ad-panel-subtitle {
        margin-top: 2px;

        color:
            var(--ad-muted);

        font-size: 10px;
    }


    .ad-panel-body {
        padding: 17px;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .ad-form {
        display: grid;

        grid-template-columns:
            repeat(
                12,
                minmax(0, 1fr)
            );

        gap: 12px;
    }


    .ad-field {
        grid-column:
            span 4;
    }


    .ad-field.half {
        grid-column:
            span 6;
    }


    .ad-field.full {
        grid-column:
            1 / -1;
    }


    .ad-label {
        display: block;

        margin-bottom: 6px;

        color: #51443b;

        font-size: 10.5px;

        font-weight: 900;
    }


    .ad-required {
        color:
            var(--ad-red);
    }


    .ad-input-wrap {
        position: relative;
    }


    .ad-input-icon {
        position: absolute;

        top: 50%;
        left: 12px;

        transform:
            translateY(-50%);

        font-size: 14px;

        pointer-events: none;
    }


    .ad-input {
        width: 100%;
        height: 44px;

        padding:
            0 12px 0 38px;

        border:
            1px solid #ddd2c6;

        border-radius: 10px;

        outline: 0;

        color:
            var(--ad-text);

        background: #fff;

        font-size: 11.5px;

        transition:
            border-color .17s ease,
            box-shadow .17s ease;
    }


    .ad-input:focus {
        border-color:
            var(--ad-gold);

        box-shadow:
            0 0 0 3px
            rgba(229,173,66,.11);
    }


    .ad-check {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        min-height: 38px;

        padding:
            7px 10px;

        border:
            1px solid #e3d9ce;

        border-radius: 9px;

        color: #5f534b;

        background:
            #fbfaf8;

        font-size: 10px;

        font-weight: 800;
    }


    .ad-check input {
        width: 16px;
        height: 16px;

        accent-color:
            var(--ad-green);
    }


    .ad-form-actions {
        grid-column:
            1 / -1;

        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        padding-top: 2px;
    }


    .ad-save-btn {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        padding:
            0 14px;

        border: 0;

        border-radius: 9px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--ad-red),
                var(--ad-red-dark)
            );

        font-size: 10px;

        font-weight: 950;
    }


    .ad-save-btn:hover {
        box-shadow:
            0 8px 17px
            rgba(180,62,46,.19);
    }


    .ad-cancel-btn {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 13px;

        border:
            1px solid #ddd2c6;

        border-radius: 9px;

        color: #63564d;

        background: #fff;

        font-size: 10px;

        font-weight: 850;
    }


    /* =========================================================
       ADDRESS GRID
    ========================================================= */

    .ad-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 14px;

        margin:
            22px 0 12px;
    }


    .ad-section-title {
        margin: 0;

        color:
            var(--ad-text);

        font-size: 20px;

        font-weight: 950;

        letter-spacing: -.025em;
    }


    .ad-section-subtitle {
        margin-top: 3px;

        color:
            var(--ad-muted);

        font-size: 10.5px;
    }


    .ad-count {
        flex: 0 0 auto;

        padding:
            6px 9px;

        border-radius: 999px;

        color:
            var(--ad-brown-dark);

        background:
            var(--ad-gold-soft);

        font-size: 9px;

        font-weight: 900;
    }


    .ad-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 13px;
    }


    /* =========================================================
       ADDRESS CARD
    ========================================================= */

    .ad-card {
        position: relative;

        overflow: hidden;

        display: flex;
        flex-direction: column;

        min-height: 260px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--ad-shadow);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }


    .ad-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            var(--ad-shadow-lg);
    }


    .ad-card.default {
        border:
            2px solid
            #75906a;

        background:
            linear-gradient(
                145deg,
                #fbfff9,
                #fff
            );
    }


    .ad-card.default::before {
        content: "";

        position: absolute;

        top: 0;
        left: 0;
        bottom: 0;

        width: 4px;

        background:
            var(--ad-green);
    }


    .ad-card-body {
        flex: 1;

        padding:
            17px;
    }


    .ad-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 13px;
    }


    .ad-label-wrap {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .ad-label-icon {
        width: 39px;
        height: 39px;

        flex: 0 0 39px;

        display: grid;
        place-items: center;

        border-radius: 10px;

        background:
            var(--ad-gold-soft);

        font-size: 18px;
    }


    .ad-card.default
    .ad-label-icon {
        background:
            #e8f3e4;
    }


    .ad-address-label {
        color:
            var(--ad-brown-dark);

        font-size: 13px;

        font-weight: 950;
    }


    .ad-default-badge {
        display: inline-flex;
        align-items: center;

        gap: 3px;

        margin-top: 3px;

        padding:
            4px 7px;

        border-radius: 999px;

        color:
            var(--ad-green-dark);

        background:
            #e7f3e4;

        font-size: 8px;

        font-weight: 900;
    }


    .ad-receiver {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 6px;

        margin-bottom: 9px;

        color: #453a32;

        font-size: 11.5px;

        font-weight: 900;
    }


    .ad-phone {
        color:
            var(--ad-red);

        font-weight: 900;
    }


    .ad-address-text {
        display: flex;
        align-items: flex-start;

        gap: 8px;

        color:
            var(--ad-muted);

        font-size: 10.5px;

        line-height: 1.65;
    }


    .ad-address-text-icon {
        flex: 0 0 auto;

        margin-top: 1px;
    }


    .ad-card-meta {
        margin-top: 13px;

        padding-top: 11px;

        border-top:
            1px dashed #e7ddd2;

        color: #978c84;

        font-size: 8.5px;
    }


    /* =========================================================
       CARD ACTIONS
    ========================================================= */

    .ad-card-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 6px;

        padding:
            11px 15px;

        border-top:
            1px solid
            var(--ad-border);

        background:
            #fdfbf8;
    }


    .ad-action-btn {
        min-height: 34px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 4px;

        padding:
            0 9px;

        border:
            1px solid #ddd2c7;

        border-radius: 8px;

        color: #5e5047;

        background: #fff;

        font-size: 8.5px;

        font-weight: 900;
    }


    .ad-action-btn:hover {
        color:
            var(--ad-brown);

        border-color:
            #d2b48d;

        background:
            #fff8ec;
    }


    .ad-action-btn.default {
        color:
            var(--ad-green-dark);

        border-color:
            #b9cfb2;

        background:
            #eef7eb;
    }


    .ad-action-btn.delete {
        color:
            var(--ad-red);

        border-color:
            #e1bbb5;

        background:
            #fff7f5;
    }


    .ad-action-btn.delete:hover {
        color: #fff;

        border-color:
            var(--ad-red);

        background:
            var(--ad-red);
    }


    /* =========================================================
       EDIT
    ========================================================= */

    .ad-edit-box {
        padding:
            16px;

        border-top:
            1px solid
            var(--ad-border);

        background:
            #fffaf3;
    }


    .ad-edit-title {
        margin-bottom: 13px;

        color:
            var(--ad-brown-dark);

        font-size: 12px;

        font-weight: 950;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .ad-empty {
        min-height: 370px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 35px;

        border:
            1px dashed
            #dbc6a6;

        border-radius: 17px;

        background:
            radial-gradient(
                circle at 50% 0,
                rgba(229,173,66,.14),
                transparent 32%
            ),
            #fff;

        box-shadow:
            var(--ad-shadow);

        text-align: center;
    }


    .ad-empty-icon {
        width: 86px;
        height: 86px;

        display: grid;
        place-items: center;

        margin:
            0 auto 13px;

        border-radius: 50%;

        background:
            var(--ad-gold-soft);

        font-size: 38px;
    }


    .ad-empty h2 {
        margin: 0;

        color:
            var(--ad-text);

        font-size: 21px;

        font-weight: 950;
    }


    .ad-empty p {
        max-width: 430px;

        margin:
            7px auto 17px;

        color:
            var(--ad-muted);

        font-size: 10.5px;

        line-height: 1.6;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .ad-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 767.98px) {

        .ad-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                24px 21px;
        }


        .ad-hero-actions {
            align-items: flex-start;
        }


        .ad-stats {
            grid-template-columns: 1fr;
        }


        .ad-field,
        .ad-field.half {
            grid-column:
                1 / -1;
        }

    }


    @media (max-width: 575.98px) {

        .ad-panel-head,
        .ad-section-head {
            align-items: flex-start;

            flex-direction: column;
        }


        .ad-card-actions {
            align-items: stretch;

            flex-direction: column;
        }


        .ad-card-actions form,
        .ad-action-btn {
            width: 100%;
        }

    }
</style>


<div class="address-page">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="ad-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <a href="{{ route('profile') }}">
            Hồ sơ
        </a>

        <span>›</span>

        <span>
            Địa chỉ giao hàng
        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="ad-hero">

        <div class="ad-hero-copy">

            <div class="ad-kicker">
                • Sổ địa chỉ
            </div>


            <h1 class="ad-title">
                Địa chỉ giao hàng
            </h1>


            <div class="ad-description">

                Lưu sẵn địa chỉ người nhận
                để quá trình thanh toán nhanh hơn.
                Bạn có thể thêm nhiều địa chỉ
                và chọn một địa chỉ mặc định.

            </div>

        </div>


        <div class="ad-hero-actions">

            <button
                type="button"
                class="ad-add-btn"
                data-bs-toggle="collapse"
                data-bs-target="#newAddressForm"
                aria-expanded="{{
                    $addresses->isEmpty()
                    ? 'true'
                    : 'false'
                }}"
            >
                ＋ Thêm địa chỉ mới
            </button>


            <a
                href="{{ route('profile') }}"
                class="ad-back-profile"
            >
                ← Quay lại hồ sơ
            </a>

        </div>

    </section>


    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="ad-stats">


        <div class="ad-stat">

            <div class="ad-stat-icon">
                •
            </div>


            <div>

                <div class="ad-stat-label">
                    Địa chỉ đã lưu
                </div>

                <div class="ad-stat-value">
                    {{ $addressCount }}
                </div>

            </div>

        </div>


        <div class="ad-stat">

            <div class="ad-stat-icon">
                •
            </div>


            <div>

                <div class="ad-stat-label">
                    Địa chỉ mặc định
                </div>

                <div class="ad-stat-value">

                    {{
                        $defaultAddress
                        ? $defaultAddress->label
                        : 'Chưa có'
                    }}

                </div>

            </div>

        </div>


        <div class="ad-stat">

            <div class="ad-stat-icon">
                •
            </div>


            <div>

                <div class="ad-stat-label">
                    Sử dụng khi checkout
                </div>

                <div class="ad-stat-value">
                    Chọn nhanh
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        ADD FORM
    ====================================================== --}}
    <div
        class="
            collapse
            {{
                $addresses->isEmpty()
                || $errors->any()
                ? 'show'
                : ''
            }}
        "
        id="newAddressForm"
    >

        <section class="ad-panel">


            <div class="ad-panel-head">

                <div>

                    <h2 class="ad-panel-title">
                        ＋ Thêm địa chỉ mới
                    </h2>

                    <div class="ad-panel-subtitle">
                        Điền đầy đủ thông tin người nhận.
                    </div>

                </div>

            </div>


            <div class="ad-panel-body">


                <form
                    method="POST"
                    action="{{ route('addresses.store') }}"
                >

                    @csrf


                    <div class="ad-form">


                        {{-- LABEL --}}
                        <div class="ad-field">

                            <label
                                for="newAddressLabel"
                                class="ad-label"
                            >
                                Tên gợi nhớ

                                <span class="ad-required">
                                    *
                                </span>
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newAddressLabel"
                                    name="label"
                                    value="{{ old('label', 'Nhà') }}"
                                    class="ad-input"
                                    maxlength="50"
                                    placeholder="Nhà, Công ty..."
                                    required
                                >

                            </div>

                        </div>


                        {{-- RECEIVER --}}
                        <div class="ad-field">

                            <label
                                for="newReceiverName"
                                class="ad-label"
                            >
                                Người nhận

                                <span class="ad-required">
                                    *
                                </span>
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newReceiverName"
                                    name="receiver_name"
                                    value="{{
                                        old(
                                            'receiver_name',
                                            Auth::user()->name
                                        )
                                    }}"
                                    class="ad-input"
                                    maxlength="255"
                                    placeholder="Họ tên người nhận"
                                    required
                                >

                            </div>

                        </div>


                        {{-- PHONE --}}
                        <div class="ad-field">

                            <label
                                for="newAddressPhone"
                                class="ad-label"
                            >
                                Số điện thoại

                                <span class="ad-required">
                                    *
                                </span>
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="tel"
                                    id="newAddressPhone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="ad-input"
                                    maxlength="20"
                                    placeholder="Ví dụ: 0385742505"
                                    required
                                >

                            </div>

                        </div>


                        {{-- PROVINCE --}}
                        <div class="ad-field">

                            <label
                                for="newProvince"
                                class="ad-label"
                            >
                                Tỉnh / Thành phố
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newProvince"
                                    name="province"
                                    value="{{ old('province') }}"
                                    class="ad-input"
                                    maxlength="100"
                                    placeholder="Ví dụ: Hà Nội"
                                >

                            </div>

                        </div>


                        {{-- DISTRICT --}}
                        <div class="ad-field">

                            <label
                                for="newDistrict"
                                class="ad-label"
                            >
                                Quận / Huyện
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newDistrict"
                                    name="district"
                                    value="{{ old('district') }}"
                                    class="ad-input"
                                    maxlength="100"
                                    placeholder="Ví dụ: Nam Từ Liêm"
                                >

                            </div>

                        </div>


                        {{-- WARD --}}
                        <div class="ad-field">

                            <label
                                for="newWard"
                                class="ad-label"
                            >
                                Phường / Xã
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newWard"
                                    name="ward"
                                    value="{{ old('ward') }}"
                                    class="ad-input"
                                    maxlength="100"
                                    placeholder="Phường / Xã"
                                >

                            </div>

                        </div>


                        {{-- DETAIL --}}
                        <div class="ad-field full">

                            <label
                                for="newAddressDetail"
                                class="ad-label"
                            >
                                Địa chỉ chi tiết

                                <span class="ad-required">
                                    *
                                </span>
                            </label>


                            <div class="ad-input-wrap">

                                <span class="ad-input-icon">
                                    •
                                </span>


                                <input
                                    type="text"
                                    id="newAddressDetail"
                                    name="address_detail"
                                    value="{{ old('address_detail') }}"
                                    class="ad-input"
                                    maxlength="500"
                                    placeholder="Số nhà, tên đường, thôn/xóm..."
                                    required
                                >

                            </div>

                        </div>


                        {{-- DEFAULT --}}
                        <div class="ad-field full">

                            <label class="ad-check">

                                <input
                                    type="checkbox"
                                    name="is_default"
                                    value="1"
                                    {{
                                        old('is_default')
                                        ? 'checked'
                                        : ''
                                    }}
                                >

                                <span>
                                    Đặt làm địa chỉ mặc định
                                </span>

                            </label>

                        </div>


                        {{-- ACTIONS --}}
                        <div class="ad-form-actions">

                            <button
                                type="submit"
                                class="ad-save-btn"
                            >
                                • Lưu địa chỉ
                            </button>


                            @if($addresses->isNotEmpty())

                                <button
                                    type="button"
                                    class="ad-cancel-btn"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#newAddressForm"
                                >
                                    Hủy
                                </button>

                            @endif

                        </div>

                    </div>

                </form>

            </div>

        </section>

    </div>


    {{-- =====================================================
        LIST HEADING
    ====================================================== --}}
    <div class="ad-section-head">

        <div>

            <h2 class="ad-section-title">
                Địa chỉ đã lưu
            </h2>


            <div class="ad-section-subtitle">
                Quản lý những địa chỉ dùng khi đặt hàng.
            </div>

        </div>


        <span class="ad-count">

            {{ $addressCount }}
            địa chỉ

        </span>

    </div>


    {{-- =====================================================
        ADDRESSES
    ====================================================== --}}
    @if($addresses->isEmpty())

        <div class="ad-empty">

            <div>

                <div class="ad-empty-icon">
                    •
                </div>


                <h2>
                    Bạn chưa lưu địa chỉ nào
                </h2>


                <p>

                    Thêm địa chỉ đầu tiên
                    để lần checkout sau
                    chỉ cần chọn địa chỉ
                    thay vì nhập lại thông tin.

                </p>


                <button
                    type="button"
                    class="ad-save-btn"
                    data-bs-toggle="collapse"
                    data-bs-target="#newAddressForm"
                >
                    ＋ Thêm địa chỉ đầu tiên
                </button>

            </div>

        </div>


    @else

        <div class="ad-grid">


            @foreach($addresses as $address)

                @php
                    $labelIcon =
                        match (
                            mb_strtolower(
                                trim($address->label)
                            )
                        ) {
                            'nhà',
                            'home' =>
                                '🏠',

                            'công ty',
                            'công ty / văn phòng',
                            'văn phòng',
                            'office' =>
                                '•',

                            default =>
                                '•',
                        };
                @endphp


                <article
                    class="
                        ad-card
                        {{
                            $address->is_default
                            ? 'default'
                            : ''
                        }}
                    "
                >


                    {{-- =========================================
                        CARD BODY
                    ========================================== --}}
                    <div class="ad-card-body">


                        <div class="ad-card-top">


                            <div class="ad-label-wrap">

                                <div class="ad-label-icon">
                                    {{ $labelIcon }}
                                </div>


                                <div>

                                    <div class="ad-address-label">

                                        {{ $address->label }}

                                    </div>


                                    @if($address->is_default)

                                        <span class="ad-default-badge">
                                            • Mặc định
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="ad-receiver">

                            <span>
                                • {{ $address->receiver_name }}
                            </span>

                            <span>
                                ·
                            </span>

                            <span class="ad-phone">
                                {{ $address->phone }}
                            </span>

                        </div>


                        <div class="ad-address-text">

                            <span class="ad-address-text-icon">
                                •
                            </span>

                            <span>
                                {{ $address->full_address }}
                            </span>

                        </div>


                        <div class="ad-card-meta">

                            Cập nhật:

                            {{
                                $address
                                    ->updated_at
                                    ->format(
                                        'H:i · d/m/Y'
                                    )
                            }}

                        </div>

                    </div>


                    {{-- =========================================
                        ACTIONS
                    ========================================== --}}
                    <div class="ad-card-actions">


                        @if(!$address->is_default)

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'addresses.default',
                                        $address
                                    )
                                }}"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="
                                        ad-action-btn
                                        default
                                    "
                                >
                                    • Đặt mặc định
                                </button>

                            </form>

                        @endif


                        <button
                            type="button"
                            class="ad-action-btn"
                            data-bs-toggle="collapse"
                            data-bs-target="#editAddress{{
                                $address->id
                            }}"
                            aria-expanded="false"
                        >
                            • Sửa
                        </button>


                        <form
                            method="POST"
                            action="{{
                                route(
                                    'addresses.destroy',
                                    $address
                                )
                            }}"
                            onsubmit="
                                return confirm(
                                    'Bạn có chắc muốn xóa địa chỉ này?'
                                );
                            "
                        >

                            @csrf
                            @method('DELETE')


                            <button
                                type="submit"
                                class="
                                    ad-action-btn
                                    delete
                                "
                            >
                                • Xóa
                            </button>

                        </form>

                    </div>


                    {{-- =========================================
                        EDIT FORM
                    ========================================== --}}
                    <div
                        class="collapse"
                        id="editAddress{{
                            $address->id
                        }}"
                    >

                        <div class="ad-edit-box">


                            <div class="ad-edit-title">
                                • Chỉnh sửa địa chỉ
                            </div>


                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'addresses.update',
                                        $address
                                    )
                                }}"
                            >

                                @csrf
                                @method('PUT')


                                <div class="ad-form">


                                    {{-- LABEL --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Tên gợi nhớ
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="label"
                                                value="{{
                                                    $address->label
                                                }}"
                                                class="ad-input"
                                                maxlength="50"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- RECEIVER --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Người nhận
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="receiver_name"
                                                value="{{
                                                    $address
                                                        ->receiver_name
                                                }}"
                                                class="ad-input"
                                                maxlength="255"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- PHONE --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Số điện thoại
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="tel"
                                                name="phone"
                                                value="{{
                                                    $address->phone
                                                }}"
                                                class="ad-input"
                                                maxlength="20"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- PROVINCE --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Tỉnh / Thành phố
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="province"
                                                value="{{
                                                    $address->province
                                                }}"
                                                class="ad-input"
                                                maxlength="100"
                                            >

                                        </div>

                                    </div>


                                    {{-- DISTRICT --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Quận / Huyện
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="district"
                                                value="{{
                                                    $address->district
                                                }}"
                                                class="ad-input"
                                                maxlength="100"
                                            >

                                        </div>

                                    </div>


                                    {{-- WARD --}}
                                    <div class="ad-field">

                                        <label class="ad-label">
                                            Phường / Xã
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="ward"
                                                value="{{
                                                    $address->ward
                                                }}"
                                                class="ad-input"
                                                maxlength="100"
                                            >

                                        </div>

                                    </div>


                                    {{-- DETAIL --}}
                                    <div class="ad-field full">

                                        <label class="ad-label">
                                            Địa chỉ chi tiết
                                        </label>


                                        <div class="ad-input-wrap">

                                            <span class="ad-input-icon">
                                                •
                                            </span>


                                            <input
                                                type="text"
                                                name="address_detail"
                                                value="{{
                                                    $address
                                                        ->address_detail
                                                }}"
                                                class="ad-input"
                                                maxlength="500"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- DEFAULT --}}
                                    <div class="ad-field full">

                                        <label class="ad-check">

                                            <input
                                                type="checkbox"
                                                name="is_default"
                                                value="1"
                                                {{
                                                    $address
                                                        ->is_default
                                                    ? 'checked'
                                                    : ''
                                                }}
                                            >

                                            <span>
                                                Đặt làm địa chỉ mặc định
                                            </span>

                                        </label>

                                    </div>


                                    <div class="ad-form-actions">

                                        <button
                                            type="submit"
                                            class="ad-save-btn"
                                        >
                                            • Lưu thay đổi
                                        </button>


                                        <button
                                            type="button"
                                            class="ad-cancel-btn"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#editAddress{{
                                                $address->id
                                            }}"
                                        >
                                            Hủy
                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @endif

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | KHI MỞ 1 FORM EDIT
        | ĐÓNG CÁC FORM EDIT KHÁC
        |--------------------------------------------------------------------------
        */

        const editCollapses =
            document.querySelectorAll(
                '[id^="editAddress"]'
            );


        editCollapses.forEach(
            function (element) {

                element.addEventListener(
                    'show.bs.collapse',
                    function () {

                        editCollapses.forEach(
                            function (other) {

                                if (
                                    other
                                    ===
                                    element
                                ) {
                                    return;
                                }


                                if (
                                    other
                                        .classList
                                        .contains(
                                            'show'
                                        )
                                ) {

                                    const instance =
                                        bootstrap
                                            .Collapse
                                            .getOrCreateInstance(
                                                other,
                                                {
                                                    toggle: false
                                                }
                                            );


                                    instance.hide();

                                }

                            }
                        );

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SCROLL TỚI FORM THÊM ĐỊA CHỈ
        |--------------------------------------------------------------------------
        */

        const newForm =
            document.getElementById(
                'newAddressForm'
            );


        if (newForm) {

            newForm.addEventListener(
                'shown.bs.collapse',
                function () {

                    newForm.scrollIntoView({
                        behavior:
                            'smooth',

                        block:
                            'start'
                    });

                }
            );

        }

    }
);
</script>

@endsection
