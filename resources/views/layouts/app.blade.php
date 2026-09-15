<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tinh Hoa Tây Bắc')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --tb-brown: #5f341d;
            --tb-brown-dark: #2c1810;
            --tb-green: #48633b;
            --tb-red: #a83b2d;
            --tb-gold: #f2c15c;
            --tb-cream: #fffaf0;
            --tb-soft: #f8efe2;
            --tb-border: #ead8bf;
            --tb-text: #2f241e;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(
                180deg,
                #fffaf0 0%,
                #f8efe2 100%
            );
            color: var(--tb-text);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            min-height: 64px;
            background: linear-gradient(
                90deg,
                #35180d 0%,
                #66391f 55%,
                #48633b 100%
            ) !important;

            box-shadow: 0 5px 18px rgba(44, 24, 16, 0.16);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .navbar-brand {
            color: #fff !important;
            letter-spacing: 0.5px;
            font-weight: 800;
            font-size: 21px;
        }

        .navbar-brand:hover {
            color: var(--tb-gold) !important;
        }

        .nav-link {
            color: rgba(255,255,255,.88) !important;
            font-weight: 600;
            border-radius: 10px;
            padding-left: 12px !important;
            padding-right: 12px !important;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link.active {
            color: var(--tb-gold) !important;
            background: rgba(255,255,255,.10);
        }

        .admin-link {
            color: rgba(255,255,255,.88) !important;
        }

        .admin-link:hover {
            color: #fff !important;
            background: rgba(255,255,255,.08);
        }

        .card {
            border: 1px solid var(--tb-border);
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(95, 52, 29, 0.12);
        }

        .btn-primary {
            background: linear-gradient(
                135deg,
                var(--tb-red),
                var(--tb-brown)
            );
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(
                135deg,
                #8f3025,
                var(--tb-brown-dark)
            );
        }

        .alert {
            border: none;
            border-radius: 0.9rem;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,.12);
        }

        .dropdown-item {
            padding: 9px 16px;
        }

        .dropdown-item:hover {
            background: var(--tb-soft);
            color: var(--tb-brown-dark);
        }

        /* =====================================================
            🔔 ADMIN NOTIFICATION
        ===================================================== */
        .admin-notification-link {
            position: relative;
            display: flex !important;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .admin-notification-badge {
            position: absolute;
            top: -6px;
            right: -7px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #dc3545;
            color: #fff;
            border: 2px solid #5f341d;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }

        .admin-notification-menu {
            width: 380px;
            max-width: calc(100vw - 24px);
            padding: 0;
            overflow: hidden;
        }

        .admin-notification-header {
            padding: 14px 16px;
            background: var(--tb-cream);
            border-bottom: 1px solid var(--tb-border);
        }

        .admin-notification-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .admin-notification-item {
            display: block;
            padding: 13px 16px;
            color: var(--tb-text);
            text-decoration: none;
            border-bottom: 1px solid #f1e5d5;
        }

        .admin-notification-item:hover {
            background: var(--tb-soft);
            color: var(--tb-text);
        }

        .admin-notification-item.unread {
            background: #fff7e7;
            border-left: 4px solid var(--tb-gold);
            padding-left: 12px;
        }

        .admin-notification-title {
            font-weight: 800;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .admin-notification-message {
            color: #6b625c;
            font-size: 13px;
            line-height: 1.45;
        }

        .admin-notification-time {
            color: #9a8d83;
            font-size: 11px;
            margin-top: 5px;
        }

        .admin-notification-empty {
            padding: 28px 18px;
            text-align: center;
            color: #8b7d74;
        }

        @media (max-width: 991px) {
            .admin-notification-menu {
                width: 100%;
                max-width: 100%;
            }
        }




        /* =====================================================
           🔎 SEARCH + COMPACT STICKY HEADER
           Chỉ bổ sung giao diện, không thay đổi mega menu/navbar cũ.
        ===================================================== */
        .customer-main-search {
            flex: 1 1 360px;
            max-width: 760px;
            min-width: 260px;
            margin: 0 14px;
        }

        .customer-search-form {
            position: relative;
            width: 100%;
        }

        .customer-search-input {
            width: 100%;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, .26);
            border-radius: 999px;
            background: rgba(255, 255, 255, .97);
            color: var(--tb-text);
            padding: 0 50px 0 18px;
            outline: none;
            transition: .2s ease;
        }

        .customer-search-input:focus {
            border-color: var(--tb-gold);
            box-shadow: 0 0 0 3px rgba(242, 193, 92, .20);
        }

        .customer-search-button {
            position: absolute;
            top: 50%;
            right: 6px;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: var(--tb-brown-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
        }

        .customer-search-button:hover {
            background: var(--tb-soft);
        }

        /* =====================================================
           🔎 AUTOCOMPLETE TÌM KIẾM SẢN PHẨM
        ===================================================== */
        .product-search-suggestions {
            display: none;
            position: absolute;
            top: calc(100% + 9px);
            left: 0;
            right: 0;
            z-index: 5000;
            overflow: hidden;
            max-height: 430px;
            overflow-y: auto;
            border: 1px solid var(--tb-border);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(44, 24, 16, .22);
        }

        .product-search-suggestions.show {
            display: block;
        }

        .product-search-suggestion {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            color: var(--tb-text);
            text-decoration: none;
            border-bottom: 1px solid #f1e5d5;
            transition: background .16s ease;
        }

        .product-search-suggestion:last-child {
            border-bottom: 0;
        }

        .product-search-suggestion:hover,
        .product-search-suggestion.active {
            color: var(--tb-text);
            background: var(--tb-soft);
        }

        .product-search-suggestion-image {
            width: 54px;
            height: 54px;
            flex: 0 0 54px;
            border-radius: 11px;
            object-fit: cover;
            border: 1px solid var(--tb-border);
            background: var(--tb-soft);
        }

        .product-search-suggestion-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .product-search-suggestion-body {
            min-width: 0;
            flex: 1;
        }

        .product-search-suggestion-name {
            overflow: hidden;
            color: var(--tb-brown-dark);
            font-size: 14px;
            font-weight: 800;
            line-height: 1.35;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .product-search-suggestion-meta {
            margin-top: 3px;
            color: #8b7568;
            font-size: 12px;
        }

        .product-search-suggestion-price {
            flex: 0 0 auto;
            color: var(--tb-red);
            font-size: 14px;
            font-weight: 900;
            white-space: nowrap;
            text-align: right;
        }

        .product-search-suggestion-old-price {
            display: block;
            margin-top: 2px;
            color: #9c9189;
            font-size: 11px;
            font-weight: 500;
            text-decoration: line-through;
        }

        .product-search-message {
            padding: 18px;
            color: #806f63;
            text-align: center;
            font-size: 13px;
        }

        .product-search-view-all {
            display: block;
            padding: 11px 14px;
            color: var(--tb-red);
            background: var(--tb-cream);
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 900;
            border-top: 1px solid var(--tb-border);
        }

        .product-search-view-all:hover {
            color: var(--tb-brown-dark);
            background: var(--tb-soft);
        }

        /* Thanh nhỏ chỉ xuất hiện khi khách cuộn xuống */
        .customer-compact-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 3000;
            height: 68px;
            background: rgba(255, 255, 255, .97);
            border-bottom: 1px solid var(--tb-border);
            box-shadow: 0 5px 22px rgba(44, 24, 16, .16);
            transform: translateY(-110%);
            opacity: 0;
            visibility: hidden;
            transition: transform .25s ease, opacity .25s ease, visibility .25s ease;
            backdrop-filter: blur(10px);
        }

        .customer-compact-header.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .customer-compact-inner {
            max-width: 1450px;
            height: 100%;
            margin: 0 auto;
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .customer-compact-brand {
            color: var(--tb-brown-dark);
            font-weight: 900;
            font-size: 20px;
            text-decoration: none;
            white-space: nowrap;
        }

        .customer-compact-brand:hover {
            color: var(--tb-red);
        }

        .customer-compact-search {
            flex: 1;
            max-width: 760px;
            margin: 0 auto;
        }

        .customer-compact-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .customer-compact-action {
            position: relative;
            min-height: 40px;
            padding: 8px 12px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--tb-brown-dark);
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .customer-compact-action:hover {
            color: var(--tb-red);
            background: var(--tb-soft);
        }

        .customer-compact-badge {
            position: absolute;
            top: 1px;
            right: 0;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #dc3545;
            color: #fff;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1199px) {
            .customer-main-search {
                max-width: 320px;
                margin: 0 8px;
            }

            .customer-compact-brand {
                font-size: 0;
            }

            .customer-compact-brand::before {
                content: "🌿";
                font-size: 24px;
            }
        }

        @media (max-width: 991px) {
            .customer-main-search {
                display: none !important;
            }

            .customer-compact-header {
                height: 62px;
            }

            .customer-compact-inner {
                padding: 0 12px;
                gap: 8px;
            }

            .customer-compact-actions .action-text {
                display: none;
            }

            .customer-compact-action {
                padding: 8px;
                min-width: 38px;
                justify-content: center;
            }
        }

        @media (max-width: 575px) {
            .customer-compact-brand {
                display: none;
            }

            .customer-compact-inner {
                gap: 6px;
            }

            .customer-compact-search .customer-search-input {
                height: 40px;
                padding-left: 13px;
                font-size: 13px;
            }
        }


        /* =====================================================
           📂 CUSTOMER CATEGORY MEGA MENU
        ===================================================== */
        .category-mega-item { position: relative; }
        .category-mega-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: min(920px, calc(100vw - 40px));
            min-height: 390px;
            padding: 0;
            overflow: hidden;
            border: 1px solid var(--tb-border);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 50px rgba(44, 24, 16, .22);
            z-index: 1080;
        }
        .category-mega-item:hover > .category-mega-menu,
        .category-mega-item.mega-open > .category-mega-menu { display: flex; }
        .category-mega-left {
            width: 280px;
            flex: 0 0 280px;
            padding: 12px 0;
            background: #fffaf0;
            border-right: 1px solid var(--tb-border);
            max-height: 520px;
            overflow-y: auto;
        }
        .category-mega-title {
            padding: 8px 18px 12px;
            color: var(--tb-brown-dark);
            font-size: .82rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .category-mega-category {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 11px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--tb-text);
            font-weight: 700;
            text-align: left;
            transition: .18s ease;
        }
        .category-mega-category:hover,
        .category-mega-category.active {
            background: #fff;
            color: var(--tb-red);
            box-shadow: inset 4px 0 0 var(--tb-orange);
        }
        .category-mega-right { flex: 1; min-width: 0; padding: 18px 20px; background: #fff; }
        .category-product-panel { display: none; }
        .category-product-panel.active { display: block; }
        .category-product-heading {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-bottom: 16px; padding-bottom: 10px;
            border-bottom: 1px solid var(--tb-border);
        }
        .category-product-heading strong { color: var(--tb-brown-dark); font-size: 1.05rem; }
        .category-product-heading a { color: var(--tb-red); font-size: .88rem; font-weight: 800; text-decoration: none; }
        .category-product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px 12px;
            max-height: 430px;
            overflow-y: auto;
        }
        .category-product-card { color: var(--tb-text); text-decoration: none; text-align: center; min-width: 0; }
        .category-product-card:hover { color: var(--tb-red); }
        .category-product-image {
            width: 100%; aspect-ratio: 1 / 1; object-fit: cover;
            border-radius: 12px; border: 1px solid #f0e4d4; background: var(--tb-soft);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .category-product-card:hover .category-product-image { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(44,24,16,.12); }
        .category-product-name {
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden; margin-top: 8px; font-size: .86rem; font-weight: 700; line-height: 1.35;
        }
        .category-product-empty { padding: 60px 20px; text-align: center; color: #806f63; }
        @media (max-width: 991.98px) {
            .category-mega-menu { position: static; width: 100%; min-height: 0; margin-top: 8px; flex-direction: column; }
            .category-mega-item:hover > .category-mega-menu { display: none; }
            .category-mega-item.mega-open > .category-mega-menu { display: flex; }
            .category-mega-left { width: 100%; flex-basis: auto; border-right: 0; border-bottom: 1px solid var(--tb-border); max-height: 250px; }
            .category-product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

    
        /* =====================================================
           🔎 CUSTOMER NAVBAR 2 HÀNG
           Hàng 1: logo + tìm kiếm + thao tác nhanh
           Hàng 2: các tab điều hướng
        ===================================================== */
        @media (min-width: 992px) {
            .navbar > .container-fluid {
                display: grid !important;
                grid-template-columns: auto minmax(380px, 1fr) auto;
                grid-template-areas:
                    "brand search quick"
                    "menu  menu   menu";
                align-items: center;
                column-gap: 24px;
                row-gap: 8px;
                padding-top: 10px;
                padding-bottom: 8px;
            }

            .navbar > .container-fluid > .navbar-brand {
                grid-area: brand;
                margin: 0;
            }

            .navbar > .container-fluid > .customer-main-search {
                grid-area: search;
                display: block !important;
                width: 100%;
                max-width: 760px;
                min-width: 0;
                margin: 0 auto;
            }

            .navbar > .container-fluid > .navbar-toggler {
                display: none;
            }

            .navbar > .container-fluid > .navbar-collapse {
                grid-area: menu;
                display: flex !important;
                width: 100%;
                justify-content: center;
                border-top: 1px solid rgba(255,255,255,.10);
                padding-top: 7px;
            }

            .navbar > .container-fluid > .navbar-collapse > .navbar-nav {
                width: 100%;
                justify-content: center;
                align-items: center;
                gap: 12px;
            }

            /* Đẩy nhóm thao tác bên phải lên hàng tìm kiếm */
            .navbar > .container-fluid > .customer-top-actions {
                grid-area: quick;
            }

            .navbar .nav-link {
                white-space: nowrap;
            }
        }

    
        /* =====================================================
           CUSTOMER DESKTOP: HÀNG 1 = LOGO + SEARCH + QUICK ACTIONS
                             HÀNG 2 = MENU ĐIỀU HƯỚNG
        ===================================================== */
        @media (min-width: 992px) {
            .navbar > .container-fluid:has(.customer-two-row-nav) {
                grid-template-columns: auto minmax(420px, 1fr) auto !important;
                grid-template-areas:
                    "brand search quick"
                    "menu  menu   menu" !important;
            }

            .navbar > .container-fluid > .customer-two-row-nav {
                display: contents !important;
            }

            .navbar > .container-fluid > .customer-two-row-nav > .customer-menu-row {
                grid-area: menu;
                width: 100%;
                margin: 0 !important;
                padding-top: 7px;
                border-top: 1px solid rgba(255,255,255,.10);
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                gap: 18px;
            }

            .navbar > .container-fluid > .customer-two-row-nav > .customer-quick-row {
                grid-area: quick;
                margin: 0 !important;
                display: flex;
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
                gap: 8px;
            }

            .navbar > .container-fluid > .customer-two-row-nav > .customer-quick-row .nav-link {
                padding-top: 8px;
                padding-bottom: 8px;
            }

            .navbar > .container-fluid:has(.customer-two-row-nav) > .customer-main-search {
                max-width: 760px;
                width: 100%;
            }

            /* Không áp rule navbar-collapse cũ lên Customer nữa */
            .navbar > .container-fluid:has(.customer-two-row-nav) > .navbar-collapse {
                width: auto;
                border-top: 0;
                padding-top: 0;
            }
        }


        /* =====================================================
           🌿 ĐỒNG BỘ MÀU NAVBAR / SEARCH VỚI TINH HOA TÂY BẮC
        ===================================================== */
        .customer-search-input {
            background: var(--tb-cream);
            border-color: rgba(242, 193, 92, .62);
            color: var(--tb-brown-dark);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.75);
        }

        .customer-search-input::placeholder {
            color: #8b7568;
        }

        .customer-search-input:focus {
            background: #fffdf8;
            border-color: var(--tb-gold);
            box-shadow: 0 0 0 3px rgba(242,193,92,.22);
        }

        .customer-search-button {
            background: linear-gradient(135deg, var(--tb-gold), #e6a93f);
            color: var(--tb-brown-dark);
        }

        .customer-search-button:hover {
            background: linear-gradient(135deg, #ffd779, var(--tb-gold));
            color: var(--tb-brown-dark);
        }

        @media (min-width: 992px) {
            .navbar > .container-fluid:has(.customer-two-row-nav) {
                grid-template-columns: minmax(190px, auto) minmax(420px, 760px) auto !important;
            }

            .navbar > .container-fluid > .customer-two-row-nav > .customer-menu-row {
                border-top-color: rgba(242,193,92,.22);
            }

            .navbar > .container-fluid > .customer-two-row-nav > .customer-quick-row {
                min-width: max-content;
            }
        }

        /* =====================================================
           ✨ THANH THU GỌN KHI CUỘN - USER + ADMIN
           Nổi bật, dễ đọc, đồng bộ Tinh Hoa Tây Bắc
        ===================================================== */
        #customerCompactHeader {
            background:
                linear-gradient(
                    90deg,
                    rgba(53, 24, 13, .96) 0%,
                    rgba(102, 57, 31, .94) 55%,
                    rgba(72, 99, 59, .94) 100%
                );
            -webkit-backdrop-filter: blur(16px) saturate(135%);
            backdrop-filter: blur(16px) saturate(135%);
            border-bottom: 1px solid rgba(242, 193, 92, .42);
            box-shadow:
                0 10px 30px rgba(44, 24, 16, .24),
                inset 0 -1px 0 rgba(255,255,255,.06);
        }

        #customerCompactHeader .customer-compact-inner {
            min-height: 70px;
        }

        #customerCompactHeader .customer-compact-brand {
            color: #fffaf0 !important;
            font-weight: 900;
            text-shadow: 0 1px 2px rgba(0,0,0,.22);
        }

        #customerCompactHeader .customer-compact-brand:hover {
            color: var(--tb-gold) !important;
        }

        #customerCompactHeader .customer-compact-search-form {
            background: rgba(255, 250, 240, .98);
            border: 2px solid rgba(242, 193, 92, .78);
            border-radius: 999px;
            box-shadow:
                0 5px 18px rgba(44, 24, 16, .16),
                inset 0 1px 0 rgba(255,255,255,.85);
        }

        #customerCompactHeader .customer-compact-search-input {
            color: var(--tb-brown-dark);
            font-weight: 600;
        }

        #customerCompactHeader .customer-compact-search-input::placeholder {
            color: #8b7568;
            opacity: 1;
        }

        #customerCompactHeader .customer-compact-search-button {
            width: 42px;
            height: 42px;
            margin-right: 3px;
            border-radius: 50%;
            background: linear-gradient(
                135deg,
                #ffd36a,
                var(--tb-gold)
            );
            color: var(--tb-brown-dark);
            box-shadow: 0 4px 12px rgba(44, 24, 16, .18);
            transition:
                transform .16s ease,
                box-shadow .16s ease,
                filter .16s ease;
        }

        #customerCompactHeader .customer-compact-search-button:hover {
            transform: translateY(-1px) scale(1.04);
            filter: brightness(1.04);
            box-shadow: 0 6px 16px rgba(44, 24, 16, .24);
        }

        #customerCompactHeader .customer-compact-action {
            min-height: 42px;
            padding: 8px 11px;
            border: 1px solid transparent;
            border-radius: 12px;
            color: #fffaf0 !important;
            font-weight: 800;
            text-shadow: 0 1px 1px rgba(0,0,0,.18);
            transition:
                background .16s ease,
                border-color .16s ease,
                color .16s ease,
                transform .16s ease;
        }

        #customerCompactHeader .customer-compact-action:hover {
            color: #fff4cf !important;
            background: rgba(242, 193, 92, .16);
            border-color: rgba(242, 193, 92, .38);
            transform: translateY(-1px);
        }

        #customerCompactHeader .customer-compact-action .action-text {
            color: inherit !important;
        }

        #customerCompactHeader .customer-compact-badge {
            top: -5px;
            right: -4px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border: 2px solid #fffaf0;
            background: #dc3545;
            color: #fff;
            font-size: 10px;
            font-weight: 900;
            box-shadow: 0 3px 8px rgba(0,0,0,.22);
        }

        @media (max-width: 1199.98px) {
            #customerCompactHeader .customer-compact-action {
                padding-left: 8px;
                padding-right: 8px;
            }
        }


    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">

    <div class="container-fluid px-lg-5">

        {{-- ============================
            LOGO
        ============================ --}}
        <a
            class="navbar-brand"
            href="{{ url('/') }}"
        >
            🌿 Tinh Hoa Tây Bắc
        </a>

        {{-- 🔎 TÌM KIẾM SẢN PHẨM - dùng chung Guest / Customer / Admin --}}
        <div class="customer-main-search d-none d-lg-block">
            <form
                class="customer-search-form js-product-search-form"
                action="{{ route('products.index') }}"
                method="GET"
                role="search"
                autocomplete="off"
                data-suggestions-url="{{ route('products.searchSuggestions') }}"
            >
                <input
                    type="text"
                    name="search"
                    class="customer-search-input js-product-search-input"
                    value="{{ request('search') }}"
                    placeholder="Tìm kiếm đặc sản Tây Bắc..."
                    aria-label="Tìm kiếm sản phẩm"
                >
                <button
                    type="submit"
                    class="customer-search-button"
                    aria-label="Tìm kiếm"
                    title="Tìm kiếm"
                >
                    🔍
                </button>

                <div
                    class="product-search-suggestions js-product-search-suggestions"
                    aria-live="polite"
                ></div>
            </form>
        </div>


        {{-- MOBILE TOGGLE --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <div
            class="collapse navbar-collapse {{ Auth::check() ? 'customer-two-row-nav' : '' }}"
            id="navbarNav"
        >

            {{-- =====================================================
                CHƯA ĐĂNG NHẬP
            ===================================================== --}}
            @guest

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ url('/') }}"
                        >
                            🏠 Trang chủ
                        </a>

                    </li>

                </ul>


                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('login') }}"
                        >
                            🔐 Đăng nhập
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="btn btn-light btn-sm ms-lg-2 mt-1"
                            href="{{ route('register') }}"
                        >
                            Đăng ký
                        </a>

                    </li>

                </ul>


            @else


                {{-- =================================================
                    ADMIN
                ================================================= --}}
                @if(Auth::user()->role === 'admin')

                    <ul class="navbar-nav me-auto customer-menu-row">

    {{-- TRANG CHỦ --}}
    <li class="nav-item">
        <a
            class="nav-link admin-link {{ request()->is('/') ? 'active' : '' }}"
            href="{{ url('/') }}"
        >
            🏠 Trang chủ
        </a>
    </li>


    {{-- SẢN PHẨM ADMIN - HOVER HIỂN THỊ SẢN PHẨM ĐÃ THÊM --}}
    <li class="nav-item category-mega-item" id="adminProductMega">
        <a
            class="nav-link admin-link {{ request()->routeIs('products.index') || request()->routeIs('products.show') || request()->routeIs('admin.products.*') ? 'active' : '' }}"
            href="{{ route('products.index') }}"
            id="adminProductMegaToggle"
            aria-expanded="false"
        >
            🥩 Sản phẩm <span class="ms-1 small">▾</span>
        </a>

        @php
            /*
             * Dùng chung dữ liệu menuCategories đã được AppServiceProvider
             * cung cấp cho layout. Mỗi category chứa các product hiện có.
             */
            $adminNavCategories = $menuCategories ?? collect();
        @endphp

        <div class="category-mega-menu" id="adminProductMegaMenu">
            <div class="category-mega-left">
                <div class="category-mega-title">
                    Sản phẩm đã thêm
                </div>

                @forelse($adminNavCategories as $category)
                    <button
                        type="button"
                        class="category-mega-category {{ $loop->first ? 'active' : '' }}"
                        data-admin-category-panel="admin-mega-category-{{ $category->id }}"
                    >
                        <span>{{ $category->name }}</span>
                        <span>›</span>
                    </button>
                @empty
                    <div class="px-3 py-4 text-muted small">
                        Chưa có danh mục.
                    </div>
                @endforelse
            </div>

            <div class="category-mega-right">
                @forelse($adminNavCategories as $category)
                    <div
                        class="category-product-panel admin-category-product-panel {{ $loop->first ? 'active' : '' }}"
                        id="admin-mega-category-{{ $category->id }}"
                    >
                        <div class="category-product-heading">
                            <strong>🥩 {{ $category->name }}</strong>

                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}">
                                Xem tất cả →
                            </a>
                        </div>

                        @if($category->products->isNotEmpty())
                            <div class="category-product-grid">
                                @foreach($category->products as $product)
                                    <a
                                        class="category-product-card"
                                        href="{{ route('products.show', $product) }}"
                                        title="Mở sản phẩm với quyền Admin"
                                    >
                                        @php
                                            $adminMegaImage = $product->image
                                                ? (
                                                    str_starts_with($product->image, 'http')
                                                        ? $product->image
                                                        : asset('storage/' . ltrim($product->image, '/'))
                                                )
                                                : null;
                                        @endphp

                                        @if($adminMegaImage)
                                            <img
                                                src="{{ $adminMegaImage }}"
                                                alt="{{ $product->name }}"
                                                class="category-product-image"
                                                loading="lazy"
                                            >
                                        @else
                                            <div
                                                class="category-product-image d-flex align-items-center justify-content-center fs-2"
                                            >
                                                🥩
                                            </div>
                                        @endif

                                        <div class="category-product-name">
                                            {{ $product->name }}
                                        </div>

                                        <div
                                            class="small fw-bold mt-1"
                                            style="color: var(--tb-red);"
                                        >
                                            {{ number_format((float) $product->getCurrentPrice(), 0, ',', '.') }}đ
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="category-product-empty">
                                📦 Danh mục này chưa có sản phẩm.
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="category-product-empty">
                        📂 Chưa có dữ liệu sản phẩm.
                    </div>
                @endforelse
            </div>
        </div>
    </li>


    {{-- DANH MỤC --}}
    <li class="nav-item">
        <a
            class="nav-link admin-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
            href="{{ route('admin.categories.index') }}"
        >
            🧺 Danh mục
        </a>
    </li>


    {{-- ĐƠN HÀNG --}}
    <li class="nav-item">
        <a
            class="nav-link admin-link position-relative {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
            href="{{ route('admin.orders.index') }}"
        >
            📦 Đơn hàng

            @php
                $pendingAdminOrders =
                    \App\Models\Order::where(
                        'status',
                        'pending'
                    )->count();
            @endphp

            @if($pendingAdminOrders > 0)

                <span
                    class="
                        position-absolute
                        top-0
                        start-100
                        translate-middle
                        badge
                        rounded-pill
                        bg-danger
                    "
                >
                    {{ $pendingAdminOrders }}
                </span>

            @endif
        </a>
    </li>


    {{-- VOUCHER --}}
    <li class="nav-item">
        <a
            class="nav-link admin-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}"
            href="{{ route('admin.vouchers.index') }}"
        >
            🎟️ Voucher
        </a>
    </li>

    {{-- TỔNG QUAN - ĐƯA SANG CUỐI MENU ADMIN --}}
    <li class="nav-item">
        <a
            class="nav-link admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}"
        >
            📊 Tổng Quan
        </a>
    </li>

