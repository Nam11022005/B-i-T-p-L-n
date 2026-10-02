<!DOCTYPE html>
<html lang="vi">

<head>
<script>
    (function () {
        try {
            if (window.localStorage.getItem('tinh-hoa-theme') === 'dark') {
                document.documentElement.dataset.theme = 'dark';
            }
        } catch (error) {}
    }());
</script>


    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Tinh Hoa Tây Bắc')
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="{{ asset('css/shop.css') }}"
    >


    @stack('styles')


    @php
        /*
        |--------------------------------------------------------------------------
        | DỮ LIỆU HEADER
        |--------------------------------------------------------------------------
        */

        $layoutUser =
            Auth::user();


        $layoutIsAdmin =
            $layoutUser
            &&
            $layoutUser->role === 'admin';


        $layoutCategories =
            $menuCategories
            ??
            collect();


        $layoutCartCount =
            count(
                session(
                    'cart',
                    []
                )
            );


        $layoutUnreadCount = 0;

        $layoutNotifications =
            collect();


        if ($layoutUser) {

            $layoutUnreadCount =
                $layoutUser
                    ->unreadNotifications()
                    ->count();


            $layoutNotifications =
                $layoutUser
                    ->notifications()
                    ->latest()
                    ->take(6)
                    ->get();

        }


        $layoutPendingOrders = 0;


        if ($layoutIsAdmin) {

            $layoutPendingOrders =
                \App\Models\Order::where(
                    'status',
                    'pending'
                )
                ->count();

        }


        $layoutLastName =
            $layoutUser

            ? collect(
                preg_split(
                    '/\s+/',
                    trim(
                        $layoutUser->name
                    )
                )
            )->last()

            : null;
    @endphp


    <style>
        /* =========================================================
           GLOBAL
        ========================================================= */

        :root {
            --store-green: #35562f;
            --store-green-dark: #274522;

            --store-brown: #633820;
            --store-brown-dark: #3d2316;

            --store-red: #b43e2e;
            --store-red-dark: #8d2f24;

            --store-gold: #e6ad42;
            --store-gold-soft: #fff1cb;

            --store-cream: #fff9ef;
            --store-soft: #f8f4ed;

            --store-border: #e8dfd4;

            --store-text: #302923;
            --store-muted: #746b65;

            --store-shadow:
                0 8px 28px
                rgba(55, 39, 27, .08);

            --store-shadow-lg:
                0 20px 55px
                rgba(55, 39, 27, .15);
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            min-height: 100vh;

            margin: 0;

            color:
                var(--store-text);

            background:
                #faf9f7;

            font-family:
                "Segoe UI",
                Arial,
                sans-serif;
        }


        /* Một dấu hiệu hình học dùng chung cho các thông tin phụ. */
        .tb-neutral-marker {
            display: inline-block;
            width: 10px;
            height: 10px;
            flex: 0 0 10px;
            background: var(--store-gold);
            vertical-align: middle;
        }


        a {
            text-decoration: none;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .store-header {
            position: sticky;

            top: 0;

            z-index: 3000;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .97
                );

            border-bottom:
                1px solid
                var(--store-border);

            box-shadow:
                0 5px 25px
                rgba(50, 36, 25, .09);

            backdrop-filter:
                blur(12px);
        }


        /* =========================================================
           TOP BAR
        ========================================================= */

        .store-topbar {
            min-height: 32px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .82
                );

            background:
                linear-gradient(
                    90deg,
                    #2c4328,
                    #416037 58%,
                    #5e3924
                );

            font-size: 10px;
        }


        .store-topbar-inner {
            width:
                min(
                    1480px,
                    calc(100% - 38px)
                );

            min-height: 32px;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 20px;

            margin: 0 auto;
        }


        .store-topbar-right {
            display: flex;
            align-items: center;

            gap: 18px;
        }


        .store-topbar-item {
            display: inline-flex;
            align-items: center;

            gap: 5px;
        }


        .store-topbar a {
            color:
                rgba(
                    255,
                    255,
                    255,
                    .84
                );
        }


        .store-topbar a:hover {
            color:
                #ffe09b;
        }


        /* =========================================================
           MAIN HEADER
        ========================================================= */

        .store-main-header {
            width:
                min(
                    1480px,
                    calc(100% - 38px)
                );

            min-height: 82px;

            display: grid;

            grid-template-columns:
                245px
                minmax(
                    300px,
                    1fr
                )
                auto;

            align-items: center;

            gap: 28px;

            margin: 0 auto;
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .store-brand {
            display: flex;
            align-items: center;

            gap: 11px;

            color:
                var(--store-brown-dark);
        }


        .store-brand:hover {
            color:
                var(--store-red);
        }


        .store-brand-mark {
            width: 46px;
            height: 46px;

            flex: 0 0 46px;

            display: grid;
            place-items: center;

            border:
                1px solid #dfc490;

            border-radius: 14px;

            background:
                linear-gradient(
                    145deg,
                    #fff2c9,
                    #ebc76f
                );

            box-shadow:
                0 7px 17px
                rgba(98, 56, 32, .12);

            font-size: 22px;
        }


        .store-brand-copy {
            min-width: 0;
        }


        .store-brand-name {
            display: block;

            color:
                var(--store-brown-dark);

            font-size: 18px;

            font-weight: 950;

            letter-spacing:
                -.035em;

            white-space: nowrap;
        }


        .store-brand-tagline {
            display: block;

            margin-top: 1px;

            color:
                var(--store-muted);

            font-size: 9px;

            font-weight: 700;

            letter-spacing: .03em;
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .store-search {
            position: relative;

            width: 100%;
        }


        .store-search-form {
            position: relative;

            width: 100%;
        }


        .store-search-input {
            width: 100%;
            height: 48px;

            padding:
                0 58px
                0 19px;

            border:
                2px solid
                #dcc18f;

            border-radius: 12px;

            outline: 0;

            color:
                var(--store-text);

            background: #fff;

            font-size: 13px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }


        .store-search-input::placeholder {
            color: #9b9189;
        }


        .store-search-input:focus {
            border-color:
                var(--store-gold);

            box-shadow:
                0 0 0 4px
                rgba(230, 173, 66, .11);
        }


        .store-search-button {
            position: absolute;

            top: 5px;
            right: 5px;

            width: 38px;
            height: 38px;

            display: grid;
            place-items: center;

            border: 0;

            border-radius: 9px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--store-red),
                    var(--store-red-dark)
                );

            cursor: pointer;

            transition:
                transform .17s ease,
                box-shadow .17s ease;
        }


        .store-search-button:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 6px 15px
                rgba(180, 62, 46, .23);
        }


        /* =========================================================
           SEARCH SUGGESTIONS
        ========================================================= */

        .product-search-suggestions {
            position: absolute;

            z-index: 6000;

            top:
                calc(
                    100% + 7px
                );

            left: 0;
            right: 0;

            display: none;

            max-height: 435px;

            overflow-y: auto;

            border:
                1px solid
                var(--store-border);

            border-radius: 14px;

            background: #fff;

            box-shadow:
                var(--store-shadow-lg);
        }


        .product-search-suggestions.show {
            display: block;
        }


        .product-search-suggestion {
            display: flex;
            align-items: center;

            gap: 11px;

            padding:
                10px 12px;

            border-bottom:
                1px solid #eee8e1;

            color:
                var(--store-text);
        }


        .product-search-suggestion:hover,
        .product-search-suggestion.active {
            color:
                var(--store-text);

            background:
                #fff8eb;
        }


        .product-search-suggestion:last-child {
            border-bottom: 0;
        }


        .product-search-suggestion-image {
            width: 52px;
            height: 52px;

            flex: 0 0 52px;

            border:
                1px solid #e8ddd0;

            border-radius: 10px;

            object-fit: cover;

            background:
                #faf7f3;
        }


        .product-search-suggestion-placeholder {
            display: grid;
            place-items: center;

            font-size: 21px;
        }


        .product-search-suggestion-body {
            flex: 1;

            min-width: 0;
        }


        .product-search-suggestion-name {
            overflow: hidden;

            color:
                var(--store-text);

            font-size: 12px;

            font-weight: 900;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .product-search-suggestion-meta {
            margin-top: 3px;

            color:
                var(--store-muted);

            font-size: 10px;
        }


        .product-search-suggestion-price {
            flex: 0 0 auto;

            color:
                var(--store-red);

            font-size: 12px;

            font-weight: 950;

            text-align: right;
        }


        .product-search-suggestion-old-price {
            display: block;

            margin-top: 2px;

            color: #9d948d;

            font-size: 9px;

            font-weight: 500;

            text-decoration:
                line-through;
        }


        .product-search-message {
            padding: 18px;

            color:
                var(--store-muted);

            text-align: center;

            font-size: 11px;
        }


        .product-search-view-all {
            display: block;

            padding:
                11px 12px;

            border-top:
                1px solid
                var(--store-border);

            color:
                var(--store-red);

            background:
                #fffaf0;

            text-align: center;

            font-size: 11px;

            font-weight: 900;
        }


        .product-search-view-all:hover {
            color:
                var(--store-brown-dark);

            background:
                #fff3db;
        }


        /* =========================================================
           QUICK ACTIONS
        ========================================================= */

        .store-quick-actions {
            display: flex;
            align-items: center;

            gap: 5px;
        }


        .store-action {
            position: relative;

            min-width: 58px;

            min-height: 51px;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            gap: 1px;

            padding:
                5px 8px;

            border:
                1px solid transparent;

            border-radius: 10px;

            color:
                #564a41;

            font-size: 9px;

            font-weight: 800;

            white-space: nowrap;

            transition:
                background .17s ease,
                border-color .17s ease,
                color .17s ease;
        }


        .store-action:hover,
        .store-action.active {
            color:
                var(--store-red);

            border-color:
                #ead8c1;

            background:
                #fff8ed;
        }


        .store-action-icon {
            font-size: 18px;
            line-height: 1;
        }


        .store-action-badge {
            position: absolute;

            top: 1px;
            right: 3px;

            min-width: 18px;
            height: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding:
                0 4px;

            border:
                2px solid #fff;

            border-radius: 999px;

            color: #fff;

            background:
                var(--store-red);

            font-size: 8px;

            font-weight: 950;
        }


        /* =========================================================
           ACCOUNT DROPDOWN
        ========================================================= */

        .store-account {
            position: relative;
        }


        .store-account .dropdown-toggle::after {
            display: none;
        }


        .store-dropdown-menu {
            min-width: 245px;

            padding: 8px;

            border:
                1px solid
                var(--store-border);

            border-radius: 14px;

            box-shadow:
                var(--store-shadow-lg);
        }


        .store-dropdown-menu
        .dropdown-item {
            padding:
                9px 10px;

            border-radius: 9px;

            color:
                #50443c;

            font-size: 11px;

            font-weight: 700;
        }


        .store-dropdown-menu
        .dropdown-item:hover {
            color:
                var(--store-red);

            background:
                #fff7e9;
        }


        /* =========================================================
           NAVIGATION BAR
        ========================================================= */

        .store-nav {
            border-top:
                1px solid
                #eee7de;

            background:
                #fff;
        }


        .store-nav-inner {
            width:
                min(
                    1480px,
                    calc(100% - 38px)
                );

            min-height: 43px;

            display: flex;
            align-items: center;

            gap: 5px;

            margin: 0 auto;
        }


        .store-nav-link {
            min-height: 42px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding:
                0 13px;

            border-bottom:
                2px solid transparent;

            color:
                #544940;

            font-size: 11px;

            font-weight: 850;

            white-space: nowrap;
        }


        .store-nav-link:hover,
        .store-nav-link.active {
            color:
                var(--store-red);

            border-bottom-color:
                var(--store-red);
        }


        .store-nav-sale {
            color:
                var(--store-red);
        }


        .store-nav-spacer {
            margin-left: auto;
        }


        /* =========================================================
           CATEGORY MEGA MENU
        ========================================================= */

        .store-category {
            position: relative;
        }


        .store-category-trigger {
            min-width: 190px;

            min-height: 42px;

            display: inline-flex;
            align-items: center;

            gap: 8px;

            padding:
                0 15px;

            border: 0;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--store-green-dark),
                    var(--store-green)
                );

            font-size: 11px;

            font-weight: 900;
        }


        .store-category-trigger:hover {
            color: #fff;
        }


        .store-category-trigger-arrow {
            margin-left: auto;

            font-size: 10px;
        }


        .store-mega {
            position: absolute;

            z-index: 5500;

            top: 100%;
            left: 0;

            width:
                min(
                    920px,
                    calc(100vw - 40px)
                );

            display: none;

            grid-template-columns:
                250px
                minmax(0, 1fr);

            overflow: hidden;

            border:
                1px solid
                var(--store-border);

            border-radius:
                0 0 16px 16px;

            background: #fff;

            box-shadow:
                var(--store-shadow-lg);
        }


        .store-category:hover
        .store-mega,
        .store-category.mega-open
        .store-mega {
            display: grid;
        }


        .store-mega-left {
            max-height: 480px;

            overflow-y: auto;

            padding:
                10px 0;

            border-right:
                1px solid
                var(--store-border);

            background:
                #fff9ee;
        }


        .store-mega-title {
            padding:
                7px 15px 10px;

            color:
                var(--store-brown-dark);

            font-size: 9px;

            font-weight: 950;

            letter-spacing: .08em;

            text-transform: uppercase;
        }


        .store-category-tab {
            width: 100%;

            min-height: 39px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            padding:
                7px 15px;

            border: 0;

            color:
                #514740;

            background:
                transparent;

            text-align: left;

            font-size: 11px;

            font-weight: 800;
        }


        .store-category-tab:hover,
        .store-category-tab.active {
            color:
                var(--store-red);

            background: #fff;

            box-shadow:
                inset 3px 0 0
                var(--store-red);
        }


        .store-mega-right {
            min-width: 0;

            padding: 18px;

            background: #fff;
        }


        .store-category-panel {
            display: none;
        }


        .store-category-panel.active {
            display: block;
        }


        .store-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 13px;

            padding-bottom: 10px;

            border-bottom:
                1px solid
                var(--store-border);
        }


        .store-panel-head strong {
            color:
                var(--store-brown-dark);

            font-size: 13px;
        }


        .store-panel-head a {
            color:
                var(--store-red);

            font-size: 10px;

            font-weight: 900;
        }


        .store-mega-products {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(0, 1fr)
                );

            gap: 13px;
        }


        .store-mega-product {
            min-width: 0;

            color:
                var(--store-text);
        }


        .store-mega-product:hover {
            color:
                var(--store-red);
        }


        .store-mega-product-image {
            width: 100%;

            aspect-ratio: 1 / 1;

            display: grid;
            place-items: center;

            overflow: hidden;

            border:
                1px solid #eee5db;

            border-radius: 10px;

            background:
                #faf8f5;
        }


        .store-mega-product-image img {
            width: 100%;
            height: 100%;

            object-fit: contain;

            padding: 5px;

            transition:
                transform .18s ease;
        }


        .store-mega-product:hover
        .store-mega-product-image img {
            transform:
                scale(1.05);
        }


        .store-mega-product-name {
            min-height: 31px;

            margin-top: 6px;

            font-size: 10px;

            line-height: 1.4;

            font-weight: 800;

            display: -webkit-box;

            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;

            overflow: hidden;
        }


        .store-mega-product-price {
            margin-top: 3px;

            color:
                var(--store-red);

            font-size: 10px;

            font-weight: 950;
        }


        .store-mega-empty {
            padding:
                45px 15px;

            color:
                var(--store-muted);

            text-align: center;

            font-size: 11px;
        }


        /* =========================================================
           NOTIFICATION
        ========================================================= */

        .store-notification-menu {
            width: 375px;

            max-width:
                calc(
                    100vw - 20px
                );

            padding: 0;

            overflow: hidden;

            border:
                1px solid
                var(--store-border);

            border-radius: 14px;

            box-shadow:
                var(--store-shadow-lg);
        }


        .store-notification-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            padding:
                13px 14px;

            border-bottom:
                1px solid
                var(--store-border);

            background:
                #fff9ef;
        }


        .store-notification-head strong {
            font-size: 12px;
        }


        .store-notification-list {
            max-height: 340px;

            overflow-y: auto;
        }


        .store-notification-item {
            display: block;

            padding:
                12px 14px;

            border-bottom:
                1px solid #eee7df;

            color:
                var(--store-text);
        }


        .store-notification-item:hover {
            color:
                var(--store-text);

            background:
                #fff9ef;
        }


        .store-notification-item.unread {
            border-left:
                3px solid
                var(--store-gold);

            background:
                #fffaf0;
        }


        .store-notification-title {
            color:
                var(--store-text);

            font-size: 11px;

            font-weight: 900;
        }


        .store-notification-message {
            margin-top: 3px;

            color:
                var(--store-muted);

            font-size: 10px;

            line-height: 1.5;
        }


        .store-notification-time {
            margin-top: 4px;

            color: #9c9189;

            font-size: 9px;
        }


        .store-notification-empty {
            padding: 30px 15px;

            color:
                var(--store-muted);

            text-align: center;

            font-size: 11px;
        }


        .store-notification-footer {
            padding: 9px;

            border-top:
                1px solid
                var(--store-border);

            background: #fff;
        }


        /* =========================================================
           MOBILE SEARCH
        ========================================================= */

        .store-mobile-search {
            display: none;

            padding:
                0 14px 11px;

            background: #fff;
        }


        /* =========================================================
           MOBILE MENU
        ========================================================= */

        .store-mobile-toggle {
            display: none;

            width: 42px;
            height: 42px;

            border:
                1px solid
                var(--store-border);

            border-radius: 10px;

            color:
                var(--store-brown-dark);

            background: #fff;

            font-size: 20px;
        }


        .store-mobile-menu {
            display: none;

            padding:
                9px 14px 14px;

            border-top:
                1px solid
                var(--store-border);

            background:
                #fff;
        }


        .store-mobile-menu.show {
            display: block;
        }


        .store-mobile-menu-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 7px;
        }


        .store-mobile-link {
            min-height: 42px;

            display: flex;
            align-items: center;

            gap: 7px;

            padding:
                7px 10px;

            border:
                1px solid
                #ece4da;

            border-radius: 10px;

            color:
                #53463d;

            background:
                #fff;

            font-size: 10px;

            font-weight: 850;
        }


        .store-mobile-link:hover,
        .store-mobile-link.active {
            color:
                var(--store-red);

            background:
                #fff8ec;
        }


        /* =========================================================
           PAGE BODY
        ========================================================= */

        .store-page-shell {
            width:
                min(
                    1480px,
                    calc(100% - 38px)
                );

            margin: 0 auto;

            padding:
                24px 0 44px;
        }


        .store-alert {
            border: 0;

            border-radius: 12px;

            box-shadow:
                var(--store-shadow);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1199.98px) {

            .store-main-header {
                grid-template-columns:
                    190px
                    minmax(
                        270px,
                        1fr
                    )
                    auto;

                gap: 15px;
            }


            .store-brand-name {
                font-size: 16px;
            }


            .store-brand-tagline {
                display: none;
            }


            .store-action {
                min-width: 49px;

                padding-left: 5px;
                padding-right: 5px;
            }


            .store-action-label {
                font-size: 8px;
            }


            .store-nav-link {
                padding-left: 9px;
                padding-right: 9px;
            }

        }


        @media (max-width: 991.98px) {

            .store-topbar {
                display: none;
            }


            .store-main-header {
                min-height: 67px;

                grid-template-columns:
                    1fr auto auto;

                gap: 8px;
            }


            .store-main-header
            > .store-search {
                display: none;
            }


            .store-brand-mark {
                width: 40px;
                height: 40px;

                flex-basis: 40px;

                border-radius: 11px;

                font-size: 19px;
            }


            .store-brand-name {
                font-size: 15px;
            }


            .store-quick-actions {
                gap: 2px;
            }


            .store-quick-actions
            .store-action:not(
                .store-cart-action
            ):not(
                .store-theme-toggle
            ) {
                display: none;
            }


            .store-action {
                min-width: 41px;
                min-height: 41px;

                padding: 4px;
            }


            .store-action-label {
                display: none;
            }


            .store-mobile-toggle {
                display: block;
            }


            .store-nav {
                display: none;
            }


            .store-mobile-search {
                display: block;
            }


            .store-page-shell {
                padding-top: 17px;
            }

        }


        @media (max-width: 575.98px) {

            .store-main-header,
            .store-page-shell {
                width:
                    min(
                        100% - 22px,
                        1480px
                    );
            }


            .store-brand-copy {
                max-width: 125px;
            }


            .store-brand-name {
                overflow: hidden;

                font-size: 14px;

                white-space: nowrap;

                text-overflow: ellipsis;
            }


            .store-mobile-menu-grid {
                grid-template-columns: 1fr;
            }


            .store-page-shell {
                padding-bottom: 25px;
            }

        }
    
        /* Logo Tinh Hoa Tây Bắc: núi, mặt trời và nhánh lúa */
        .tb-brand-mark {
            display: block;
            width: 34px;
            height: 34px;
            overflow: visible;
        }

        .tb-brand-sun { fill: #b43e2e; }
        .tb-brand-mountain-back { fill: #6d8a5d; }
        .tb-brand-mountain-front { fill: #315441; }
        .tb-brand-rice { color: #b43e2e; }

        .store-brand-mark {
            border-color: #d1a64d;
            background: linear-gradient(145deg, #fff6d5, #e9bd61);
            box-shadow: 0 8px 18px rgba(98, 56, 32, .18);
        }

        .store-brand-mark .tb-brand-mark {
            width: 35px;
            height: 35px;
        }

        .tb-footer-logo-icon {
            display: grid;
            place-items: center;
        }

        .tb-footer-logo-icon .tb-brand-mark {
            width: 36px;
            height: 36px;
        }

        .tb-brand-mark--footer .tb-brand-sun { fill: #ffd273; }
        .tb-brand-mark--footer .tb-brand-mountain-back { fill: #8ba875; }
        .tb-brand-mark--footer .tb-brand-mountain-front { fill: #e1a944; }
        .tb-brand-mark--footer .tb-brand-rice { color: #fff2c1; }

        .brand-leaf .tb-brand-mark {
            width: 30px;
            height: 30px;
        }
    
        /* Chế độ nền tối */
        html[data-theme="dark"] { color-scheme: dark; }
        html[data-theme="dark"] body,
        html[data-theme="dark"] .store-page-shell {
            color: #eee3d7 !important;
            background: #17120f !important;
        }
        html[data-theme="dark"] .store-header {
            background: rgba(30, 23, 18, .97) !important;
            border-color: #4d3d30 !important;
        }
        html[data-theme="dark"] .store-main-header,
        html[data-theme="dark"] .store-nav {
            background: #211811 !important;
            border-color: #4d3d30 !important;
        }
        html[data-theme="dark"] .store-brand,
        html[data-theme="dark"] .store-brand-name { color: #f7e8d5 !important; }
        html[data-theme="dark"] .store-brand-tagline { color: #cbb9a6 !important; }
        html[data-theme="dark"] .store-nav-link,
        html[data-theme="dark"] .store-action { color: #eadbca !important; }
        html[data-theme="dark"] .store-action:hover,
        html[data-theme="dark"] .store-action.active {
            color: #ffd273 !important;
            border-color: #6b5038 !important;
            background: #38281d !important;
        }
        html[data-theme="dark"] .store-search-input,
        html[data-theme="dark"] input.form-control,
        html[data-theme="dark"] textarea.form-control,
        html[data-theme="dark"] select.form-select {
            color: #f4e8db !important;
            background-color: #30231b !important;
            border-color: #66503e !important;
        }
        html[data-theme="dark"] .store-search-input::placeholder { color: #bba998 !important; }
        html[data-theme="dark"] .store-search-button { background: #3a2a20 !important; color: #ffd273 !important; }
        html[data-theme="dark"] .dropdown-menu,
        html[data-theme="dark"] .store-mega,
        html[data-theme="dark"] .store-mobile-menu,
        html[data-theme="dark"] .product-search-suggestions {
            color: #f0e1d2 !important;
            background: #2a1e17 !important;
            border-color: #5c4635 !important;
        }
        html[data-theme="dark"] main .card,
        html[data-theme="dark"] main [class*="-card"],
        html[data-theme="dark"] main .bg-white {
            color: #f0e2d5 !important;
            background-color: #251b15 !important;
            border-color: #544131 !important;
        }
        html[data-theme="dark"] .text-muted { color: #c1afa0 !important; }
        html[data-theme="dark"] .store-theme-toggle { min-width: 72px; }
        @media (max-width: 991.98px) {
            html[data-theme="dark"] .store-theme-toggle .store-action-label { display: none; }
            html[data-theme="dark"] .store-theme-toggle { min-width: 42px; }
        }
    </style>

</head>


<body>


@unless(View::hasSection('hide-store-header'))
<header class="store-header">


    {{-- =====================================================
        TOP BAR
    ====================================================== --}}
    <div class="store-topbar">

        <div class="store-topbar-inner">

            <div class="store-topbar-right">

                <a
                    href="tel:0385742505"
                    class="store-topbar-item"
                >
                    ☎ 0385 742 505
                </a>

                @auth

                    @if(!$layoutIsAdmin)

                        <a
                            href="{{ route('orders.index') }}"
                            class="store-topbar-item"
                        >
                            📦 Theo dõi đơn hàng
                        </a>

                    @endif

                @endauth

            </div>

        </div>

    </div>


    {{-- =====================================================
        MAIN HEADER
    ====================================================== --}}
    <div class="store-main-header">


        {{-- BRAND --}}
        <a
            href="{{ url('/') }}"
            class="store-brand"
        >

            <span class="store-brand-mark" aria-hidden="true">
                @include('layouts.partials.brand-mark', ['variant' => 'header'])
            </span>


            <span class="store-brand-copy">

                <span class="store-brand-name">
                    Tinh Hoa Tây Bắc
                </span>

                <span class="store-brand-tagline">
                    Hương vị núi rừng · Giao tận nhà
                </span>

            </span>

        </a>


        {{-- SEARCH DESKTOP --}}
        <div class="store-search">

            <form
                action="{{ route('products.index') }}"
                method="GET"
                class="
                    store-search-form
                    js-product-search-form
                "
                role="search"
                autocomplete="off"
                data-suggestions-url="{{
                    route(
                        'products.searchSuggestions'
                    )
                }}"
            >

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="
                        store-search-input
                        js-product-search-input
                    "
                    placeholder="Tìm thịt gác bếp, mắc khén, mật ong, trà..."
                    aria-label="Tìm kiếm sản phẩm"
                >


                <button
                    type="submit"
                    class="store-search-button"
                    title="Tìm kiếm"
                    aria-label="Tìm kiếm"
                >
                    🔍
                </button>


                <div
                    class="
                        product-search-suggestions
                        js-product-search-suggestions
                    "
                    aria-live="polite"
                >
                </div>

            </form>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="store-quick-actions">


            {{-- THEME TOGGLE --}}
            <button
                type="button"
                class="store-action store-theme-toggle"
                id="storeThemeToggle"
                aria-pressed="false"
                title="Chuyển nền sáng tối"
            >
                <span class="store-action-icon" id="storeThemeIcon" aria-hidden="true">☾</span>
                <span class="store-action-label" id="storeThemeLabel">Nền tối</span>
            </button>
            {{-- NOTIFICATION --}}
            @auth

                <div class="dropdown">

                    <a
                        href="#"
                        class="
                            store-action
                            dropdown-toggle
                        "
                        id="storeNotificationDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="Thông báo"
                    >

                        <span class="store-action-icon">
                            🔔
                        </span>

                        <span class="store-action-label">
                            Thông báo
                        </span>


                        @if($layoutUnreadCount > 0)

                            <span class="store-action-badge">

                                {{
                                    $layoutUnreadCount > 99
                                    ? '99+'
                                    : $layoutUnreadCount
                                }}

                            </span>

                        @endif

                    </a>


                    <div
                        class="
                            dropdown-menu
                            dropdown-menu-end
                            store-notification-menu
                        "
                        aria-labelledby="storeNotificationDropdown"
                    >

                        <div class="store-notification-head">

                            <div>

                                <strong>
                                    🔔 Thông báo
                                </strong>

                                <div class="small text-muted mt-1">

                                    {{ $layoutUnreadCount }}
                                    chưa đọc

                                </div>

                            </div>


                            @if($layoutUnreadCount > 0)

                                <span
                                    class="
                                        badge
                                        bg-danger
                                        rounded-pill
                                    "
                                >
                                    {{ $layoutUnreadCount }}
                                </span>

                            @endif

                        </div>


                        <div class="store-notification-list">


                            @forelse($layoutNotifications as $notification)

                                @php
                                    $noticeData =
                                        $notification->data
                                        ??
                                        [];


                                    $noticeTitle =
                                        $noticeData['title']
                                        ??
                                        'Thông báo';


                                    $noticeMessage =
                                        $noticeData['message']
                                        ??
                                        (
                                            $layoutIsAdmin
                                            ? 'Bạn có một thông báo mới.'
                                            : 'Đơn hàng của bạn vừa được cập nhật.'
                                        );


                                    $noticeType =
                                        $noticeData['type']
                                        ??
                                        '';


                                    $noticeLevel =
                                        $noticeData['alert_level']
                                        ??
                                        '';


                                    $noticeIcon =
                                        match (true) {
                                            $noticeType === 'new_order'
                                                => '📦',

                                            $noticeType === 'low_stock'
                                            &&
                                            $noticeLevel === 'out_of_stock'
                                                => '❌',

                                            $noticeType === 'low_stock'
                                                => '⚠️',

                                            default
                                                => $layoutIsAdmin
                                                    ? '🔔'
                                                    : '📦',
                                        };


                                    $noticeRoute =
                                        $layoutIsAdmin

                                        ? route(
                                            'admin.notifications.read',
                                            $notification->id
                                        )

                                        : route(
                                            'notifications.read',
                                            $notification->id
                                        );
                                @endphp


                                <a
                                    href="{{ $noticeRoute }}"
                                    class="
                                        store-notification-item
                                        {{
                                            is_null(
                                                $notification->read_at
                                            )
                                            ? 'unread'
                                            : ''
                                        }}
                                    "
                                >

                                    <div class="store-notification-title">

                                        {{ $noticeIcon }}
                                        {{ $noticeTitle }}

                                    </div>


                                    <div class="store-notification-message">

                                        {{ $noticeMessage }}

                                    </div>


                                    <div class="store-notification-time">

                                        {{
                                            optional(
                                                $notification
                                                    ->created_at
                                            )
                                            ->diffForHumans()
                                        }}

                                        @if(
                                            is_null(
                                                $notification->read_at
                                            )
                                        )

                                            · chưa đọc

                                        @endif

                                    </div>

                                </a>


                            @empty

                                <div class="store-notification-empty">

                                    <div style="font-size:30px;">
                                        🔕
                                    </div>

                                    <div class="mt-2">
                                        Chưa có thông báo.
                                    </div>

                                </div>

                            @endforelse

                        </div>


                        <div class="store-notification-footer">


                            @if($layoutUnreadCount > 0)

                                <form
                                    method="POST"
                                    action="{{
                                        $layoutIsAdmin

                                        ? route(
                                            'admin.notifications.readAll'
                                        )

                                        : route(
                                            'notifications.readAll'
                                        )
                                    }}"
                                    class="mb-2"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="
                                            btn
                                            btn-sm
                                            btn-success
                                            w-100
                                        "
                                    >
                                        ✓ Đánh dấu tất cả đã đọc
                                    </button>

                                </form>

                            @endif


                            <a
                                href="{{
                                    $layoutIsAdmin

                                    ? route(
                                        'admin.orders.index'
                                    )

                                    : route(
                                        'orders.index'
                                    )
                                }}"
                                class="
                                    btn
                                    btn-sm
                                    btn-outline-secondary
                                    w-100
                                "
                            >
                                📦 Xem đơn hàng
                            </a>

                        </div>

                    </div>

                </div>

            @endauth


            {{-- ACCOUNT AUTH --}}
            @auth

                <div
                    class="
                        dropdown
                        store-account
                    "
                >

                    <a
                        href="#"
                        class="
                            store-action
                            dropdown-toggle
                        "
                        id="storeAccountDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="Tài khoản"
                    >

                        <span class="store-action-icon">

                            {{
                                $layoutIsAdmin
                                ? '👑'
                                : '👤'
                            }}

                        </span>

                        <span class="store-action-label">

                            {{
                                $layoutLastName
                                ??
                                'Tài khoản'
                            }}

                        </span>

                    </a>


                    <ul
                        class="
                            dropdown-menu
                            dropdown-menu-end
                            store-dropdown-menu
                        "
                        aria-labelledby="storeAccountDropdown"
                    >


                        @if($layoutIsAdmin)

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.dashboard') }}"
                                >
                                    📊 Dashboard
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.products.index') }}"
                                >
                                    🥩 Quản lý sản phẩm
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.categories.index') }}"
                                >
                                    🧺 Quản lý danh mục
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.customers.index') }}"
                                >
                                    👥 Quản lý khách hàng
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.orders.index') }}"
                                >
                                    📦 Quản lý đơn hàng
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.vouchers.index') }}"
                                >
                                    🎟️ Quản lý voucher
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


                        @else

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('dashboard') }}"
                                >
                                    📊 Tổng quan
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('orders.index') }}"
                                >
                                    📦 Đơn hàng của tôi
                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('profile') }}"
                                >
                                    👤 Hồ sơ cá nhân
                                </a>

                            </li>


                            


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('cart.index') }}"
                                >
                                    🛒 Giỏ hàng
                                </a>

                            </li>


                        @endif


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
                                    class="
                                        dropdown-item
                                        text-danger
                                    "
                                >
                                    🚪 Đăng xuất
                                </button>

                            </form>

                        </li>

                    </ul>

                </div>


            {{-- ACCOUNT GUEST --}}
            @else

                <a
                    href="{{ route('login') }}"
                    class="store-action"
                    title="Đăng nhập"
                >

                    <span class="store-action-icon">
                        👤
                    </span>

                    <span class="store-action-label">
                        Đăng nhập
                    </span>

                </a>

            @endauth


            {{-- MOBILE --}}
            <button
                type="button"
                class="store-mobile-toggle"
                id="storeMobileToggle"
                aria-label="Mở menu"
                aria-expanded="false"
            >
                ☰
            </button>

        </div>

    </div>


    {{-- =====================================================
        MOBILE SEARCH
    ====================================================== --}}
    <div class="store-mobile-search">

        <form
            action="{{ route('products.index') }}"
            method="GET"
            class="
                store-search-form
                js-product-search-form
            "
            role="search"
            autocomplete="off"
            data-suggestions-url="{{
                route(
                    'products.searchSuggestions'
                )
            }}"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="
                    store-search-input
                    js-product-search-input
                "
                placeholder="Tìm kiếm đặc sản..."
            >


            <button
                type="submit"
                class="store-search-button"
            >
                🔍
            </button>


            <div
                class="
                    product-search-suggestions
                    js-product-search-suggestions
                "
            >
            </div>

        </form>

    </div>


    {{-- =====================================================
        DESKTOP NAV
    ====================================================== --}}
    <nav class="store-nav">

        <div class="store-nav-inner">


            {{-- CATEGORY --}}
            <div
                class="store-category"
                id="storeCategoryMega"
            >

                <a
                    href="{{ route('products.index') }}"
                    class="store-category-trigger"
                    id="storeCategoryTrigger"
                    aria-expanded="false"
                >

                    <span>
                        ☰
                    </span>

                    <span>
                        Danh mục sản phẩm
                    </span>

                    <span class="store-category-trigger-arrow">
                        ▾
                    </span>

                </a>


                <div class="store-mega">


                    <div class="store-mega-left">

                        <div class="store-mega-title">
                            Danh mục Tây Bắc
                        </div>


                        @forelse($layoutCategories as $category)

                            <button
                                type="button"
                                class="
                                    store-category-tab
                                    {{
                                        $loop->first
                                        ? 'active'
                                        : ''
                                    }}
                                "
                                data-store-panel="store-category-{{
                                    $category->id
                                }}"
                            >

                                <span>
                                    {{ $category->name }}
                                </span>

                                <span>
                                    ›
                                </span>

                            </button>


                        @empty

                            <div class="p-3 small text-muted">
                                Chưa có danh mục.
                            </div>

                        @endforelse

                    </div>


                    <div class="store-mega-right">


                        @forelse($layoutCategories as $category)

                            <div
                                id="store-category-{{
                                    $category->id
                                }}"
                                class="
                                    store-category-panel
                                    {{
                                        $loop->first
                                        ? 'active'
                                        : ''
                                    }}
                                "
                            >

                                <div class="store-panel-head">

                                    <strong>
                                        🌿 {{ $category->name }}
                                    </strong>


                                    <a
                                        href="{{
                                            route(
                                                'products.index',
                                                [
                                                    'category_id'
                                                    =>
                                                    $category->id
                                                ]
                                            )
                                        }}"
                                    >
                                        Xem tất cả →
                                    </a>

                                </div>


                                @if(
                                    $category
                                        ->products
                                        ->isNotEmpty()
                                )

                                    <div class="store-mega-products">


                                        @foreach($category->products->take(8) as $product)

                                            <a
                                                href="{{
                                                    route(
                                                        'products.show',
                                                        $product
                                                    )
                                                }}"
                                                class="store-mega-product"
                                            >

                                                <div class="store-mega-product-image">


                                                    @if($product->image)

                                                        <img
                                                            src="{{
                                                                str_starts_with(
                                                                    $product->image,
                                                                    'http'
                                                                )

                                                                ? $product->image

                                                                : asset(
                                                                    'storage/'
                                                                    .
                                                                    ltrim(
                                                                        $product->image,
                                                                        '/'
                                                                    )
                                                                )
                                                            }}"
                                                            alt="{{ $product->name }}"
                                                            loading="lazy"
                                                        >

                                                    @else

                                                        <span style="font-size:30px;">
                                                                            🧺
                                                        </span>

                                                    @endif

                                                </div>


                                                <div class="store-mega-product-name">

                                                    {{ $product->name }}

                                                </div>


                                                <div class="store-mega-product-price">

                                                    {{
                                                        number_format(
                                                            $product
                                                                ->getCurrentPrice(),
                                                            0,
                                                            ',',
                                                            '.'
                                                        )
                                                    }}đ

                                                </div>

                                            </a>

                                        @endforeach

                                    </div>


                                @else

                                    <div class="store-mega-empty">

                                        📦 Danh mục này
                                        chưa có sản phẩm.

                                    </div>

                                @endif

                            </div>


                        @empty

                            <div class="store-mega-empty">
                                📂 Chưa có dữ liệu danh mục.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- ADMIN NAV --}}
            @if($layoutIsAdmin)

                <a
                    href="{{ url('/') }}"
                    class="
                        store-nav-link
                        {{
                            request()->is('/')
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    🏠 Trang chủ
                </a>


                <a
                    href="{{ route('admin.products.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'admin.products.*'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    🥩 Sản phẩm
                </a>


                <a
                    href="{{ route('admin.categories.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'admin.categories.*'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    🧺 Danh mục
                </a>


                <a
                    href="{{ route('admin.customers.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'admin.customers.*'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    👥 Khách hàng
                </a>


                <a
                    href="{{ route('admin.orders.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'admin.orders.*'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    📦 Đơn hàng

                    @if($layoutPendingOrders > 0)

                        <span
                            class="
                                badge
                                bg-danger
                                ms-1
                            "
                        >
                            {{
                                $layoutPendingOrders
                            }}
                        </span>

                    @endif

                </a>


                <a
                    href="{{ route('admin.vouchers.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'admin.vouchers.*'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    🎟 Voucher
                </a>


            {{-- CUSTOMER / GUEST NAV --}}
            @else

                <a
                    href="{{ url('/') }}"
                    class="
                        store-nav-link
                        {{
                            request()->is('/')
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    Trang chủ
                </a>


                <a
                    href="{{ route('products.index') }}"
                    class="
                        store-nav-link
                        {{
                            request()
                                ->routeIs(
                                    'products.index'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    Sản phẩm
                </a>


                <a
                    href="{{ route('products.promotions') }}"
                    class="
                        store-nav-link
                        store-nav-sale
                        {{
                            request()
                                ->routeIs(
                                    'products.promotions'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    🔥 Khuyến mãi
                </a>





                <span class="store-nav-spacer">
                </span>


                <span
                    style="
                        color:#887a70;
                        font-size:10px;
                        font-weight:700;
                    "
                >
                    🌿 Đặc sản Tây Bắc ·
                    Hương vị núi rừng
                </span>

            @endif

        </div>

    </nav>


    {{-- =====================================================
        MOBILE MENU
    ====================================================== --}}
    <div
        class="store-mobile-menu"
        id="storeMobileMenu"
    >

        <div class="store-mobile-menu-grid">


            @if($layoutIsAdmin)

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="store-mobile-link"
                >
                    📊 Dashboard
                </a>


                <a
                    href="{{ route('admin.products.index') }}"
                    class="store-mobile-link"
                >
                    🥩 Sản phẩm
                </a>


                <a
                    href="{{ route('admin.categories.index') }}"
                    class="store-mobile-link"
                >
                    🧺 Danh mục
                </a>


                <a
                    href="{{ route('admin.customers.index') }}"
                    class="store-mobile-link"
                >
                    👥 Khách hàng
                </a>


                <a
                    href="{{ route('admin.orders.index') }}"
                    class="store-mobile-link"
                >
                    📦 Đơn hàng
                </a>


                <a
                    href="{{ route('admin.vouchers.index') }}"
                    class="store-mobile-link"
                >
                    🎟 Voucher
                </a>


                <a
                    href="{{ route('admin.profile') }}"
                    class="store-mobile-link"
                >
                    👤 Hồ sơ Admin
                </a>


            @elseif($layoutUser)

                <a
                    href="{{ url('/') }}"
                    class="store-mobile-link"
                >
                    🏠 Trang chủ
                </a>


                <a
                    href="{{ route('products.index') }}"
                    class="store-mobile-link"
                >
                    🛍 Sản phẩm
                </a>


                <a
                    href="{{ route('products.promotions') }}"
                    class="store-mobile-link"
                >
                    🔥 Khuyến mãi
                </a>


                <a
                    href="{{ route('dashboard') }}"
                    class="
                        store-mobile-link
                        {{
                            request()
                                ->routeIs(
                                    'dashboard'
                                )
                            ? 'active'
                            : ''
                        }}
                    "
                >
                    📊 Tổng quan
                </a>


                <a
                    href="{{ route('cart.index') }}"
                    class="store-mobile-link"
                >
                    🛒 Giỏ hàng
                </a>


                <a
                    href="{{ route('orders.index') }}"
                    class="store-mobile-link"
                >
                    📦 Đơn hàng
                </a>


                <a
                    href="{{ route('profile') }}"
                    class="store-mobile-link"
                >
                    👤 Hồ sơ
                </a>


                


            @else

                <a
                    href="{{ url('/') }}"
                    class="store-mobile-link"
                >
                    🏠 Trang chủ
                </a>


                <a
                    href="{{ route('products.index') }}"
                    class="store-mobile-link"
                >
                    🛍 Sản phẩm
                </a>


                <a
                    href="{{ route('products.promotions') }}"
                    class="store-mobile-link"
                >
                    🔥 Khuyến mãi
                </a>


                <a
                    href="{{ route('login') }}"
                    class="store-mobile-link"
                >
                    🔐 Đăng nhập
                </a>


                <a
                    href="{{ route('register') }}"
                    class="store-mobile-link"
                >
                    ✍ Đăng ký
                </a>

            @endif

        </div>


        @auth

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="mt-2"
            >

                @csrf


                <button
                    type="submit"
                    class="
                        store-mobile-link
                        w-100
                        border-danger
                        text-danger
                    "
                >
                    🚪 Đăng xuất
                </button>

            </form>

        @endauth

    </div>

</header>
@endunless


{{-- =========================================================
    PAGE CONTENT
========================================================= --}}
<main class="store-page-shell">


    {{-- SUCCESS --}}
    @if(session('success'))

        <div
            class="
                alert
                alert-success
                alert-dismissible
                fade
                show
                store-alert
                auto-dismiss-alert
            "
            role="alert"
        >

            ✅ {{ session('success') }}


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Đóng"
            >
            </button>

        </div>

    @endif


    {{-- ERROR --}}
    @if(session('error'))

        <div
            class="
                alert
                alert-danger
                alert-dismissible
                fade
                show
                store-alert
            "
            role="alert"
        >

            ❌ {{ session('error') }}


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Đóng"
            >
            </button>

        </div>

    @endif


    {{-- VALIDATION --}}
    @if($errors->any())

        <div
            class="
                alert
                alert-danger
                store-alert
            "
        >

            <strong>
                ❌ Có lỗi xảy ra:
            </strong>


            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    @yield('content')

</main>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
>
</script>


<script
    src="{{ asset('js/shop.js') }}"
>
</script>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | AUTO DISMISS SUCCESS
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.auto-dismiss-alert'
            )
            .forEach(
                function (alertElement) {

                    window.setTimeout(
                        function () {

                            if (
                                !document.body
                                    .contains(
                                        alertElement
                                    )
                            ) {
                                return;
                            }


                            const instance =
                                bootstrap.Alert
                                    .getOrCreateInstance(
                                        alertElement
                                    );


                            instance.close();

                        },
                        3000
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | MOBILE MENU
        |--------------------------------------------------------------------------
        */

        const mobileToggle =
            document.getElementById(
                'storeMobileToggle'
            );


        const mobileMenu =
            document.getElementById(
                'storeMobileMenu'
            );


        if (
            mobileToggle
            &&
            mobileMenu
        ) {

            mobileToggle.addEventListener(
                'click',
                function () {

                    const open =
                        mobileMenu
                            .classList
                            .toggle(
                                'show'
                            );


                    mobileToggle
                        .setAttribute(
                            'aria-expanded',
                            open
                                ? 'true'
                                : 'false'
                        );


                    mobileToggle.textContent =
                        open
                        ? '×'
                        : '☰';

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY MEGA MENU
        |--------------------------------------------------------------------------
        */

        const categoryMega =
            document.getElementById(
                'storeCategoryMega'
            );


        const categoryTrigger =
            document.getElementById(
                'storeCategoryTrigger'
            );


        if (
            categoryMega
            &&
            categoryTrigger
        ) {

            const tabs =
                Array.from(
                    categoryMega
                        .querySelectorAll(
                            '[data-store-panel]'
                        )
                );


            const panels =
                Array.from(
                    categoryMega
                        .querySelectorAll(
                            '.store-category-panel'
                        )
                );


            function showPanel(tab) {

                const targetId =
                    tab.dataset
                        .storePanel;


                tabs.forEach(
                    function (item) {

                        item
                            .classList
                            .remove(
                                'active'
                            );

                    }
                );


                panels.forEach(
                    function (panel) {

                        panel
                            .classList
                            .remove(
                                'active'
                            );

                    }
                );


                tab
                    .classList
                    .add(
                        'active'
                    );


                const target =
                    document
                        .getElementById(
                            targetId
                        );


                if (target) {

                    target
                        .classList
                        .add(
                            'active'
                        );

                }

            }


            tabs.forEach(
                function (tab) {

                    tab.addEventListener(
                        'mouseenter',
                        function () {
                            showPanel(tab);
                        }
                    );


                    tab.addEventListener(
                        'click',
                        function () {
                            showPanel(tab);
                        }
                    );

                }
            );


            categoryTrigger
                .addEventListener(
                    'click',
                    function (event) {

                        if (
                            window.innerWidth
                            <
                            992
                        ) {
                            return;
                        }


                        event.preventDefault();


                        const opened =
                            categoryMega
                                .classList
                                .toggle(
                                    'mega-open'
                                );


                        categoryTrigger
                            .setAttribute(
                                'aria-expanded',
                                opened
                                    ? 'true'
                                    : 'false'
                            );

                    }
                );


            document.addEventListener(
                'click',
                function (event) {

                    if (
                        !categoryMega
                            .contains(
                                event.target
                            )
                    ) {

                        categoryMega
                            .classList
                            .remove(
                                'mega-open'
                            );


                        categoryTrigger
                            .setAttribute(
                                'aria-expanded',
                                'false'
                            );

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH AUTOCOMPLETE
        |--------------------------------------------------------------------------
        */

        const searchForms =
            document.querySelectorAll(
                '.js-product-search-form'
            );


        const escapeHtml =
            function (value) {

                return String(
                    value
                    ??
                    ''
                )

                .replaceAll(
                    '&',
                    '&amp;'
                )

                .replaceAll(
                    '<',
                    '&lt;'
                )

                .replaceAll(
                    '>',
                    '&gt;'
                )

                .replaceAll(
                    '"',
                    '&quot;'
                )

                .replaceAll(
                    "'",
                    '&#039;'
                );

            };


        const formatPrice =
            function (value) {

                return new Intl
                    .NumberFormat(
                        'vi-VN'
                    )
                    .format(
                        Number(
                            value
                            ||
                            0
                        )
                    )
                    +
                    'đ';

            };


        searchForms.forEach(
            function (form) {

                const input =
                    form.querySelector(
                        '.js-product-search-input'
                    );


                const suggestions =
                    form.querySelector(
                        '.js-product-search-suggestions'
                    );


                const endpoint =
                    form.dataset
                        .suggestionsUrl;


                if (
                    !input
                    ||
                    !suggestions
                    ||
                    !endpoint
                ) {
                    return;
                }


                let timer = null;

                let controller = null;

                let activeIndex = -1;


                const close =
                    function () {

                        suggestions
                            .classList
                            .remove(
                                'show'
                            );


                        activeIndex = -1;

                    };


                const items =
                    function () {

                        return Array.from(
                            suggestions
                                .querySelectorAll(
                                    '.product-search-suggestion'
                                )
                        );

                    };


                const setActive =
                    function (index) {

                        const currentItems =
                            items();


                        currentItems.forEach(
                            function (item) {

                                item
                                    .classList
                                    .remove(
                                        'active'
                                    );

                            }
                        );


                        if (
                            !currentItems.length
                        ) {

                            activeIndex = -1;

                            return;

                        }


                        activeIndex =
                            index;


                        if (
                            activeIndex < 0
                        ) {

                            activeIndex =
                                currentItems.length
                                -
                                1;

                        }


                        if (
                            activeIndex
                            >=
                            currentItems.length
                        ) {

                            activeIndex = 0;

                        }


                        currentItems[
                            activeIndex
                        ]
                        .classList
                        .add(
                            'active'
                        );


                        currentItems[
                            activeIndex
                        ]
                        .scrollIntoView({
                            block:
                                'nearest'
                        });

                    };


                const renderProducts =
                    function (
                        products,
                        keyword
                    ) {

                        if (
                            !products.length
                        ) {

                            suggestions.innerHTML =
                                '<div class="product-search-message">' +
                                'Không tìm thấy sản phẩm phù hợp.' +
                                '</div>';


                            suggestions
                                .classList
                                .add(
                                    'show'
                                );


                            return;

                        }


                        let html = '';


                        products.forEach(
                            function (product) {

                                const image =
                                    product.image

                                    ? (
                                        '<img ' +
                                        'class="product-search-suggestion-image" ' +
                                        'src="' +
                                        escapeHtml(
                                            product.image
                                        ) +
                                        '" ' +
                                        'alt="' +
                                        escapeHtml(
                                            product.name
                                        ) +
                                        '">'
                                    )

                                    : (
                                        '<div class="' +
                                        'product-search-suggestion-image ' +
                                        'product-search-suggestion-placeholder' +
                                        '">🧺</div>'
                                    );


                                const stock =
                                    product.in_stock
                                    ? 'Còn hàng'
                                    : 'Hết hàng';


                                const oldPrice =
                                    product.on_sale
                                    &&
                                    Number(
                                        product.original_price
                                    )
                                    >
                                    Number(
                                        product.price
                                    )

                                    ? (
                                        '<span ' +
                                        'class="product-search-suggestion-old-price">' +
                                        formatPrice(
                                            product.original_price
                                        ) +
                                        '</span>'
                                    )

                                    : '';


                                html +=
                                    '<a ' +
                                    'class="product-search-suggestion" ' +
                                    'href="' +
                                    escapeHtml(
                                        product.url
                                    ) +
                                    '">' +

                                        image +

                                        '<div class="product-search-suggestion-body">' +

                                            '<div class="product-search-suggestion-name">' +
                                                escapeHtml(
                                                    product.name
                                                ) +
                                            '</div>' +

                                            '<div class="product-search-suggestion-meta">' +
                                                escapeHtml(
                                                    product.category
                                                ) +
                                                ' · ' +
                                                escapeHtml(
                                                    stock
                                                ) +
                                            '</div>' +

                                        '</div>' +

                                        '<div class="product-search-suggestion-price">' +
                                            formatPrice(
                                                product.price
                                            ) +
                                            oldPrice +
                                        '</div>' +

                                    '</a>';

                            }
                        );


                        html +=
                            '<a ' +
                            'class="product-search-view-all" ' +
                            'href="' +
                            escapeHtml(
                                form.action
                                +
                                '?search='
                                +
                                encodeURIComponent(
                                    keyword
                                )
                            ) +
                            '">' +

                            'Xem tất cả kết quả cho “' +
                            escapeHtml(
                                keyword
                            ) +
                            '” →' +

                            '</a>';


                        suggestions.innerHTML =
                            html;


                        suggestions
                            .classList
                            .add(
                                'show'
                            );


                        activeIndex = -1;

                    };


                const loadSuggestions =
                    async function () {

                        const keyword =
                            input
                                .value
                                .trim();


                        if (
                            keyword.length < 2
                        ) {

                            close();


                            suggestions.innerHTML =
                                '';


                            return;

                        }


                        if (controller) {
                            controller.abort();
                        }


                        controller =
                            new AbortController();


                        suggestions.innerHTML =
                            '<div class="product-search-message">' +
                            'Đang tìm sản phẩm...' +
                            '</div>';


                        suggestions
                            .classList
                            .add(
                                'show'
                            );


                        try {

                            const response =
                                await fetch(
                                    endpoint
                                    +
                                    '?q='
                                    +
                                    encodeURIComponent(
                                        keyword
                                    ),
                                    {
                                        headers: {
                                            'Accept':
                                                'application/json'
                                        },

                                        signal:
                                            controller
                                                .signal
                                    }
                                );


                            if (!response.ok) {

                                throw new Error(
                                    'Search error'
                                );

                            }


                            const products =
                                await response.json();


                            if (
                                input
                                    .value
                                    .trim()
                                !==
                                keyword
                            ) {
                                return;
                            }


                            renderProducts(
                                products,
                                keyword
                            );

                        }
                        catch (error) {

                            if (
                                error.name
                                ===
                                'AbortError'
                            ) {
                                return;
                            }


                            suggestions.innerHTML =
                                '<div class="product-search-message">' +
                                'Không thể tải gợi ý. Nhấn Enter để tìm kiếm.' +
                                '</div>';


                            suggestions
                                .classList
                                .add(
                                    'show'
                                );

                        }

                    };


                input.addEventListener(
                    'input',
                    function () {

                        clearTimeout(
                            timer
                        );


                        timer =
                            setTimeout(
                                loadSuggestions,
                                250
                            );

                    }
                );


                input.addEventListener(
                    'focus',
                    function () {

                        if (
                            input
                                .value
                                .trim()
                                .length
                            >=
                            2
                            &&
                            suggestions
                                .innerHTML
                                .trim()
                            !==
                            ''
                        ) {

                            suggestions
                                .classList
                                .add(
                                    'show'
                                );

                        }

                    }
                );


                input.addEventListener(
                    'keydown',
                    function (event) {

                        const currentItems =
                            items();


                        if (
                            event.key
                            ===
                            'ArrowDown'
                            &&
                            currentItems.length
                        ) {

                            event
                                .preventDefault();


                            setActive(
                                activeIndex
                                +
                                1
                            );


                            return;

                        }


                        if (
                            event.key
                            ===
                            'ArrowUp'
                            &&
                            currentItems.length
                        ) {

                            event
                                .preventDefault();


                            setActive(
                                activeIndex
                                -
                                1
                            );


                            return;

                        }


                        if (
                            event.key
                            ===
                            'Enter'
                            &&
                            activeIndex >= 0
                            &&
                            currentItems[
                                activeIndex
                            ]
                        ) {

                            event
                                .preventDefault();


                            window.location.href =
                                currentItems[
                                    activeIndex
                                ]
                                .href;


                            return;

                        }


                        if (
                            event.key
                            ===
                            'Escape'
                        ) {

                            close();

                        }

                    }
                );


                document
                    .addEventListener(
                        'click',
                        function (event) {

                            if (
                                !form.contains(
                                    event.target
                                )
                            ) {

                                close();

                            }

                        }
                    );

            }
        );

    }
);
</script>


<script>
    (function () {
        const button = document.getElementById('storeThemeToggle');
        const icon = document.getElementById('storeThemeIcon');
        const label = document.getElementById('storeThemeLabel');
        if (!button || !icon || !label) return;

        function applyTheme(theme) {
            const dark = theme === 'dark';
            document.documentElement.dataset.theme = dark ? 'dark' : 'light';
            icon.textContent = dark ? '☀' : '☾';
            label.textContent = dark ? 'Nền sáng' : 'Nền tối';
            button.setAttribute('aria-pressed', dark ? 'true' : 'false');
            button.title = dark ? 'Chuyển sang nền sáng' : 'Chuyển sang nền tối';
        }

        let theme = 'light';
        try { theme = window.localStorage.getItem('tinh-hoa-theme') || 'light'; } catch (error) {}
        applyTheme(theme);

        button.addEventListener('click', function () {
            const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            try { window.localStorage.setItem('tinh-hoa-theme', next); } catch (error) {}
        });
    }());
</script>

@stack('scripts')


@include('layouts.partials.footer')


</body>

</html>
