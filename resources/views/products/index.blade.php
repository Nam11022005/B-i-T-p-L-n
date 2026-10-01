@extends('layouts.app')

@section('title', 'Đặc sản Tây Bắc | Tinh Hoa Tây Bắc')

@section('content')

@php
    $selectedCategory = request('category_id')
        ? $categories->firstWhere('id', (int) request('category_id'))
        : null;

    $activeFilterCount = collect([
        request('search'),
        request('category_id'),
        request('min_price'),
        request('max_price'),
        request('stock'),
    ])->filter(function ($value) {
        return $value !== null && $value !== '';
    })->count();

    $formatQuantity = function ($value) {
        return rtrim(
            rtrim(
                number_format(
                    (float) $value,
                    2,
                    '.',
                    ''
                ),
                '0'
            ),
            '.'
        );
    };
@endphp


<style>
    /* =========================================================
       PRODUCT CATALOG - TINH HOA TAY BAC
    ========================================================= */

    .catalog-page {
        --cat-green: #35562f;
        --cat-green-dark: #274522;

        --cat-brown: #633820;
        --cat-brown-dark: #3d2316;

        --cat-red: #b43e2e;
        --cat-red-dark: #8d2f24;

        --cat-gold: #e6ad42;

        --cat-bg: #f7f7f5;
        --cat-card: #ffffff;

        --cat-border: #e7e0d7;

        --cat-text: #302923;
        --cat-muted: #766d66;

        --cat-shadow:
            0 7px 24px
            rgba(54, 40, 29, .065);

        --cat-shadow-hover:
            0 18px 40px
            rgba(54, 40, 29, .13);

        color: var(--cat-text);
    }


    .catalog-page * {
        box-sizing: border-box;
    }


    .catalog-page a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .catalog-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #978c84;

        font-size: 10px;
    }


    .catalog-breadcrumb a {
        color: #665348;

        font-weight: 800;
    }


    .catalog-breadcrumb a:hover {
        color: var(--cat-red);
    }


    /* =========================================================
       CATALOG HEADER
    ========================================================= */

    .catalog-heading {
        position: relative;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;

        margin-bottom: 20px;

        padding:
            25px 29px;

        border:
            1px solid #e1d3c2;

        border-radius: 18px;

        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(230, 173, 66, .17),
                transparent 27%
            ),
            linear-gradient(
                120deg,
                #fffdf9,
                #fff8ec 58%,
                #f2f6ef
            );

        box-shadow:
            var(--cat-shadow);
    }


    .catalog-heading::after {
        content: "";

        position: absolute;

        right: -30px;
        bottom: -50px;

        width: 250px;
        height: 140px;

        opacity: .08;

        background:
            var(--cat-green);

        clip-path:
            polygon(
                0 100%,
                22% 48%,
                39% 70%,
                58% 22%,
                77% 62%,
                100% 15%,
                100% 100%
            );
    }


    .catalog-heading-copy {
        position: relative;

        z-index: 2;
    }


    .catalog-eyebrow {
        margin-bottom: 5px;

        color: var(--cat-red);

        font-size: 9px;

        font-weight: 950;

        letter-spacing: .1em;

        text-transform: uppercase;
    }


    .catalog-title {
        margin: 0;

        color: var(--cat-text);

        font-size:
            clamp(26px, 3vw, 37px);

        line-height: 1.12;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .catalog-description {
        max-width: 690px;

        margin-top: 7px;

        color: var(--cat-muted);

        font-size: 11px;

        line-height: 1.6;
    }


    .catalog-heading-stat {
        position: relative;

        z-index: 2;

        flex: 0 0 auto;

        min-width: 145px;

        padding:
            13px 17px;

        border:
            1px solid #e5c995;

        border-radius: 13px;

        background:
            rgba(255,255,255,.84);

        text-align: center;
    }


    .catalog-heading-stat strong {
        display: block;

        color: var(--cat-brown-dark);

        font-size: 22px;

        font-weight: 950;
    }


    .catalog-heading-stat span {
        display: block;

        margin-top: 1px;

        color: var(--cat-muted);

        font-size: 9px;
    }


    /* =========================================================
       PAGE LAYOUT
    ========================================================= */

    .catalog-layout {
        display: grid;

        grid-template-columns:
            255px
            minmax(0, 1fr);

        gap: 20px;

        align-items: start;
    }


    /* =========================================================
       FILTER SIDEBAR
    ========================================================= */

    .catalog-filter {
        position: sticky;

        top: 177px;

        overflow: hidden;

        border:
            1px solid var(--cat-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--cat-shadow);
    }


    .catalog-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        padding:
            15px 16px;

        border-bottom:
            1px solid var(--cat-border);

        background:
            linear-gradient(
                135deg,
                #334f2d,
                #45673c
            );

        color: #fff;
    }


    .catalog-filter-header strong {
        font-size: 12px;

        font-weight: 950;
    }


    .catalog-filter-count {
        min-width: 22px;
        height: 22px;

        display: grid;
        place-items: center;

        border-radius: 999px;

        color: #4d301a;

        background: #f3ce79;

        font-size: 9px;

        font-weight: 950;
    }


    .catalog-filter-body {
        padding: 16px;
    }


    .filter-group {
        padding-bottom: 16px;

        margin-bottom: 16px;

        border-bottom:
            1px solid #eee8e0;
    }


    .filter-group:last-child {
        margin-bottom: 0;

        padding-bottom: 0;

        border-bottom: 0;
    }


    .filter-heading {
        display: block;

        margin-bottom: 8px;

        color: #514239;

        font-size: 10px;

        font-weight: 950;
    }


    .catalog-input,
    .catalog-select {
        width: 100%;

        min-height: 42px;

        padding:
            0 11px;

        border:
            1px solid #ddd3c7;

        border-radius: 9px;

        outline: 0;

        color: var(--cat-text);

        background: #fff;

        font-size: 10px;

        transition:
            border-color .17s ease,
            box-shadow .17s ease;
    }


    .catalog-input:focus,
    .catalog-select:focus {
        border-color:
            var(--cat-gold);

        box-shadow:
            0 0 0 3px
            rgba(230,173,66,.11);
    }


    .filter-price-grid {
        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap: 7px;
    }


    .stock-options {
        display: grid;

        gap: 7px;
    }


    .stock-option {
        position: relative;
    }


    .stock-option input {
        position: absolute;

        opacity: 0;
        pointer-events: none;
    }


    .stock-option label {
        min-height: 39px;

        display: flex;
        align-items: center;

        gap: 8px;

        padding:
            7px 9px;

        border:
            1px solid #e5ddd3;

        border-radius: 9px;

        color: #5c5048;

        background: #fff;

        font-size: 10px;

        font-weight: 750;

        cursor: pointer;
    }


    .stock-option input:checked + label {
        color:
            var(--cat-green-dark);

        border-color:
            #b9cbae;

        background:
            #f0f6ed;
    }


    .stock-dot {
        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: #a5a09c;
    }


    .stock-dot.in {
        background: #5f8b51;
    }


    .stock-dot.out {
        background: #bd5144;
    }


    .filter-submit {
        width: 100%;
        min-height: 43px;

        border: 0;

        border-radius: 10px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--cat-red),
                var(--cat-red-dark)
            );

        font-size: 10px;

        font-weight: 950;

        transition:
            transform .17s ease,
            box-shadow .17s ease;
    }


    .filter-submit:hover {
        transform: translateY(-1px);

        box-shadow:
            0 8px 18px
            rgba(180,62,46,.2);
    }


    .filter-reset {
        min-height: 39px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-top: 7px;

        border:
            1px solid #ddd4ca;

        border-radius: 10px;

        color: #67584e;

        background: #fff;

        font-size: 9px;

        font-weight: 850;
    }


    .filter-reset:hover {
        color: var(--cat-red);

        border-color: #e1bcb4;

        background: #fff8f5;
    }


    /* =========================================================
       FILTER MOBILE BUTTON
    ========================================================= */

    .catalog-filter-toggle {
        display: none;

        min-height: 41px;

        align-items: center;
        justify-content: center;

        gap: 7px;

        padding:
            0 13px;

        border:
            1px solid #ddd3c7;

        border-radius: 10px;

        color:
            var(--cat-brown-dark);

        background: #fff;

        font-size: 10px;

        font-weight: 900;
    }


    /* =========================================================
       PRODUCT AREA TOPBAR
    ========================================================= */

    .catalog-content {
        min-width: 0;
    }


    .catalog-toolbar {
        min-height: 60px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 13px;

        padding:
            10px 13px;

        border:
            1px solid var(--cat-border);

        border-radius: 13px;

        background: #fff;

        box-shadow:
            var(--cat-shadow);
    }


    .catalog-result {
        min-width: 0;
    }


    .catalog-result-title {
        color: #453a33;

        font-size: 12px;

        font-weight: 900;
    }


    .catalog-result-sub {
        margin-top: 2px;

        color: #887d75;

        font-size: 9px;
    }


    .catalog-toolbar-actions {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .catalog-sort-form {
        display: flex;
        align-items: center;

        gap: 7px;
    }


    .catalog-sort-label {
        color: #7d726a;

        font-size: 9px;

        font-weight: 800;

        white-space: nowrap;
    }


    .catalog-sort {
        min-height: 39px;

        min-width: 155px;

        padding:
            0 30px 0 10px;

        border:
            1px solid #ddd4ca;

        border-radius: 9px;

        outline: 0;

        color:
            #51453d;

        background: #fff;

        font-size: 10px;

        font-weight: 750;
    }


    .catalog-admin-add {
        min-height: 39px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 11px;

        border-radius: 9px;

        color: #fff;

        background:
            var(--cat-green);

        font-size: 9px;

        font-weight: 900;
    }


    .catalog-admin-add:hover {
        color: #fff;

        background:
            var(--cat-green-dark);
    }


    /* =========================================================
       ACTIVE FILTERS
    ========================================================= */

    .catalog-active-filters {
        display: flex;
        flex-wrap: wrap;

        gap: 6px;

        margin-bottom: 13px;
    }


    .filter-chip {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        min-height: 28px;

        padding:
            0 9px;

        border:
            1px solid #e7d8c3;

        border-radius: 999px;

        color: #64452f;

        background: #fff7e8;

        font-size: 9px;

        font-weight: 800;
    }


    /* =========================================================
       PRODUCT GRID
    ========================================================= */

    .catalog-grid {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        gap: 13px;
    }


    .catalog-product {
        position: relative;

        overflow: hidden;

        min-width: 0;

        display: flex;
        flex-direction: column;

        border:
            1px solid var(--cat-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--cat-shadow);

        transition:
            transform .2s ease,
            border-color .2s ease,
            box-shadow .2s ease;
    }


    .catalog-product:hover {
        z-index: 3;

        border-color: #dcc5a7;

        transform:
            translateY(-5px);

        box-shadow:
            var(--cat-shadow-hover);
    }


    /* =========================================================
       PRODUCT IMAGE
    ========================================================= */

    .catalog-product-media {
        position: relative;

        height: 205px;

        overflow: hidden;

        border-bottom:
            1px solid #eee7df;

        background:
            linear-gradient(
                155deg,
                #fbfaf8,
                #fff7ea
            );
    }


    .catalog-product-image-link {
        width: 100%;
        height: 100%;

        display: block;
    }


    .catalog-product-image {
        width: 100%;
        height: 100%;

        padding: 9px;

        object-fit: contain;

        transition:
            transform .28s ease;
    }


    .catalog-product:hover
    .catalog-product-image {
        transform:
            scale(1.055);
    }


    .catalog-product-fallback {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #998a7d;

        font-size: 45px;
    }


    /* =========================================================
       BADGES
    ========================================================= */

    .catalog-sale-badge {
        position: absolute;

        z-index: 4;

        top: 9px;
        left: 9px;

        min-width: 41px;

        padding:
            5px 7px;

        border-radius: 6px;

        color: #fff;

        background:
            var(--cat-red);

        box-shadow:
            0 5px 12px
            rgba(180,62,46,.18);

        font-size: 9px;

        font-weight: 950;
    }


    .catalog-featured-badge {
        position: absolute;

        z-index: 4;

        top: 9px;
        right: 9px;

        padding:
            5px 7px;

        border-radius: 999px;

        color: #503419;

        background: #f4cf7a;

        box-shadow:
            0 4px 10px
            rgba(99,56,32,.1);

        font-size: 8px;

        font-weight: 950;
    }


    .catalog-image-count {
        position: absolute;

        z-index: 4;

        right: 9px;
        bottom: 9px;

        padding:
            4px 6px;

        border-radius: 7px;

        color: #fff;

        background:
            rgba(49,39,31,.69);

        font-size: 8px;

        font-weight: 850;
    }


    /* =========================================================
       PRODUCT BODY
    ========================================================= */

    .catalog-product-body {
        flex: 1;

        display: flex;
        flex-direction: column;

        padding: 12px;
    }


    .catalog-product-category {
        overflow: hidden;

        margin-bottom: 5px;

        color: #93877e;

        font-size: 8px;

        font-weight: 700;

        white-space: nowrap;

        text-overflow: ellipsis;
    }


    .catalog-product-name {
        min-height: 39px;

        color: #342d28;

        font-size: 12px;

        line-height: 1.45;

        font-weight: 900;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    .catalog-product-name:hover {
        color:
            var(--cat-red);
    }


    .catalog-product-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 5px;

        min-height: 25px;

        margin-top: 5px;
    }


    .catalog-sold {
        color: #887c73;

        font-size: 8px;

        font-weight: 700;
    }


    .catalog-stock {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        color: #527748;

        font-size: 8px;

        font-weight: 850;
    }


    .catalog-stock::before {
        content: "";

        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: #609153;
    }


    .catalog-stock.out {
        color: #ab4b40;
    }


    .catalog-stock.out::before {
        background: #c45145;
    }


    /* =========================================================
       PRICE
    ========================================================= */

    .catalog-price-area {
        margin-top: auto;

        padding-top: 8px;
    }


    .catalog-old-price {
        min-height: 14px;

        color: #a39a93;

        font-size: 8px;

        text-decoration:
            line-through;
    }


    .catalog-current-price {
        color:
            var(--cat-red);

        font-size: 16px;

        line-height: 1.25;

        font-weight: 950;

        letter-spacing: -.02em;
    }


    .catalog-current-price small {
        color: #8e8178;

        font-size: 8px;

        font-weight: 700;
    }


    /* =========================================================
       CUSTOMER ACTIONS
    ========================================================= */

    .catalog-actions {
        display: grid;

        grid-template-columns:
            36px
            minmax(0, 1fr);

        gap: 6px;

        margin-top: 10px;
    }


    .catalog-view-btn {
        width: 36px;
        height: 37px;

        display: grid;
        place-items: center;

        border:
            1px solid #ddd4cb;

        border-radius: 8px;

        color:
            var(--cat-brown);

        background: #fff;

        font-size: 14px;
    }


    .catalog-view-btn:hover {
        color: #fff;

        border-color:
            var(--cat-brown);

        background:
            var(--cat-brown);
    }


    .catalog-cart-btn {
        width: 100%;
        min-height: 37px;

        border: 0;

        border-radius: 8px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--cat-red),
                var(--cat-red-dark)
            );

        font-size: 9px;

        font-weight: 950;

        transition:
            transform .17s ease,
            box-shadow .17s ease;
    }


    .catalog-cart-btn:hover {
        transform: translateY(-1px);

        box-shadow:
            0 7px 15px
            rgba(180,62,46,.17);
    }


    .catalog-cart-btn:disabled {
        opacity: .48;

        cursor: not-allowed;

        transform: none;
        box-shadow: none;
    }


    /* =========================================================
       ADMIN ACTIONS
    ========================================================= */

    .catalog-admin-actions {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 5px;

        margin-top: 10px;

        padding-top: 9px;

        border-top:
            1px solid #eee6dd;
    }


    .catalog-admin-btn {
        min-height: 33px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0 5px;

        border:
            1px solid #ddd3c8;

        border-radius: 7px;

        color: #56473e;

        background: #fff;

        font-size: 8px;

        font-weight: 900;

        transition:
            .16s ease;
    }


    .catalog-admin-btn:hover {
        color: var(--cat-red);

        border-color: #deb8ae;

        background: #fff7f4;
    }


    .catalog-admin-btn.edit {
        color: #6b4a13;

        border-color: #e7cc91;

        background: #fff8e3;
    }


    .catalog-admin-btn.featured {
        color: #6d4b12;

        border-color: #e4c674;

        background: #fff4ca;
    }


    .catalog-admin-btn.sale {
        color: #a2382c;

        border-color: #e7bbb5;

        background: #fff5f3;
    }


    .catalog-admin-btn.delete {
        color: #a23b31;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .catalog-empty {
        min-height: 390px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 35px;

        border:
            1px dashed #ddcbb5;

        border-radius: 16px;

        background: #fff;

        text-align: center;
    }


    .catalog-empty-icon {
        font-size: 54px;
    }


    .catalog-empty h3 {
        margin:
            12px 0 4px;

        color: var(--cat-text);

        font-size: 20px;

        font-weight: 950;
    }


    .catalog-empty p {
        margin:
            0 0 15px;

        color: var(--cat-muted);

        font-size: 10px;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .catalog-pagination {
        display: flex;
        justify-content: center;

        margin-top: 28px;
    }


    .catalog-pagination
    .page-link {
        color: var(--cat-brown);

        border-color: #e2d8cd;

        font-size: 10px;
    }


    .catalog-pagination
    .page-item.active
    .page-link {
        border-color:
            var(--cat-red);

        background:
            var(--cat-red);
    }


    /* =========================================================
       PROMOTION MODAL
    ========================================================= */

    .catalog-modal
    .modal-content {
        overflow: hidden;

        border: 0;

        border-radius: 18px;

        box-shadow:
            0 25px 70px
            rgba(40,29,21,.22);
    }


    .catalog-modal
    .modal-header {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--cat-red),
                var(--cat-brown)
            );
    }


    .catalog-modal
    .modal-header
    .btn-close {
        filter:
            invert(1);
    }


    /* =========================================================
       BREAKPOINTS
    ========================================================= */

    @media (min-width: 1450px) {

        .catalog-grid {
            grid-template-columns:
                repeat(
                    5,
                    minmax(0, 1fr)
                );
        }

    }


    @media (max-width: 1199.98px) {

        .catalog-layout {
            grid-template-columns:
                225px
                minmax(0, 1fr);
        }


        .catalog-grid {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );
        }


        .catalog-product-media {
            height: 195px;
        }

    }


    @media (max-width: 991.98px) {

        .catalog-layout {
            grid-template-columns: 1fr;
        }


        .catalog-filter-toggle {
            display: inline-flex;
        }


        .catalog-filter {
            position: static;

            display: none;
        }


        .catalog-filter.is-open {
            display: block;
        }


        .catalog-grid {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );
        }


        .catalog-heading {
            padding:
                22px;
        }


        .catalog-toolbar {
            align-items: flex-start;

            flex-direction: column;
        }


        .catalog-toolbar-actions {
            width: 100%;

            justify-content: space-between;
        }

    }


    @media (max-width: 767.98px) {

        .catalog-heading {
            align-items: flex-start;

            flex-direction: column;

            gap: 14px;
        }


        .catalog-heading-stat {
            min-width: 120px;

            text-align: left;
        }


        .catalog-grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 9px;
        }


        .catalog-product-media {
            height: 180px;
        }

    }


    @media (max-width: 575.98px) {

        .catalog-heading {
            padding:
                19px 17px;

            border-radius: 14px;
        }


        .catalog-title {
            font-size: 26px;
        }


        .catalog-description {
            font-size: 10px;
        }


        .catalog-toolbar-actions {
            align-items: stretch;

            flex-direction: column;
        }


        .catalog-sort-form {
            width: 100%;
        }


        .catalog-sort {
            flex: 1;
        }


        .catalog-product-media {
            height: 155px;
        }


        .catalog-product-body {
            padding: 9px;
        }


        .catalog-product-name {
            min-height: 35px;

            font-size: 11px;
        }


        .catalog-current-price {
            font-size: 14px;
        }


        .catalog-product-meta {
            align-items: flex-start;

            flex-direction: column;

            gap: 2px;
        }


        .catalog-actions {
            grid-template-columns: 1fr;
        }


        .catalog-view-btn {
            display: none;
        }


        .catalog-admin-actions {
            grid-template-columns: 1fr;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .catalog-page *,
        .catalog-page *::before,
        .catalog-page *::after {
            transition: none !important;
        }

    }
</style>


<div class="catalog-page">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="catalog-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <span>
            Sản phẩm
        </span>


        @if($selectedCategory)

            <span>›</span>

            <span>
                {{ $selectedCategory->name }}
            </span>

        @endif

    </div>


    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <section class="catalog-heading">

        <div class="catalog-heading-copy">

            <div class="catalog-eyebrow">
                🌿 Gian hàng đặc sản Tây Bắc
            </div>


            <h1 class="catalog-title">

                @if($selectedCategory)

                    {{ $selectedCategory->name }}

                @elseif(request('search'))

                    Kết quả tìm kiếm

                @else

                    Khám phá đặc sản Tây Bắc

                @endif

            </h1>


            <div class="catalog-description">

                @if(request('search'))

                    Kết quả phù hợp với từ khóa
                    “{{ request('search') }}”.

                @elseif($selectedCategory)

                    Khám phá các sản phẩm thuộc
                    danh mục {{ $selectedCategory->name }}.

                @else

                    Tìm kiếm những hương vị vùng cao
                    với giá bán, khuyến mãi,
                    tồn kho và quy cách mua
                    được hiển thị rõ ràng.

                @endif

            </div>

        </div>


        <div class="catalog-heading-stat">

            <strong>
                {{ number_format($products->total()) }}
            </strong>

            <span>
                sản phẩm phù hợp
            </span>

        </div>

    </section>


    {{-- =====================================================
        MAIN LAYOUT
    ====================================================== --}}
    <div class="catalog-layout">


        {{-- =================================================
            FILTER
        ================================================== --}}
        <aside
            class="catalog-filter"
            id="catalogFilter"
        >

            <div class="catalog-filter-header">

                <strong>
                    ☰ Bộ lọc sản phẩm
                </strong>


                @if($activeFilterCount > 0)

                    <span class="catalog-filter-count">
                        {{ $activeFilterCount }}
                    </span>

                @endif

            </div>


            <form
                action="{{ route('products.index') }}"
                method="GET"
            >

                <div class="catalog-filter-body">


                    {{-- SEARCH --}}
                    <div class="filter-group">

                        <label
                            for="catalogSearch"
                            class="filter-heading"
                        >
                            🔎 Tìm sản phẩm
                        </label>


                        <input
                            type="text"
                            id="catalogSearch"
                            name="search"
                            value="{{ request('search') }}"
                            class="catalog-input"
                            placeholder="Tên đặc sản..."
                        >

                    </div>


                    {{-- CATEGORY --}}
                    <div class="filter-group">

                        <label
                            for="catalogCategory"
                            class="filter-heading"
                        >
                            🧺 Danh mục
                        </label>


                        <select
                            id="catalogCategory"
                            name="category_id"
                            class="catalog-select"
                        >

                            <option value="">
                                Tất cả danh mục
                            </option>


                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PRICE --}}
                    <div class="filter-group">

                        <span class="filter-heading">
                            💰 Khoảng giá
                        </span>


                        <div class="filter-price-grid">

                            <input
                                type="number"
                                name="min_price"
                                min="0"
                                value="{{ request('min_price') }}"
                                class="catalog-input"
                                placeholder="Từ"
                            >


                            <input
                                type="number"
                                name="max_price"
                                min="0"
                                value="{{ request('max_price') }}"
                                class="catalog-input"
                                placeholder="Đến"
                            >

                        </div>


                        <div
                            style="
                                margin-top:5px;
                                color:#9a8e85;
                                font-size:8px;
                            "
                        >
                            Đơn vị: VNĐ
                        </div>

                    </div>


                    {{-- STOCK --}}
                    <div class="filter-group">

                        <span class="filter-heading">
                            📦 Tình trạng hàng
                        </span>


                        <div class="stock-options">


                            <div class="stock-option">

                                <input
                                    type="radio"
                                    name="stock"
                                    id="stockAll"
                                    value=""
                                    {{ request('stock', '') === '' ? 'checked' : '' }}
                                >

                                <label for="stockAll">

                                    <span class="stock-dot">
                                    </span>

                                    Tất cả sản phẩm

                                </label>

                            </div>


                            <div class="stock-option">

                                <input
                                    type="radio"
                                    name="stock"
                                    id="stockIn"
                                    value="in_stock"
                                    {{ request('stock') === 'in_stock' ? 'checked' : '' }}
                                >

                                <label for="stockIn">

                                    <span class="stock-dot in">
                                    </span>

                                    Còn hàng

                                </label>

                            </div>


                            <div class="stock-option">

                                <input
                                    type="radio"
                                    name="stock"
                                    id="stockOut"
                                    value="out_of_stock"
                                    {{ request('stock') === 'out_of_stock' ? 'checked' : '' }}
                                >

                                <label for="stockOut">

                                    <span class="stock-dot out">
                                    </span>

                                    Hết hàng

                                </label>

                            </div>

                        </div>

                    </div>


                    {{-- KEEP SORT --}}
                    @if(request('sort'))

                        <input
                            type="hidden"
                            name="sort"
                            value="{{ request('sort') }}"
                        >

                    @endif


                    <button
                        type="submit"
                        class="filter-submit"
                    >
                        🔎 Áp dụng bộ lọc
                    </button>


                    @if($activeFilterCount > 0 || request('sort'))

                        <a
                            href="{{ route('products.index') }}"
                            class="filter-reset"
                        >
                            ↻ Xóa tất cả bộ lọc
                        </a>

                    @endif

                </div>

            </form>

        </aside>


        {{-- =================================================
            CONTENT
        ================================================== --}}
        <div class="catalog-content">


            {{-- TOOLBAR --}}
            <div class="catalog-toolbar">

                <div class="catalog-result">

                    <div class="catalog-result-title">

                        {{
                            request('search')
                            ? 'Kết quả cho “' . request('search') . '”'
                            : 'Danh sách sản phẩm'
                        }}

                    </div>


                    <div class="catalog-result-sub">

                        Hiển thị
                        {{ $products->firstItem() ?? 0 }}
                        –
                        {{ $products->lastItem() ?? 0 }}
                        trong
                        {{ $products->total() }}
                        sản phẩm

                    </div>

                </div>


                <div class="catalog-toolbar-actions">


                    <button
                        type="button"
                        class="catalog-filter-toggle"
                        id="catalogFilterToggle"
                    >
                        ☰ Bộ lọc

                        @if($activeFilterCount > 0)

                            <span
                                class="
                                    badge
                                    bg-danger
                                    rounded-pill
                                "
                            >
                                {{ $activeFilterCount }}
                            </span>

                        @endif

                    </button>


                    @if(Auth::check() && Auth::user()->role === 'admin')

                        <a
                            href="{{ route('admin.products.create') }}"
                            class="catalog-admin-add"
                        >
                            ＋ Thêm sản phẩm
                        </a>

                    @endif


                    {{-- SORT --}}
                    <form
                        action="{{ route('products.index') }}"
                        method="GET"
                        class="catalog-sort-form"
                    >

                        @if(request('search'))

                            <input
                                type="hidden"
                                name="search"
                                value="{{ request('search') }}"
                            >

                        @endif


                        @if(request('category_id'))

                            <input
                                type="hidden"
                                name="category_id"
                                value="{{ request('category_id') }}"
                            >

                        @endif


                        @if(request('min_price'))

                            <input
                                type="hidden"
                                name="min_price"
                                value="{{ request('min_price') }}"
                            >

                        @endif


                        @if(request('max_price'))

                            <input
                                type="hidden"
                                name="max_price"
                                value="{{ request('max_price') }}"
                            >

                        @endif


                        @if(request('stock'))

                            <input
                                type="hidden"
                                name="stock"
                                value="{{ request('stock') }}"
                            >

                        @endif


                        <span class="catalog-sort-label">
                            Sắp xếp:
                        </span>


                        <select
                            name="sort"
                            class="catalog-sort"
                            onchange="this.form.submit()"
                        >

                            <option
                                value=""
                                {{ request('sort') === null || request('sort') === '' ? 'selected' : '' }}
                            >
                                Mới nhất
                            </option>


                            <option
                                value="price_asc"
                                {{ request('sort') === 'price_asc' ? 'selected' : '' }}
                            >
                                Giá thấp → cao
                            </option>


                            <option
                                value="price_desc"
                                {{ request('sort') === 'price_desc' ? 'selected' : '' }}
                            >
                                Giá cao → thấp
                            </option>


                            <option
                                value="name_asc"
                                {{ request('sort') === 'name_asc' ? 'selected' : '' }}
                            >
                                Tên A → Z
                            </option>


                            <option
                                value="name_desc"
                                {{ request('sort') === 'name_desc' ? 'selected' : '' }}
                            >
                                Tên Z → A
                            </option>

                        </select>

                    </form>

                </div>

            </div>


            {{-- ACTIVE FILTERS --}}
            @if($activeFilterCount > 0)

                <div class="catalog-active-filters">


                    @if(request('search'))

                        <span class="filter-chip">
                            🔎 {{ request('search') }}
                        </span>

                    @endif


                    @if($selectedCategory)

                        <span class="filter-chip">
                            🧺 {{ $selectedCategory->name }}
                        </span>

                    @endif


                    @if(request('min_price'))

                        <span class="filter-chip">

                            Từ
                            {{
                                number_format(
                                    (float) request('min_price'),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </span>

                    @endif


                    @if(request('max_price'))

                        <span class="filter-chip">

                            Đến
                            {{
                                number_format(
                                    (float) request('max_price'),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </span>

                    @endif


                    @if(request('stock') === 'in_stock')

                        <span class="filter-chip">
                            ● Còn hàng
                        </span>

                    @elseif(request('stock') === 'out_of_stock')

                        <span class="filter-chip">
                            ● Hết hàng
                        </span>

                    @endif

                </div>

            @endif


            {{-- =================================================
                EMPTY
            ================================================== --}}
            @if($products->isEmpty())

                <div class="catalog-empty">

                    <div>

                        <div class="catalog-empty-icon">
                            🔎
                        </div>


                        <h3>
                            Không tìm thấy sản phẩm
                        </h3>


                        <p>
                            Hãy thử thay đổi từ khóa,
                            danh mục hoặc khoảng giá.
                        </p>


                        <a
                            href="{{ route('products.index') }}"
                            class="
                                btn
                                btn-dark
                                btn-sm
                                px-4
                            "
                        >
                            Xem tất cả sản phẩm
                        </a>

                    </div>

                </div>


            {{-- =================================================
                PRODUCTS
            ================================================== --}}
            @else

                <div class="catalog-grid">


                    @foreach($products as $product)

                        @php
                            $productImage =
                                $product->image

                                ? (
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
                                )

                                : null;


                            $stockQuantity =
                                (float) $product->quantity;


                            $soldQuantity =
                                (float) (
                                    $product->sold_quantity
                                    ??
                                    0
                                );
                        @endphp


                        <article class="catalog-product">


                            {{-- IMAGE --}}
                            <div class="catalog-product-media">


                                @if($product->isOnSale())

                                    <span class="catalog-sale-badge">

                                        -{{
                                            $product
                                                ->getDiscountPercent()
                                        }}%

                                    </span>

                                @endif


                                @if($product->is_featured)

                                    <span class="catalog-featured-badge">
                                        ⭐ Nổi bật
                                    </span>

                                @endif


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="catalog-product-image-link"
                                >

                                    @if($productImage)

                                        <img
                                            src="{{ $productImage }}"
                                            alt="{{ $product->name }}"
                                            class="catalog-product-image"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='grid';
                                            "
                                        >


                                        <div
                                            class="catalog-product-fallback"
                                            style="display:none;"
                                        >
                                            🧺
                                        </div>

                                    @else

                                        <div class="catalog-product-fallback">
                                            🧺
                                        </div>

                                    @endif

                                </a>

                            </div>


                            {{-- BODY --}}
                            <div class="catalog-product-body">


                                <div class="catalog-product-category">

                                    {{
                                        $product->category?->name
                                        ??
                                        'Đặc sản Tây Bắc'
                                    }}

                                </div>


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="catalog-product-name"
                                >
                                    {{ $product->name }}
                                </a>


                                <div class="catalog-product-meta">

                                    <span class="catalog-sold">

                                        🔥 Đã bán

                                        {{
                                            $formatQuantity(
                                                $soldQuantity
                                            )
                                        }}

                                        @if($product->unit)

                                            {{ $product->unit }}

                                        @endif

                                    </span>


                                    <span
                                        class="
                                            catalog-stock
                                            {{
                                                $stockQuantity > 0
                                                ? ''
                                                : 'out'
                                            }}
                                        "
                                    >

                                        {{
                                            $stockQuantity > 0
                                            ? 'Còn hàng'
                                            : 'Hết hàng'
                                        }}

                                    </span>

                                </div>


                                {{-- PRICE --}}
                                <div class="catalog-price-area">

                                    <div class="catalog-old-price">

                                        @if($product->isOnSale())

                                            {{
                                                number_format(
                                                    (float) $product->price,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}đ

                                        @endif

                                    </div>


                                    <div class="catalog-current-price">

                                        {{
                                            number_format(
                                                $product
                                                    ->getCurrentPrice(),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}đ


                                        @if($product->unit)

                                            <small>
                                                /{{ $product->unit }}
                                            </small>

                                        @endif

                                    </div>

                                </div>


                                {{-- ==========================================
                                    ADMIN
                                =========================================== --}}
                                @if(Auth::check() && Auth::user()->role === 'admin')

                                    <div class="catalog-admin-actions">


                                        <a
                                            href="{{
                                                route(
                                                    'products.show',
                                                    $product
                                                )
                                            }}"
                                            class="catalog-admin-btn"
                                        >
                                            👁 Xem
                                        </a>


                                        <a
                                            href="{{
                                                route(
                                                    'admin.products.edit',
                                                    $product
                                                )
                                            }}"
                                            class="
                                                catalog-admin-btn
                                                edit
                                            "
                                        >
                                            ✏ Sửa
                                        </a>


                                        <form
                                            action="{{
                                                route(
                                                    'admin.products.toggleFeatured',
                                                    $product
                                                )
                                            }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="
                                                    catalog-admin-btn
                                                    featured
                                                    w-100
                                                "
                                            >

                                                {{
                                                    $product->is_featured
                                                    ? '★ Đã ghim'
                                                    : '☆ Ghim'
                                                }}

                                            </button>

                                        </form>


                                        <button
                                            type="button"
                                            class="
                                                catalog-admin-btn
                                                sale
                                            "
                                            data-bs-toggle="modal"
                                            data-bs-target="#promotionModal{{ $product->id }}"
                                        >

                                            {{
                                                $product->isOnSale()
                                                ? '🔥 Sửa sale'
                                                : '🔥 Sale'
                                            }}

                                        </button>


                                        <form
                                            action="{{
                                                route(
                                                    'admin.products.destroy',
                                                    $product
                                                )
                                            }}"
                                            method="POST"
                                            style="grid-column:1 / -1;"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="
                                                    catalog-admin-btn
                                                    delete
                                                    w-100
                                                "
                                            >
                                                🗑 Xóa sản phẩm
                                            </button>

                                        </form>

                                    </div>


                                {{-- ==========================================
                                    CUSTOMER
                                =========================================== --}}
                                @elseif(Auth::check())

                                    <div class="catalog-actions">


                                        <a
                                            href="{{
                                                route(
                                                    'products.show',
                                                    $product
                                                )
                                            }}"
                                            class="catalog-view-btn"
                                            title="Xem chi tiết"
                                        >
                                            👁
                                        </a>


                                        <form
                                            action="{{
                                                route(
                                                    'cart.add',
                                                    $product
                                                )
                                            }}"
                                            method="POST"
                                        >

                                            @csrf


                                            <button
                                                type="submit"
                                                class="catalog-cart-btn"
                                                {{ $stockQuantity <= 0 ? 'disabled' : '' }}
                                            >

                                                @if($stockQuantity > 0)

                                                    🛒 Thêm vào giỏ

                                                @else

                                                    Hết hàng

                                                @endif

                                            </button>

                                        </form>

                                    </div>


                                {{-- ==========================================
                                    GUEST
                                =========================================== --}}
                                @else

                                    <div class="catalog-actions">


                                        <a
                                            href="{{
                                                route(
                                                    'products.show',
                                                    $product
                                                )
                                            }}"
                                            class="catalog-view-btn"
                                            title="Xem chi tiết"
                                        >
                                            👁
                                        </a>


                                        <a
                                            href="{{ route('login') }}"
                                            class="
                                                catalog-cart-btn
                                                d-flex
                                                align-items-center
                                                justify-content-center
                                            "
                                        >
                                            🔐 Đăng nhập để mua
                                        </a>

                                    </div>

                                @endif

                            </div>

                        </article>


                        {{-- ================================================
                            PROMOTION MODAL ADMIN
                        ================================================= --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')

                            <div
                                class="
                                    modal
                                    fade
                                    catalog-modal
                                "
                                id="promotionModal{{ $product->id }}"
                                tabindex="-1"
                                aria-hidden="true"
                            >

                                <div
                                    class="
                                        modal-dialog
                                        modal-dialog-centered
                                    "
                                >

                                    <div class="modal-content">


                                        <form
                                            action="{{
                                                route(
                                                    'admin.products.setPromotion',
                                                    $product
                                                )
                                            }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <div class="modal-header">

                                                <div>

                                                    <h5
                                                        class="
                                                            modal-title
                                                            fw-bold
                                                        "
                                                    >
                                                        🔥 Thiết lập khuyến mãi
                                                    </h5>


                                                    <div
                                                        class="
                                                            small
                                                            mt-1
                                                        "
                                                        style="
                                                            color:
                                                                rgba(
                                                                    255,
                                                                    255,
                                                                    255,
                                                                    .7
                                                                );
                                                        "
                                                    >
                                                        {{ $product->name }}
                                                    </div>

                                                </div>


                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Đóng"
                                                >
                                                </button>

                                            </div>


                                            <div class="modal-body">


                                                <div class="mb-3">

                                                    <label
                                                        class="
                                                            form-label
                                                            fw-bold
                                                        "
                                                    >
                                                        Giá gốc
                                                    </label>


                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="{{
                                                            number_format(
                                                                (float) $product->price,
                                                                0,
                                                                ',',
                                                                '.'
                                                            )
                                                        }} đ"
                                                        disabled
                                                    >

                                                </div>


                                                <div class="mb-3">

                                                    <label
                                                        class="
                                                            form-label
                                                            fw-bold
                                                        "
                                                    >
                                                        Giá khuyến mãi
                                                    </label>


                                                    <input
                                                        type="number"
                                                        name="sale_price"
                                                        class="form-control"
                                                        min="0"
                                                        max="{{ $product->price }}"
                                                        value="{{
                                                            $product->sale_price
                                                            ? (float) $product->sale_price
                                                            : ''
                                                        }}"
                                                        required
                                                    >

                                                </div>


                                                <div class="row g-3">


                                                    <div class="col-md-6">

                                                        <label
                                                            class="
                                                                form-label
                                                                fw-bold
                                                            "
                                                        >
                                                            Bắt đầu
                                                        </label>


                                                        <input
                                                            type="datetime-local"
                                                            name="sale_start"
                                                            class="form-control"
                                                            value="{{
                                                                $product->sale_start
                                                                ? $product->sale_start->format('Y-m-d\TH:i')
                                                                : now()->format('Y-m-d\TH:i')
                                                            }}"
                                                        >

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label
                                                            class="
                                                                form-label
                                                                fw-bold
                                                            "
                                                        >
                                                            Kết thúc
                                                        </label>


                                                        <input
                                                            type="datetime-local"
                                                            name="sale_end"
                                                            class="form-control"
                                                            value="{{
                                                                $product->sale_end
                                                                ? $product->sale_end->format('Y-m-d\TH:i')
                                                                : now()->addDays(7)->format('Y-m-d\TH:i')
                                                            }}"
                                                        >

                                                    </div>

                                                </div>

                                            </div>


                                            <div class="modal-footer">


                                                @if($product->sale_price)

                                                    <button
                                                        type="submit"
                                                        form="removeSaleForm{{ $product->id }}"
                                                        class="
                                                            btn
                                                            btn-outline-danger
                                                            me-auto
                                                        "
                                                    >
                                                        🗑 Gỡ sale
                                                    </button>

                                                @endif


                                                <button
                                                    type="button"
                                                    class="
                                                        btn
                                                        btn-light
                                                    "
                                                    data-bs-dismiss="modal"
                                                >
                                                    Đóng
                                                </button>


                                                <button
                                                    type="submit"
                                                    class="
                                                        btn
                                                        btn-danger
                                                    "
                                                >
                                                    🔥 Lưu khuyến mãi
                                                </button>

                                            </div>

                                        </form>


                                        @if($product->sale_price)

                                            <form
                                                id="removeSaleForm{{ $product->id }}"
                                                action="{{
                                                    route(
                                                        'admin.products.removePromotion',
                                                        $product
                                                    )
                                                }}"
                                                method="POST"
                                                class="d-none"
                                            >

                                                @csrf
                                                @method('DELETE')

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>


                {{-- PAGINATION --}}
                @if($products->hasPages())

                    <div class="catalog-pagination">

                        {{ $products->links() }}

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const toggle =
            document.getElementById(
                'catalogFilterToggle'
            );


        const filter =
            document.getElementById(
                'catalogFilter'
            );


        if (
            toggle
            &&
            filter
        ) {

            toggle.addEventListener(
                'click',
                function () {

                    const opened =
                        filter
                            .classList
                            .toggle(
                                'is-open'
                            );


                    toggle.innerHTML =
                        opened
                        ? '× Đóng bộ lọc'
                        : '☰ Bộ lọc';

                }
            );

        }

    }
);
</script>

@endsection