</ul>


                    {{-- =================================================
                        🔔 THÔNG BÁO ADMIN
                    ================================================= --}}
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

                    <ul class="navbar-nav ms-auto align-items-lg-center customer-quick-row">

                        <li class="nav-item dropdown me-lg-2">

                            <a
                                class="nav-link admin-link admin-notification-link"
                                href="#"
                                id="adminNotificationDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                🔔 Thông báo

                                @if($unreadNotificationCount > 0)
                                    <span class="admin-notification-badge">
                                        {{
                                            $unreadNotificationCount > 99
                                                ? '99+'
                                                : $unreadNotificationCount
                                        }}
                                    </span>
                                @endif
                            </a>

                            <div
                                class="dropdown-menu dropdown-menu-end admin-notification-menu"
                                aria-labelledby="adminNotificationDropdown"
                            >
                                <div
                                    class="
                                        admin-notification-header
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

                                <div class="admin-notification-list">

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

                                            $notificationType =
                                                $notificationData['type']
                                                ?? '';

                                            $notificationAlertLevel =
                                                $notificationData['alert_level']
                                                ?? '';

                                            $notificationIcon =
                                                match (true) {
                                                    $notificationType === 'new_order'
                                                        => '📦',

                                                    $notificationType === 'low_stock'
                                                    && $notificationAlertLevel === 'out_of_stock'
                                                        => '❌',

                                                    $notificationType === 'low_stock'
                                                        => '⚠️',

                                                    default
                                                        => '🔔',
                                                };
                                        @endphp

                                        <a
                                            href="{{ route('admin.notifications.read', $notification->id) }}"
                                            class="
                                                admin-notification-item
                                                {{ is_null($notification->read_at) ? 'unread' : '' }}
                                            "
                                        >
                                            <div class="admin-notification-title">
                                                {{ $notificationIcon }}
                                                {{ $notificationTitle }}
                                            </div>

                                            <div class="admin-notification-message">
                                                {{ $notificationMessage }}
                                            </div>

                                            <div class="admin-notification-time">
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

                                        <div class="admin-notification-empty">
                                            <div class="fs-3 mb-2">
                                                🔕
                                            </div>
                                            Chưa có thông báo nào.
                                        </div>

                                    @endforelse

                                </div>

                                <div class="p-2 border-top">

                                    @if($unreadNotificationCount > 0)
                                        <form
                                            method="POST"
                                            action="{{ route('admin.notifications.readAll') }}"
                                            class="mb-2"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm w-100"
                                            >
                                                ✓ Đánh dấu tất cả đã đọc
                                            </button>
                                        </form>
                                    @endif

                                    <a
                                        href="{{ route('admin.orders.index') }}"
                                        class="btn btn-outline-secondary btn-sm w-100"
                                    >
                                        📦 Xem danh sách đơn hàng
                                    </a>
                                </div>
                            </div>

                        </li>


                        {{-- ADMIN ACCOUNT --}}

                        <li class="nav-item dropdown">

                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="adminDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                👑 {{ Auth::user()->name }}
                            </a>


                            <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="adminDropdown"
                            >

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('admin.profile') }}"
                                    >
                                        👤 Hồ sơ Admin
                                    </a>

                                </li>


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
                                        🎟️ Quản lý Voucher
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


                {{-- =================================================
                    CUSTOMER
                ================================================= --}}
                @else

                    <ul class="navbar-nav me-auto customer-menu-row">

                        {{-- TRANG CHỦ --}}
                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                                href="{{ url('/') }}"
                            >
                                🏠 Trang chủ
                            </a>

                        </li>


                        {{-- DANH MỤC - MEGA MENU --}}
                        <li class="nav-item category-mega-item" id="customerCategoryMega">
                            <a
                                class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                                href="{{ route('categories.index') }}"
                                id="customerCategoryMegaToggle"
                                aria-expanded="false"
                            >
                                📂 Danh mục <span class="ms-1 small">▾</span>
                            </a>

                            @php
                                // Dữ liệu được cấp chung từ AppServiceProvider.
                                // Fallback rỗng giúp layout không lỗi nếu cache cũ chưa được xóa.
                                $navCategories = $menuCategories ?? collect();
                            @endphp

                            <div class="category-mega-menu" id="customerCategoryMegaMenu">
                                <div class="category-mega-left">
                                    <div class="category-mega-title">Danh mục sản phẩm</div>

                                    @forelse(($navCategories ?? collect()) as $category)
                                        <button
                                            type="button"
                                            class="category-mega-category {{ $loop->first ? 'active' : '' }}"
                                            data-category-panel="mega-category-{{ $category->id }}"
                                        >
                                            <span>{{ $category->name }}</span>
                                            <span>›</span>
                                        </button>
                                    @empty
                                        <div class="px-3 py-4 text-muted small">Chưa có danh mục.</div>
                                    @endforelse
                                </div>

                                <div class="category-mega-right">
                                    @forelse(($navCategories ?? collect()) as $category)
                                        <div
                                            class="category-product-panel {{ $loop->first ? 'active' : '' }}"
                                            id="mega-category-{{ $category->id }}"
                                        >
                                            <div class="category-product-heading">
                                                <strong>🥩 {{ $category->name }}</strong>
                                                <a href="{{ route('products.index', ['category_id' => $category->id]) }}">Xem tất cả →</a>
                                            </div>

                                            @if($category->products->isNotEmpty())
                                                <div class="category-product-grid">
                                                    @foreach($category->products as $product)
                                                        <a class="category-product-card" href="{{ route('products.show', $product) }}">
                                                            @php
                                                                $megaImage = $product->image
                                                                    ? (str_starts_with($product->image, 'http')
                                                                        ? $product->image
                                                                        : asset('storage/' . ltrim($product->image, '/')))
                                                                    : null;
                                                            @endphp

                                                            @if($megaImage)
                                                                <img
                                                                    src="{{ $megaImage }}"
                                                                    alt="{{ $product->name }}"
                                                                    class="category-product-image"
                                                                    loading="lazy"
                                                                >
                                                            @else
                                                                <div class="category-product-image d-flex align-items-center justify-content-center fs-2">🥩</div>
                                                            @endif
                                                            <div class="category-product-name">{{ $product->name }}</div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="category-product-empty">📦 Danh mục này chưa có sản phẩm.</div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="category-product-empty">📂 Chưa có dữ liệu danh mục.</div>
                                    @endforelse
                                </div>
                            </div>
                        </li>


                        {{-- KHUYẾN MÃI --}}
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('products.promotions') ? 'active' : '' }}"
                                href="{{ route('products.promotions') }}"
                            >
                                🔥 Khuyến mãi
                            </a>
                        </li>


                        {{-- TỔNG QUAN USER --}}
                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}"
                            >
                                📊 Tổng quan
                            </a>

                        </li>


                        {{-- ĐƠN HÀNG CỦA USER --}}
                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                                href="{{ route('orders.index') }}"
                            >
                                📋 Đơn hàng của tôi
                            </a>

                        </li>

                    </ul>


                    {{-- =================================================
                        🔔 THÔNG BÁO CUSTOMER
                    ================================================= --}}
                    @php
                        $customerUser = Auth::user();

                        $customerUnreadNotificationCount =
                            $customerUser->unreadNotifications()->count();

                        $customerLatestNotifications =
                            $customerUser->notifications()
                                ->latest()
                                ->take(6)
                                ->get();
                    @endphp

                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        <li class="nav-item dropdown me-lg-2">

                            <a
                                class="nav-link position-relative"
                                href="#"
                                id="customerNotificationDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                title="Thông báo"
                                aria-label="Thông báo"
                                style="min-width: 44px; text-align: center;"
                            >
                                <span aria-hidden="true">🔔</span>
   

                                @if($customerUnreadNotificationCount > 0)
                                    <span
                                        class="
                                            position-absolute
                                            top-0
                                            start-100
                                            translate-middle
                                            badge
                                            rounded-pill
                                            bg-danger
                                        "
                                    >
                                        {{
                                            $customerUnreadNotificationCount > 99
                                                ? '99+'
                                                : $customerUnreadNotificationCount
                                        }}
                                    </span>
                                @endif
                            </a>

                            <div
                                class="dropdown-menu dropdown-menu-end admin-notification-menu"
                                aria-labelledby="customerNotificationDropdown"
                            >
                                <div
                                    class="
                                        admin-notification-header
                                        d-flex
                                        justify-content-between
                                        align-items-center
                                        gap-3
                                    "
                                >
                                    <div>
                                        <div class="fw-bold">
                                            🔔 Thông báo đơn hàng
                                        </div>

                                        <small class="text-muted">
                                            {{ $customerUnreadNotificationCount }}
                                            thông báo chưa đọc
                                        </small>
                                    </div>

                                    @if($customerUnreadNotificationCount > 0)
                                        <span class="badge bg-danger rounded-pill">
                                            {{ $customerUnreadNotificationCount }}
                                        </span>
                                    @endif
                                </div>

                                <div class="admin-notification-list">

                                    @forelse($customerLatestNotifications as $notification)

                                        @php
                                            $notificationData =
                                                $notification->data ?? [];

                                            $notificationTitle =
                                                $notificationData['title']
                                                ?? 'Thông báo';

                                            $notificationMessage =
                                                $notificationData['message']
                                                ?? 'Đơn hàng của bạn vừa được cập nhật.';
                                        @endphp

                                        <a
                                            href="{{ route('notifications.read', $notification->id) }}"
                                            class="
                                                admin-notification-item
                                                {{ is_null($notification->read_at) ? 'unread' : '' }}
                                            "
                                        >
                                            <div class="admin-notification-title">
                                                📦 {{ $notificationTitle }}
                                            </div>

                                            <div class="admin-notification-message">
                                                {{ $notificationMessage }}
                                            </div>

                                            <div class="admin-notification-time">
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

                                        <div class="admin-notification-empty">
                                            <div class="fs-3 mb-2">
                                                🔕
                                            </div>

                                            Chưa có thông báo nào.
                                        </div>

                                    @endforelse

                                </div>

                                <div class="p-2 border-top">

                                    @if($customerUnreadNotificationCount > 0)
                                        <form
                                            method="POST"
                                            action="{{ route('notifications.readAll') }}"
                                            class="mb-2"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm w-100"
                                            >
                                                ✓ Đánh dấu tất cả đã đọc
                                            </button>
                                        </form>
                                    @endif

                                    <a
                                        href="{{ route('orders.index') }}"
                                        class="btn btn-outline-secondary btn-sm w-100"
                                    >
                                        📋 Xem đơn hàng của tôi
                                    </a>

                                </div>
                            </div>

                        </li>


                        {{-- CUSTOMER ACCOUNT --}}

                        {{-- GIỎ HÀNG --}}
                        <li class="nav-item me-lg-2">

                            <a
                                class="nav-link position-relative {{ request()->routeIs('cart.*') || request()->routeIs('checkout*') ? 'active' : '' }}"
                                href="{{ route('cart.index') }}"
                            >
                                🛒 Giỏ hàng

                                @php
                                    $cartCount =
                                        count(session('cart', []));
                                @endphp

                                @if($cartCount > 0)

                                    <span
                                        class="
                                            position-absolute
                                            top-0
                                            start-100
                                            translate-middle
                                            badge
                                            rounded-pill
                                            bg-danger
                                        "
                                    >
                                        {{ $cartCount }}
                                    </span>

                                @endif

                            </a>

                        </li>


                        {{-- USER DROPDOWN --}}
                        <li class="nav-item dropdown">

                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="customerDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                👤 {{ collect(preg_split('/\s+/', trim(Auth::user()->name)))->last() }}
                            </a>


                            <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="customerDropdown"
                            >

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
                                        href="{{ route('orders.index') }}"
                                    >
                                        📋 Đơn hàng của tôi
                                    </a>

                                </li>
<li>
    <a
        class="dropdown-item"
        href="{{ route('addresses.index') }}"
    >
        📍 Địa chỉ của tôi
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

                @endif

            @endguest

        </div>

    </div>

</nav>


{{-- =====================================================
    🔎 HEADER THU GỌN KHI CUỘN
    Không thay thế navbar cũ; chỉ hiện sau khi scroll > 120px.
===================================================== --}}
@if(Auth::check())
    @php
        $compactIsAdmin = Auth::user()->role === 'admin';

        if ($compactIsAdmin) {
            $compactUnreadCount =
                $unreadNotificationCount
                ?? Auth::user()->unreadNotifications()->count();

            $compactCartCount = 0;

            $compactUserLastName =
                Auth::user()->name;
        } else {
            $compactUnreadCount =
                $customerUnreadNotificationCount
                ?? Auth::user()->unreadNotifications()->count();

            $compactCartCount =
                $cartCount
                ?? count(session('cart', []));

            $compactUserLastName = collect(
                preg_split('/\s+/', trim(Auth::user()->name))
            )->last();
        }
    @endphp

    <div
        class="customer-compact-header"
        id="customerCompactHeader"
        aria-hidden="true"
    >
        <div class="customer-compact-inner">

            <a
                href="{{ url('/') }}"
                class="customer-compact-brand"
                title="Tinh Hoa Tây Bắc"
            >
                🌿 Tinh Hoa Tây Bắc
            </a>

            <div class="customer-compact-search">
                <form
                    class="customer-search-form js-product-search-form"
                    action="{{ route('products.index') }}"
                    method="GET"
                    role="search"
                    autocomplete="off"
                    data-suggestions-url="{{ route('products.searchSuggestions') }}"
                >
                    <input
                        type="text"
                        name="search"
                        class="customer-search-input js-product-search-input"
                        value="{{ request('search') }}"
                        placeholder="Tìm kiếm đặc sản Tây Bắc..."
                        aria-label="Tìm kiếm sản phẩm"
                    >
                    <button
                        type="submit"
                        class="customer-search-button"
                        aria-label="Tìm kiếm"
                        title="Tìm kiếm"
                    >
                        🔍
                    </button>
                </form>
            </div>

            <div class="customer-compact-actions">

                @if($compactIsAdmin)

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="customer-compact-action"
                        title="Tổng Quan Admin"
                    >
                        📊
                        <span class="action-text">Tổng Quan</span>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="customer-compact-action"
                        title="Đơn hàng"
                    >
                        📦
                        <span class="action-text">Đơn hàng</span>
                    </a>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="customer-compact-action"
                        title="Quản lý sản phẩm"
                    >
                        🥩
                        <span class="action-text">Sản phẩm</span>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="customer-compact-action"
                        title="Thông báo"
                    >
                        🔔
                        <span class="action-text">Thông báo</span>

                        @if($compactUnreadCount > 0)
                            <span class="customer-compact-badge">
                                {{ $compactUnreadCount > 99 ? '99+' : $compactUnreadCount }}
                            </span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.profile') }}"
                        class="customer-compact-action"
                        title="Hồ sơ Admin"
                    >
                        👑
                        <span class="action-text">{{ $compactUserLastName }}</span>
                    </a>

                @else

                    <a
                        href="{{ route('orders.index') }}"
                        class="customer-compact-action"
                        title="Đơn hàng của tôi"
                    >
                        📋
                        <span class="action-text">Đơn hàng</span>
                    </a>

                    <a
                        href="{{ route('cart.index') }}"
                        class="customer-compact-action"
                        title="Giỏ hàng"
                    >
                        🛒
                        <span class="action-text">Giỏ hàng</span>

                        @if($compactCartCount > 0)
                            <span class="customer-compact-badge">
                                {{ $compactCartCount }}
                            </span>
                        @endif
                    </a>

                    <a
                        href="{{ route('orders.index') }}"
                        class="customer-compact-action"
                        title="Thông báo"
                    >
                        🔔
                        <span class="action-text">Thông báo</span>

                        @if($compactUnreadCount > 0)
                            <span class="customer-compact-badge">
                                {{ $compactUnreadCount > 99 ? '99+' : $compactUnreadCount }}
                            </span>
                        @endif
                    </a>

                    <a
                        href="{{ route('profile') }}"
                        class="customer-compact-action"
                        title="Tài khoản"
                    >
                        👤
                        <span class="action-text">{{ $compactUserLastName }}</span>
                    </a>

                @endif

            </div>

        </div>
    </div>
@endif


{{-- =====================================================
    NỘI DUNG TRANG
===================================================== --}}
<div class="container-fluid px-lg-5 pb-5">


    {{-- THÔNG BÁO THÀNH CÔNG --}}
    @if(session('success'))

        <div
            class="
                alert
                alert-success
                alert-dismissible
                fade
                show
                shadow-sm
            "
        >
            ✅ {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>
        </div>

    @endif


    {{-- THÔNG BÁO LỖI --}}
    @if(session('error'))

        <div
            class="
                alert
                alert-danger
                alert-dismissible
                fade
                show
                shadow-sm
            "
        >
            ❌ {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>
        </div>

    @endif


    {{-- VALIDATION ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger shadow-sm">

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

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
>
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const compactHeader = document.getElementById('customerCompactHeader');

    if (compactHeader) {
        function updateCompactHeader() {
            const shouldShow = window.scrollY > 120;

            compactHeader.classList.toggle('show', shouldShow);
            compactHeader.setAttribute(
                'aria-hidden',
                shouldShow ? 'false' : 'true'
            );
        }

        updateCompactHeader();

        window.addEventListener(
            'scroll',
            updateCompactHeader,
            { passive: true }
        );
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mega = document.getElementById('customerCategoryMega');
    const toggle = document.getElementById('customerCategoryMegaToggle');
    if (!mega || !toggle) return;

    const categoryButtons = mega.querySelectorAll('.category-mega-category');
    const panels = mega.querySelectorAll('.category-product-panel');

    function showPanel(button) {
        const targetId = button.dataset.categoryPanel;
        categoryButtons.forEach(item => item.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));
        button.classList.add('active');
        const target = document.getElementById(targetId);
        if (target) target.classList.add('active');
    }

    categoryButtons.forEach(button => {
        button.addEventListener('mouseenter', () => showPanel(button));
        button.addEventListener('click', () => showPanel(button));
    });

    toggle.addEventListener('click', function (event) {
        event.preventDefault();
        mega.classList.toggle('mega-open');
        toggle.setAttribute('aria-expanded', mega.classList.contains('mega-open') ? 'true' : 'false');
    });

    document.addEventListener('click', function (event) {
        if (!mega.contains(event.target)) {
            mega.classList.remove('mega-open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const adminMega = document.getElementById('adminProductMega');
    const adminToggle = document.getElementById('adminProductMegaToggle');

    if (!adminMega || !adminToggle) {
        return;
    }

    const categoryButtons = adminMega.querySelectorAll(
        '.category-mega-category[data-admin-category-panel]'
    );

    const panels = adminMega.querySelectorAll(
        '.admin-category-product-panel'
    );

    function showAdminPanel(button) {
        const targetId = button.dataset.adminCategoryPanel;

        categoryButtons.forEach(item => {
            item.classList.remove('active');
        });

        panels.forEach(panel => {
            panel.classList.remove('active');
        });

        button.classList.add('active');

        const target = document.getElementById(targetId);

        if (target) {
            target.classList.add('active');
        }
    }

    categoryButtons.forEach(button => {
        button.addEventListener('mouseenter', function () {
            showAdminPanel(button);
        });

        button.addEventListener('click', function () {
            showAdminPanel(button);
        });
    });

    /*
     * Desktop: CSS .category-mega-item:hover tự mở menu.
     * Mobile/click: dùng mega-open giống menu Customer.
     */
    adminToggle.addEventListener('click', function (event) {
        if (window.innerWidth < 992) {
            event.preventDefault();

            adminMega.classList.toggle('mega-open');

            adminToggle.setAttribute(
                'aria-expanded',
                adminMega.classList.contains('mega-open')
                    ? 'true'
                    : 'false'
            );
        }
    });

    document.addEventListener('click', function (event) {
        if (!adminMega.contains(event.target)) {
            adminMega.classList.remove('mega-open');
            adminToggle.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForms = document.querySelectorAll(
        '.js-product-search-form'
    );

    if (!searchForms.length) {
        return;
    }

    const escapeHtml = function (value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    };

    const formatPrice = function (value) {
        return new Intl.NumberFormat('vi-VN').format(
            Number(value || 0)
        ) + 'đ';
    };

    searchForms.forEach(function (form) {
        const input = form.querySelector(
            '.js-product-search-input'
        );

        if (!input) {
            return;
        }

        let suggestions = form.querySelector(
            '.js-product-search-suggestions'
        );

        if (!suggestions) {
            suggestions = document.createElement('div');
            suggestions.className =
                'product-search-suggestions ' +
                'js-product-search-suggestions';
            suggestions.setAttribute(
                'aria-live',
                'polite'
            );
            form.appendChild(suggestions);
        }

        const endpoint = form.dataset.suggestionsUrl;

        if (!endpoint) {
            return;
        }

        let timer = null;
        let controller = null;
        let activeIndex = -1;

        const closeSuggestions = function () {
            suggestions.classList.remove('show');
            activeIndex = -1;
        };

        const getItems = function () {
            return Array.from(
                suggestions.querySelectorAll(
                    '.product-search-suggestion'
                )
            );
        };

        const setActiveItem = function (index) {
            const items = getItems();

            items.forEach(function (item) {
                item.classList.remove('active');
            });

            if (!items.length) {
                activeIndex = -1;
                return;
            }

            activeIndex = index;

            if (activeIndex < 0) {
                activeIndex = items.length - 1;
            }

            if (activeIndex >= items.length) {
                activeIndex = 0;
            }

            items[activeIndex].classList.add('active');
            items[activeIndex].scrollIntoView({
                block: 'nearest'
            });
        };

        const renderProducts = function (products, keyword) {
            if (!products.length) {
                suggestions.innerHTML =
                    '<div class="product-search-message">' +
                    'Không tìm thấy sản phẩm phù hợp.' +
                    '</div>';

                suggestions.classList.add('show');
                return;
            }

            let html = '';

            products.forEach(function (product) {
                const image = product.image
                    ? '<img class="product-search-suggestion-image" ' +
                      'src="' + escapeHtml(product.image) + '" ' +
                      'alt="' + escapeHtml(product.name) + '">'
                    : '<div class="product-search-suggestion-image ' +
                      'product-search-suggestion-placeholder">🥩</div>';

                const stockText = product.in_stock
                    ? 'Còn hàng'
                    : 'Hết hàng';

                const oldPrice =
                    product.on_sale &&
                    Number(product.original_price) >
                        Number(product.price)
                        ? '<span class="product-search-suggestion-old-price">' +
                          formatPrice(product.original_price) +
                          '</span>'
                        : '';

                html +=
                    '<a class="product-search-suggestion" ' +
                    'href="' + escapeHtml(product.url) + '">' +
                        image +
                        '<div class="product-search-suggestion-body">' +
                            '<div class="product-search-suggestion-name">' +
                                escapeHtml(product.name) +
                            '</div>' +
                            '<div class="product-search-suggestion-meta">' +
                                escapeHtml(product.category) +
                                ' · ' +
                                escapeHtml(stockText) +
                            '</div>' +
                        '</div>' +
                        '<div class="product-search-suggestion-price">' +
                            formatPrice(product.price) +
                            oldPrice +
                        '</div>' +
                    '</a>';
            });

            html +=
                '<a class="product-search-view-all" href="' +
                escapeHtml(
                    form.action +
                    '?search=' +
                    encodeURIComponent(keyword)
                ) +
                '">' +
                'Xem tất cả kết quả cho “' +
                escapeHtml(keyword) +
                '” →' +
                '</a>';

            suggestions.innerHTML = html;
            suggestions.classList.add('show');
            activeIndex = -1;
        };

        const loadSuggestions = async function () {
            const keyword = input.value.trim();

            if (keyword.length < 2) {
                closeSuggestions();
                suggestions.innerHTML = '';
                return;
            }

            if (controller) {
                controller.abort();
            }

            controller = new AbortController();

            suggestions.innerHTML =
                '<div class="product-search-message">' +
                'Đang tìm sản phẩm...' +
                '</div>';

            suggestions.classList.add('show');

            try {
                const response = await fetch(
                    endpoint +
                    '?q=' +
                    encodeURIComponent(keyword),
                    {
                        headers: {
                            'Accept': 'application/json'
                        },
                        signal: controller.signal
                    }
                );

                if (!response.ok) {
                    throw new Error(
                        'Không thể tải gợi ý tìm kiếm.'
                    );
                }

                const products = await response.json();

                if (input.value.trim() !== keyword) {
                    return;
                }

                renderProducts(products, keyword);
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                suggestions.innerHTML =
                    '<div class="product-search-message">' +
                    'Không thể tải gợi ý. Hãy nhấn Enter để tìm kiếm.' +
                    '</div>';

                suggestions.classList.add('show');
            }
        };

        input.addEventListener('input', function () {
            clearTimeout(timer);

            timer = setTimeout(
                loadSuggestions,
                250
            );
        });

        input.addEventListener('focus', function () {
            if (
                input.value.trim().length >= 2 &&
                suggestions.innerHTML.trim() !== ''
            ) {
                suggestions.classList.add('show');
            }
        });

        input.addEventListener('keydown', function (event) {
            const items = getItems();

            if (
                event.key === 'ArrowDown' &&
                items.length
            ) {
                event.preventDefault();
                setActiveItem(activeIndex + 1);
                return;
            }

            if (
                event.key === 'ArrowUp' &&
                items.length
            ) {
                event.preventDefault();
                setActiveItem(activeIndex - 1);
                return;
            }

            if (
                event.key === 'Enter' &&
                activeIndex >= 0 &&
                items[activeIndex]
            ) {
                event.preventDefault();
                window.location.href =
                    items[activeIndex].href;
                return;
            }

            if (event.key === 'Escape') {
                closeSuggestions();
            }
        });

        document.addEventListener(
            'click',
            function (event) {
                if (!form.contains(event.target)) {
                    closeSuggestions();
                }
            }
        );
    });
});
</script>

@include('layouts.partials.footer')
</body>
</html>