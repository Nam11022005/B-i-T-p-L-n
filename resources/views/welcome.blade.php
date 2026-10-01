@extends('layouts.app')

@section('title', 'Tinh Hoa Tây Bắc | Đặc sản Tây Bắc chính hiệu')

@section('content')

@php
    $featuredList =
        isset($featuredProducts)
        ? $featuredProducts->take(5)
        : collect();

    $bestSellerList =
        isset($bestSellingProducts)
        ? $bestSellingProducts->take(5)
        : collect();

    $newProductList =
        $products->take(10);


@endphp


<style>
    /* =========================================================
       TINH HOA TAY BAC - ECOMMERCE HOME
    ========================================================= */

    .shop-home {
        --shop-green: #36562f;
        --shop-green-dark: #274323;

        --shop-brown: #62361f;
        --shop-brown-dark: #3f2417;

        --shop-red: #b43e2e;
        --shop-red-dark: #8e2e22;

        --shop-gold: #e7ad42;
        --shop-gold-soft: #fff1cc;

        --shop-bg: #f7f7f5;
        --shop-card: #ffffff;

        --shop-border: #e8e2d9;

        --shop-text: #29241f;
        --shop-muted: #746d67;

        --shop-shadow:
            0 8px 28px rgba(56, 42, 30, .07);

        --shop-shadow-hover:
            0 17px 40px rgba(56, 42, 30, .13);

        color: var(--shop-text);
    }


    .shop-home * {
        box-sizing: border-box;
    }


    .shop-home a {
        text-decoration: none;
    }


    /* =========================================================
       GENERAL
    ========================================================= */

    .shop-section {
        margin-top: 42px;
    }


    .shop-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 18px;
    }


    .shop-section-label {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 5px;

        color: var(--shop-red);

        font-size: 11px;
        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .shop-section-title {
        margin: 0;

        color: var(--shop-text);

        font-size:
            clamp(24px, 2.4vw, 32px);

        line-height: 1.2;

        font-weight: 950;

        letter-spacing: -.035em;
    }


    .shop-section-subtitle {
        margin-top: 5px;

        color: var(--shop-muted);

        font-size: 12px;

        line-height: 1.55;
    }


    .shop-more-link {
        flex: 0 0 auto;

        display: inline-flex;
        align-items: center;

        gap: 5px;

        color: #68412a;

        font-size: 12px;

        font-weight: 900;
    }


    .shop-more-link:hover {
        color: var(--shop-red);
    }


    /* =========================================================
       TOP MARKETPLACE
    ========================================================= */

    .market-layout {
        display: grid;

        grid-template-columns:
            220px
            minmax(0, 1fr)
            245px;

        gap: 14px;
    }


    /* =========================================================
       CATEGORY SIDEBAR
    ========================================================= */

    .market-categories {
        overflow: hidden;

        border:
            1px solid var(--shop-border);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            var(--shop-shadow);
    }


    .market-category-title {
        min-height: 49px;

        display: flex;
        align-items: center;

        gap: 8px;

        padding:
            0 15px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--shop-green-dark),
                var(--shop-green)
            );

        font-size: 13px;

        font-weight: 900;
    }


    .market-category-list {
        margin: 0;
        padding: 6px 0;

        list-style: none;
    }


    .market-category-list li {
        border-bottom:
            1px solid #f0ece7;
    }


    .market-category-list li:last-child {
        border-bottom: 0;
    }


    .market-category-link {
        min-height: 42px;

        display: flex;
        align-items: center;

        gap: 9px;

        padding:
            7px 13px;

        color: #514940;

        font-size: 11px;

        font-weight: 750;

        transition:
            background .17s ease,
            color .17s ease,
            padding-left .17s ease;
    }


    .market-category-link:hover {
        color: var(--shop-red);

        background:
            #fff8ed;

        padding-left: 17px;
    }


    .market-category-link-icon {
        width: 25px;
        height: 25px;

        flex: 0 0 25px;

        display: grid;
        place-items: center;

        border-radius: 7px;

        background:
            #fff0cd;

        font-size: 14px;
    }


    .market-category-link-arrow {
        margin-left: auto;

        color: #b4aaa0;
    }


    .market-category-all {
        display: block;

        padding:
            12px 13px;

        border-top:
            1px solid var(--shop-border);

        color: var(--shop-green);

        font-size: 11px;

        font-weight: 900;

        text-align: center;
    }


    /* =========================================================
       HERO BANNER
    ========================================================= */

    .market-hero {
        display: grid;
        grid-template-columns: minmax(0, 45fr) minmax(0, 55fr);
        position: relative;
        overflow: hidden;
        min-height: 360px;
        padding: 0;
        border: 1px solid #e5d9c3;
        border-radius: 0;
        background: #faf3e6;
        box-shadow: var(--shop-shadow);
    }

    .market-hero-copy {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        padding: clamp(22px, 2.4vw, 42px);
        color: #29432e;
    }

    .market-hero-eyebrow {
        margin: 0 0 20px;
        color: #7b5939;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .market-hero-title {
        margin: 0;
        color: #29432e;
        font-size: clamp(27px, 2.6vw, 44px);
        font-weight: 800;
        line-height: 1.18;
        letter-spacing: -.035em;
        text-wrap: balance;
    }

    .market-hero-title span {
        display: block;
        margin-top: 12px;
        color: #8b5432;
        font-size: .72em;
        line-height: 1.3;
        font-weight: 600;
        letter-spacing: -.02em;
    }

    .market-hero-description {
        margin: 20px 0 26px;
        color: #6a6254;
        font-size: 14px;
        line-height: 1.7;
    }

    .market-hero-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 46px;
        padding: 12px 18px;
        color: #fff;
        background: #314e34;
        font-size: 13px;
        font-weight: 750;
        line-height: 1.4;
        text-decoration: none;
    }

    .market-hero-cta:hover {
        color: #fff;
        background: #243d27;
    }

    .market-hero-cta:focus-visible {
        outline: 3px solid #b47032;
        outline-offset: 4px;
    }

    .market-hero-visual {
        position: relative;
        min-width: 0;
        margin: 0;
        overflow: hidden;
        background: #d7c69c;
    }

    .market-hero-visual img {
        position: absolute;
        inset: 0;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 52% center;
    }

    .taybac-discovery {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr);
        align-items: center;
        overflow: hidden;
        border: 1px solid #e5d9c3;
        background: #faf3e6;
    }

    .taybac-discovery-copy {
        padding: clamp(24px, 4vw, 56px);
    }

    .taybac-discovery-label {
        margin: 0 0 12px;
        color: #8b5432;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .taybac-discovery h2 {
        margin: 0 0 14px;
        color: #29432e;
        font-size: clamp(24px, 2.4vw, 36px);
        font-weight: 800;
    }

    .taybac-discovery-description {
        margin: 0;
        color: #6a6254;
        font-size: 14px;
        line-height: 1.8;
    }

    .taybac-discovery-credit {
        display: inline-block;
        margin-top: 20px;
        color: #6a6254;
        font-size: 11px;
        text-decoration: underline;
    }

    .taybac-discovery video {
        display: block;
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 390px;
        background: #18271c;
        object-fit: contain;
    }

    html[data-theme="dark"] .market-hero,
    html[data-theme="dark"] .taybac-discovery {
        background: #252d25;
        border-color: #465344;
    }

    html[data-theme="dark"] .market-hero-title,
    html[data-theme="dark"] .taybac-discovery h2 {
        color: #f1eadb;
    }

    html[data-theme="dark"] .market-hero-eyebrow,
    html[data-theme="dark"] .market-hero-title span,
    html[data-theme="dark"] .taybac-discovery-label {
        color: #dec28c;
    }

    html[data-theme="dark"] .market-hero-description,
    html[data-theme="dark"] .taybac-discovery-description,
    html[data-theme="dark"] .taybac-discovery-credit {
        color: #cecbbb;
    }

    html[data-theme="dark"] .market-hero-cta {
        background: #e0c389;
        color: #243d27;
    }

    html[data-theme="dark"] .market-hero-cta:hover {
        background: #eed6a7;
    }



    /* =========================================================
       SIDE PROMOS
    ========================================================= */

    .market-side {
        display: grid;

        grid-template-rows:
            auto auto;

        gap: 14px;
    }


    .side-banner {
        position: relative;

        overflow: hidden;

        min-height: 198px;

        padding: 21px;

        border-radius: 15px;

        box-shadow:
            var(--shop-shadow);
    }


    .side-banner.sale {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                #9d3528,
                #632519
            );
    }


    .side-banner.gift {
        color: #2f4029;

        background:
            linear-gradient(
                135deg,
                #f8e5b3,
                #e9c66e
            );
    }


    .side-banner.best-sellers {
        color: #263b2b;
        background: linear-gradient(135deg, #f8e5b3, #e9c66e);
    }

    .side-banner.best-sellers .side-banner-title {
        max-width: 230px;
        font-size: 18px;
    }

    .best-seller-side-list {
        position: relative;
        z-index: 2;
        display: grid;
        gap: 8px;
        margin-top: 13px;
    }

    .best-seller-side-item {
        display: grid;
        grid-template-columns: 22px minmax(0, 1fr);
        gap: 8px;
        align-items: center;
        color: inherit;
        padding-bottom: 7px;
        border-bottom: 1px solid rgba(47,64,41,.16);
    }

    .best-seller-side-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .best-seller-side-rank {
        width: 22px;
        height: 22px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        color: #fff;
        background: #a13a2a;
        font-size: 11px;
        font-weight: 950;
    }

    .best-seller-side-info {
        min-width: 0;
    }

    .best-seller-side-name {
        display: block;
        overflow: hidden;
        color: inherit;
        font-size: 11px;
        font-weight: 850;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .best-seller-side-meta {
        display: block;
        margin-top: 2px;
        color: #a13a2a;
        font-size: 10px;
        font-weight: 900;
    }

    .best-seller-side-empty {
        position: relative;
        z-index: 2;
        margin: 14px 0 0;
        font-size: 10px;
        line-height: 1.5;
        opacity: .76;
    }


    .side-banner::after {
        content: "";

        position: absolute;

        right: -35px;
        bottom: -35px;

        width: 130px;
        height: 130px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.10);
    }


    .side-banner-label {
        position: relative;

        z-index: 2;

        font-size: 9px;

        font-weight: 900;

        letter-spacing: .11em;

        text-transform: uppercase;
    }


    .side-banner-title {
        position: relative;

        z-index: 2;

        max-width: 160px;

        margin-top: 8px;

        font-size: 22px;

        line-height: 1.12;

        font-weight: 950;

        letter-spacing: -.03em;
    }


    .side-banner-text {
        position: relative;

        z-index: 2;

        max-width: 160px;

        margin-top: 7px;

        font-size: 10px;

        line-height: 1.5;

        opacity: .75;
    }


    .side-banner-link {
        position: absolute;

        z-index: 3;

        left: 21px;
        bottom: 18px;

        color: inherit;

        font-size: 10px;

        font-weight: 900;
    }


    /* Keep side links below their content as the hero becomes more compact. */
    .market-side .side-banner-link {
        position: relative;
        display: inline-flex;
        left: auto;
        bottom: auto;
        margin-top: 12px;
    }

    .market-side .side-banner-text {
        max-width: none;
    }

    .shop-home .market-side .side-banner-title {
        max-width: none;
        font-size: 20px !important;
        line-height: 1.22 !important;
    }

    .shop-home .market-hero h1.market-hero-title {
        font-size: clamp(27px, 2.6vw, 44px) !important;
        line-height: 1.18 !important;
    }

    /* =========================================================
       SERVICE STRIP
    ========================================================= */

    .shop-service-strip {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        margin-top: 18px;
        overflow: hidden;
        border: 1px solid #d8c6a7;
        border-top: 3px solid #47643c;
        border-radius: 14px;
        background: #fff9ed;
        box-shadow: 0 8px 22px rgba(73, 58, 32, .09);
    }

    .shop-service {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 92px;
        padding: 20px 22px;
    }

    .shop-service:not(:last-child) {
        border-right: 1px solid #e3d5bf;
    }

    .shop-service-icon {
        display: grid;
        place-items: center;
        flex: 0 0 46px;
        width: 46px;
        height: 46px;
        border: 1px solid #efcf8b;
        border-radius: 10px;
        background: #ffe9b8;
        font-size: 23px;
    }

    .shop-service strong {
        display: block;
        color: #30492e;
        font-size: 15px;
        font-weight: 800;
    }

    .shop-service span {
        display: block;
        margin-top: 5px;
        color: #70624f;
        font-size: 12.5px;
    }

    html[data-theme="dark"] .shop-service-strip {
        border-color: #4b6045;
        border-top-color: #c6aa6b;
        background: #253025;
    }

    html[data-theme="dark"] .shop-service-strip .shop-service {
        border-color: #465440;
    }

    html[data-theme="dark"] .shop-service strong {
        color: #f3e5c7;
    }

    html[data-theme="dark"] .shop-service span {
        color: #c9c4b4;
    }

    html[data-theme="dark"] .shop-service-icon {
        border-color: #897043;
        background: #574729;
    }


    /* =========================================================
       FLASH SALE
    ========================================================= */

    .flash-box {
        overflow: hidden;

        border:
            1px solid #efd6d0;

        border-radius: 17px;

        background:
            linear-gradient(
                180deg,
                #fff,
                #fff8f6
            );

        box-shadow:
            var(--shop-shadow);
    }


    .flash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding:
            17px 19px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #b33d2d,
                #7f2b20
            );
    }


    .flash-title {
        display: flex;
        align-items: center;

        gap: 8px;

        font-size: 20px;

        font-weight: 950;

        letter-spacing: -.025em;
    }


    .flash-title span {
        color: #ffd47c;
    }


    .flash-note {
        color:
            rgba(255,255,255,.72);

        font-size: 10px;
    }


    .flash-products {
        display: grid;

        grid-template-columns:
            repeat(5, minmax(0, 1fr));

        gap: 0;
    }


    .flash-products
    .commerce-card {
        border: 0;

        border-radius: 0;

        box-shadow: none;
    }


    .flash-products
    .commerce-card:not(:last-child) {
        border-right:
            1px solid #eee5de;
    }


    /* =========================================================
       CATEGORY GRID
    ========================================================= */

    .category-grid {
        display: grid;

        grid-template-columns:
            repeat(8, minmax(0, 1fr));

        overflow: hidden;

        border:
            1px solid var(--shop-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--shop-shadow);
    }


    .category-tile {
        min-height: 125px;

        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

        gap: 8px;

        padding: 14px 7px;

        color: #4d443d;

        text-align: center;

        transition:
            background .17s ease,
            color .17s ease;
    }


    .category-tile:not(:last-child) {
        border-right:
            1px solid #eee9e4;
    }


    .category-tile:hover {
        color: var(--shop-red);

        background:
            #fff9ef;
    }


    .category-tile-icon {
        width: 53px;
        height: 53px;

        display: grid;
        place-items: center;

        border:
            1px solid #ead1a8;

        border-radius: 50%;

        background:
            #fff1d2;

        font-size: 25px;

        transition:
            transform .18s ease;
    }


    .category-tile:hover
    .category-tile-icon {
        transform:
            translateY(-3px);
    }


    .category-tile-name {
        max-width: 120px;

        font-size: 11px;

        line-height: 1.25;

        font-weight: 900;
    }


    .category-tile-count {
        color: #91867e;

        font-size: 9px;
    }


    /* =========================================================
       PRODUCT CARD
    ========================================================= */

    .commerce-grid {
        display: grid;

        grid-template-columns:
            repeat(5, minmax(0, 1fr));

        gap: 14px;
    }


    .commerce-card {
        position: relative;

        overflow: hidden;

        min-width: 0;

        display: flex;
        flex-direction: column;

        border:
            1px solid var(--shop-border);

        border-radius: 15px;

        background:
            var(--shop-card);

        box-shadow:
            var(--shop-shadow);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }


    .commerce-card:hover {
        border-color:
            #d9c5ad;

        transform:
            translateY(-5px);

        box-shadow:
            var(--shop-shadow-hover);
    }


    .commerce-media {
        position: relative;

        height: 210px;

        overflow: hidden;

        background:
            #faf8f5;
    }


    .commerce-media img {
        width: 100%;
        height: 100%;

        padding: 10px;

        object-fit: contain;

        transition:
            transform .27s ease;
    }


    .commerce-card:hover
    .commerce-media img {
        transform:
            scale(1.045);
    }


    .commerce-no-image {
        height: 100%;

        display: grid;
        place-items: center;

        color: #9a8c80;

        font-size: 40px;
    }


    .commerce-sale {
        position: absolute;

        z-index: 4;

        top: 9px;
        left: 9px;

        min-width: 42px;

        padding:
            5px 7px;

        border-radius: 6px;

        color: #fff;

        background:
            var(--shop-red);

        font-size: 9px;

        font-weight: 950;

        text-align: center;
    }


    .commerce-featured {
        position: absolute;

        z-index: 4;

        top: 9px;
        right: 9px;

        padding:
            5px 7px;

        border-radius: 999px;

        color: #5b3a1d;

        background:
            #f4cd78;

        font-size: 8px;

        font-weight: 950;
    }


    .commerce-body {
        flex: 1;

        display: flex;
        flex-direction: column;

        padding:
            13px;
    }


    .commerce-category {
        margin-bottom: 5px;

        color: #898078;

        font-size: 9px;
    }


    .commerce-name {
        min-height: 39px;

        color: #332c27;

        font-size: 13px;

        line-height: 1.45;

        font-weight: 850;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    .commerce-name:hover {
        color: var(--shop-red);
    }


    .commerce-rating {
        display: flex;
        align-items: center;

        gap: 5px;

        min-height: 24px;

        margin-top: 5px;

        color: #e59e16;

        font-size: 10px;
    }


    .commerce-sold {
        color: #92867d;

        font-size: 9px;
    }


    .commerce-price-box {
        margin-top: auto;

        padding-top: 7px;
    }


    .commerce-old-price {
        min-height: 14px;

        color: #a29a93;

        font-size: 9px;

        text-decoration:
            line-through;
    }


    .commerce-price {
        color: var(--shop-red);

        font-size: 17px;

        font-weight: 950;

        letter-spacing: -.02em;
    }


    .commerce-unit {
        color: #8e8178;

        font-size: 8px;

        font-weight: 700;
    }


    .commerce-stock {
        display: flex;
        align-items: center;

        gap: 4px;

        margin-top: 5px;

        color: #4d7b43;

        font-size: 9px;

        font-weight: 850;
    }


    .commerce-stock::before {
        content: "";

        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: #5d8e50;
    }


    .commerce-stock.out {
        color: #ad4b40;
    }


    .commerce-stock.out::before {
        background: #c44d42;
    }


    .commerce-actions {
        display: grid;

        grid-template-columns:
            42px 1fr;

        gap: 6px;

        margin-top: 10px;
    }


    .commerce-detail-btn {
        min-height: 38px;

        display: grid;
        place-items: center;

        border:
            1px solid #ded4ca;

        border-radius: 9px;

        color: #604733;

        background: #fff;

        font-size: 16px;

        font-weight: 900;
    }


    .commerce-detail-btn:hover {
        color: #fff;

        border-color:
            var(--shop-brown);

        background:
            var(--shop-brown);
    }


    .commerce-cart-btn {
        width: 100%;
        min-height: 38px;

        border: 0;

        border-radius: 9px;

        color: #fff;

        background:
            var(--shop-red);

        font-size: 10px;

        font-weight: 900;

        transition:
            background .17s ease;
    }


    .commerce-cart-btn:hover {
        background:
            var(--shop-red-dark);
    }


    .commerce-cart-btn:disabled {
        cursor: not-allowed;

        opacity: .5;
    }


    .commerce-admin-btn {
        width: 100%;
        min-height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        color: #fff;

        background:
            var(--shop-green);

        font-size: 10px;

        font-weight: 900;
    }


    .commerce-admin-btn:hover {
        color: #fff;

        background:
            var(--shop-green-dark);
    }


    /* =========================================================
       WIDE PROMO
    ========================================================= */

    .wide-promo {
        position: relative;

        overflow: hidden;

        display: grid;

        grid-template-columns:
            1fr auto;

        align-items: center;

        gap: 20px;

        padding:
            30px 35px;

        border-radius: 17px;

        color: #fff;

        background:
            radial-gradient(
                circle at 84% 15%,
                rgba(231,173,66,.30),
                transparent 28%
            ),

            linear-gradient(
                120deg,
                #59311e,
                #853226
            );

        box-shadow:
            var(--shop-shadow);
    }


    .wide-promo::after {
        content: "✦";

        position: absolute;

        right: 17%;

        top: -60px;

        color:
            rgba(255,255,255,.06);

        font-size: 180px;
    }


    .wide-promo-copy {
        position: relative;

        z-index: 2;
    }


    .wide-promo-label {
        color: #f4cf78;

        font-size: 10px;

        font-weight: 900;

        letter-spacing: .09em;

        text-transform: uppercase;
    }


    .wide-promo h2 {
        margin:
            5px 0 0;

        font-size:
            clamp(24px,2.7vw,35px);

        font-weight: 950;

        letter-spacing: -.035em;
    }


    .wide-promo p {
        max-width: 690px;

        margin:
            7px 0 0;

        color:
            rgba(255,255,255,.70);

        font-size: 11px;

        line-height: 1.6;
    }


    .wide-promo-btn {
        position: relative;

        z-index: 3;

        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 16px;

        border-radius: 10px;

        color: #50301b;

        background:
            #f3cb73;

        font-size: 11px;

        font-weight: 950;
    }


    .wide-promo-btn:hover {
        color: #422517;

        background:
            #ffe19a;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .commerce-empty {
        grid-column:
            1 / -1;

        padding: 42px 20px;

        border:
            1px dashed #dccab4;

        border-radius: 14px;

        color: #897d74;

        background: #fff;

        text-align: center;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .market-layout {
            grid-template-columns:
                190px
                minmax(0,1fr);
        }


        .market-side {
            display: none;
        }


        .category-grid {
            grid-template-columns:
                repeat(4,1fr);
        }


        .category-tile:nth-child(4n) {
            border-right: 0;
        }


        .commerce-grid,
        .flash-products {
            grid-template-columns:
                repeat(4,minmax(0,1fr));
        }


        .flash-products
        .commerce-card:nth-child(5) {
            display: none;
        }

    }


    @media (max-width: 991.98px) {

        .market-layout {
            grid-template-columns:
                1fr;
        }


        .market-categories {
            display: none;
        }


        .market-hero {
            min-height: 360px;
        }


        .shop-service-strip {
            grid-template-columns:
                repeat(2,1fr);
        }


        .shop-service:nth-child(2) {
            border-right: 0;
        }


        .shop-service:nth-child(-n+2) {
            border-bottom:
                1px solid var(--shop-border);
        }


        .commerce-grid,
        .flash-products {
            grid-template-columns:
                repeat(3,minmax(0,1fr));
        }


        .flash-products
        .commerce-card:nth-child(4) {
            display: none;
        }

    }


    @media (max-width: 767.98px) {

        .shop-section {
            margin-top: 33px;
        }


        .shop-section-header {
            align-items: flex-start;

            flex-direction: column;
        }


        .market-hero {
            grid-template-columns: 1fr;
            min-height: 0;
            aspect-ratio: auto;
        }

        .market-hero-copy {
            padding: 26px;
        }

        .market-hero-title {
            font-size: 32px;
        }

        .market-hero-eyebrow {
            margin-bottom: 14px;
        }

        .market-hero-description {
            margin: 16px 0 20px;
        }

        .market-hero-visual {
            min-height: 0;
            aspect-ratio: 4 / 3;
        }

        .taybac-discovery {
            grid-template-columns: 1fr;
        }


        .category-grid {
            grid-template-columns:
                repeat(4,1fr);
        }


        .category-tile {
            min-height: 110px;
        }


        .commerce-grid,
        .flash-products {
            grid-template-columns:
                repeat(2,minmax(0,1fr));
        }


        .flash-products
        .commerce-card:nth-child(3) {
            display: none;
        }


        .wide-promo {
            grid-template-columns:
                1fr;

            padding:
                27px 22px;
        }


        .wide-promo-btn {
            width: fit-content;
        }

    }


    @media (max-width: 575.98px) {

        .shop-service-strip {
            grid-template-columns: 1fr;
        }


        .shop-service {
            border-right: 0 !important;

            border-bottom:
                1px solid var(--shop-border);
        }


        .shop-service:last-child {
            border-bottom: 0;
        }


        .category-grid {
            grid-template-columns:
                repeat(2,1fr);
        }


        .category-tile {
            border-right:
                1px solid #eee9e4 !important;

            border-bottom:
                1px solid #eee9e4;
        }


        .category-tile:nth-child(2n) {
            border-right: 0 !important;
        }


        .commerce-grid {
            gap: 9px;
        }


        .commerce-media {
            height: 165px;
        }


        .commerce-body {
            padding: 10px;
        }


        .commerce-name {
            font-size: 12px;
        }


        .commerce-price {
            font-size: 15px;
        }


        .commerce-actions {
            grid-template-columns: 1fr;
        }


        .commerce-detail-btn {
            display: none;
        }


        .flash-header {
            align-items: flex-start;

            flex-direction: column;
        }

    }
    /* =========================================================
   NEW PRODUCTS - VỪA LÊN KỆ
   Chỉ làm section sản phẩm mới gọn và cân đối hơn
========================================================= */

.tb-new-products-section {
    position: relative;

    padding:
        30px 28px 32px;

    border:
        1px solid
        #eadbc6;

    border-radius:
        24px;

    background:
        linear-gradient(
            145deg,
            #fffdf9 0%,
            #fff8ed 58%,
            #f5f8f2 100%
        );

    box-shadow:
        0 12px 34px
        rgba(74, 47, 29, .07);
}


.tb-new-products-section
.tb-home-section-head {
    margin-bottom:
        24px;
}


.tb-new-products-section
.tb-products-grid {
    grid-template-columns:
        repeat(
            5,
            minmax(0, 1fr)
        );

    gap:
        16px;
}


.tb-new-products-section
.tb-product-card {
    border-radius:
        17px;

    box-shadow:
        0 8px 22px
        rgba(75, 46, 28, .07);
}


.tb-new-products-section
.tb-product-media {
    height:
        205px;
}


.tb-new-products-section
.tb-product-body {
    padding:
        15px;
}


.tb-new-products-section
.tb-product-name {
    min-height:
        44px;

    font-size:
        15px;
}


.tb-new-products-section
.tb-product-desc {
    display: none;
}


.tb-new-products-section
.tb-product-category {
    margin-bottom:
        7px;

    font-size:
        11px;
}


.tb-new-products-section
.tb-price {
    font-size:
        18px;
}


.tb-new-products-section
.tb-product-actions {
    margin-top:
        12px;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1199.98px) {

    .tb-new-products-section
    .tb-products-grid {
        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 767.98px) {

    .tb-new-products-section {
        padding:
            22px 18px 24px;

        border-radius:
            19px;
    }


    .tb-new-products-section
    .tb-products-grid {
        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap:
            12px;
    }


    .tb-new-products-section
    .tb-product-media {
        height:
            190px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575.98px) {

    .tb-new-products-section
    .tb-products-grid {
        grid-template-columns: 1fr;
    }


    .tb-new-products-section
    .tb-product-media {
        height:
            245px;
    }

}
</style>


<div class="shop-home">


    {{-- =====================================================
        TOP MARKETPLACE
    ====================================================== --}}
    <section>

        <div class="market-layout">


            {{-- CATEGORY SIDEBAR --}}
            <aside class="market-categories">

                <div class="market-category-title">
                    ☰ Danh mục sản phẩm
                </div>


                <ul class="market-category-list">

                    @foreach($categories->take(8) as $category)

                        <li>

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
                                class="market-category-link"
                            >

                                <span class="market-category-link-icon">

                                    {{
                                        $category->icon
                                    }}

                                </span>


                                <span>
                                    {{ $category->name }}
                                </span>


                                <span class="market-category-link-arrow">
                                    ›
                                </span>

                            </a>

                        </li>

                    @endforeach

                </ul>


                <a
                    href="{{ route('products.index') }}"
                    class="market-category-all"
                >
                    Xem tất cả sản phẩm →
                </a>

            </aside>


            {{-- HERO --}}
            <section class="market-hero" aria-labelledby="market-hero-title">
                <div class="market-hero-copy">
                    <p class="market-hero-eyebrow">Tinh Hoa Tây Bắc</p>
                    <h1 class="market-hero-title" id="market-hero-title">
                        Tinh hoa núi rừng
                        <span>Gửi trọn hương vị Tây Bắc</span>
                    </h1>
                    <p class="market-hero-description">
                        Khám phá thịt gác bếp, gia vị và những món quà đặc trưng vùng cao.
                    </p>
                    <a href="{{ route('products.index') }}" class="market-hero-cta">
                        Khám phá đặc sản <span aria-hidden="true">→</span>
                    </a>
                </div>
                <figure class="market-hero-visual">
                    <img
                        src="{{ asset('images/tay-bac-specialties-hero.png') }}"
                        alt="Thịt gác bếp, gia vị, trà và mật ong trên mẹt tre giữa phong cảnh núi rừng Tây Bắc"
                        width="1254"
                        height="1254"
                        fetchpriority="high"
                    >
                </figure>
            </section>



            {{-- SIDE PROMOS --}}
            <aside class="market-side">


                <div class="side-banner sale">

                    <div class="side-banner-label">
                        Ưu đãi
                    </div>

                    <div class="side-banner-title">
                        Giá tốt cho đặc sản yêu thích
                    </div>

                    <div class="side-banner-text">
                        Khám phá sản phẩm
                        đang có chương trình khuyến mãi.
                    </div>

                    <a
                        href="{{ route('products.promotions') }}"
                        class="side-banner-link"
                    >
                        Xem ưu đãi →
                    </a>

                </div>


                <div class="side-banner best-sellers">

                    <div class="side-banner-label">
                        Bán chạy
                    </div>

                    <div class="side-banner-title">
                        Sản phẩm bán chạy
                    </div>

                    <div class="best-seller-side-list">

                        @forelse($bestSellerList->take(3) as $bestProduct)

                            <a
                                href="{{ route('products.show', $bestProduct) }}"
                                class="best-seller-side-item"
                                title="{{ $bestProduct->name }}"
                            >
                                <span class="best-seller-side-rank">
                                    {{ $loop->iteration }}
                                </span>

                                <span class="best-seller-side-info">
                                    <span class="best-seller-side-name">
                                        {{ $bestProduct->name }}
                                    </span>

                                    <span class="best-seller-side-meta">
                                        {{ number_format($bestProduct->getCurrentPrice(), 0, ',', '.') }}đ
                                        · Đã bán {{ number_format((int) ($bestProduct->sold_quantity ?? 0), 0, ',', '.') }}
                                    </span>
                                </span>
                            </a>

                        @empty

                            <p class="best-seller-side-empty">
                                Chưa có đủ dữ liệu bán hàng.
                            </p>

                        @endforelse

                    </div>

                    <a
                        href="{{ route('products.index') }}"
                        class="side-banner-link"
                    >
                        Xem tất cả sản phẩm →
                    </a>

                </div>

            </aside>

        </div>


        {{-- SERVICE STRIP --}}
        <div class="shop-service-strip">


            <div class="shop-service">

                <div class="shop-service-icon">
                    🌿
                </div>

                <div>

                    <strong>
                        Đặc sản chọn lọc
                    </strong>

                    <span>
                        Hương vị Tây Bắc
                    </span>

                </div>

            </div>


            <div class="shop-service">

                <div class="shop-service-icon">
                    🚚
                </div>

                <div>

                    <strong>
                        Giao hàng toàn quốc
                    </strong>

                    <span>
                        Nhiều lựa chọn vận chuyển
                    </span>

                </div>

            </div>


            <div class="shop-service">

                <div class="shop-service-icon">
                    💳
                </div>

                <div>

                    <strong>
                        Thanh toán thuận tiện
                    </strong>

                    <span>
                        COD hoặc chuyển khoản
                    </span>

                </div>

            </div>


            <div class="shop-service">

                <div class="shop-service-icon">
                    📦
                </div>

                <div>

                    <strong>
                        Theo dõi đơn hàng
                    </strong>

                    <span>
                        Cập nhật trạng thái dễ dàng
                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        FLASH SALE / FEATURED
    ====================================================== --}}
    @if($featuredList->count() > 0)

        <section class="shop-section">

            <div class="flash-box">


                <div class="flash-header">

                    <div>

                        <div class="flash-title">

                            ⚡

                            <span>
                                NỔI BẬT HÔM NAY
                            </span>

                        </div>

                        <div class="flash-note">
                            Những sản phẩm đáng chú ý
                            tại Tinh Hoa Tây Bắc.
                        </div>

                    </div>


                    <a
                        href="{{ route('products.index') }}"
                        style="
                            color:#fff;
                            font-size:11px;
                            font-weight:900;
                        "
                    >
                        Xem tất cả →
                    </a>

                </div>


                <div class="flash-products">

                    @foreach($featuredList as $product)

                        <article class="commerce-card">


                            <div class="commerce-media">


                                @if($product->isOnSale())

                                    <span class="commerce-sale">

                                        -{{
                                            $product
                                                ->getDiscountPercent()
                                        }}%

                                    </span>

                                @endif


                                <span class="commerce-featured">
                                    ⭐ Nổi bật
                                </span>


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                >

                                    @if($product->image)

                                        <img
                                            src="{{
                                                asset(
                                                    'storage/'
                                                    . $product->image
                                                )
                                            }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="commerce-no-image">
                                            🧺
                                        </div>

                                    @endif

                                </a>

                            </div>


                            <div class="commerce-body">

                                <div class="commerce-category">

                                    {{
                                        $product
                                            ->category
                                            ?->name
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
                                    class="commerce-name"
                                >
                                    {{ $product->name }}
                                </a>


                                <div class="commerce-rating">

                                    ★★★★★

                                    <span class="commerce-sold">

                                        Đã bán

                                        {{
                                            number_format(
                                                (float)
                                                (
                                                    $product
                                                        ->sold_quantity
                                                    ??
                                                    0
                                                ),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                    </span>

                                </div>


                                <div class="commerce-price-box">

                                    <div class="commerce-old-price">

                                        @if($product->isOnSale())

                                            {{
                                                number_format(
                                                    (float)
                                                    $product->price,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                            đ

                                        @endif

                                    </div>


                                    <div class="commerce-price">

                                        {{
                                            number_format(
                                                $product
                                                    ->getCurrentPrice(),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                        đ

                                        @if($product->unit)

                                            <span class="commerce-unit">
                                                /{{ $product->unit }}
                                            </span>

                                        @endif

                                    </div>


                                    <div
                                        class="
                                            commerce-stock
                                            {{
                                                $product->quantity > 0
                                                ? ''
                                                : 'out'
                                            }}
                                        "
                                    >

                                        {{
                                            $product->quantity > 0
                                            ? 'Còn hàng'
                                            : 'Hết hàng'
                                        }}

                                    </div>

                                </div>


                                <div class="commerce-actions">


                                    <a
                                        href="{{
                                            route(
                                                'products.show',
                                                $product
                                            )
                                        }}"
                                        class="commerce-detail-btn"
                                        title="Xem chi tiết"
                                    >
                                        👁
                                    </a>


                                    @if(Auth::check() && Auth::user()->role === 'admin')

                                        <a
                                            href="{{
                                                route(
                                                    'admin.products.edit',
                                                    $product
                                                )
                                            }}"
                                            class="commerce-admin-btn"
                                        >
                                            Quản lý
                                        </a>


                                    @elseif(Auth::check())

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
                                                class="commerce-cart-btn"
                                                {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                            >
                                                🛒 Thêm vào giỏ
                                            </button>

                                        </form>


                                    @else

                                        <a
                                            href="{{ route('login') }}"
                                            class="commerce-admin-btn"
                                            style="
                                                background:#b43e2e;
                                            "
                                        >
                                            Đăng nhập để mua
                                        </a>

                                    @endif

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
        BEST SELLERS
    ====================================================== --}}
    @if($bestSellerList->count() > 0)

        <section class="shop-section">


            <div class="shop-section-header">

                <div>

                    <div class="shop-section-label">
                        🔥 Khách hàng lựa chọn
                    </div>

                    <h2 class="shop-section-title">
                        Sản phẩm bán chạy
                    </h2>

                    <div class="shop-section-subtitle">
                        Những đặc sản được lựa chọn nhiều.
                    </div>

                </div>


                <a
                    href="{{ route('products.index') }}"
                    class="shop-more-link"
                >
                    Xem tất cả →
                </a>

            </div>


            <div class="commerce-grid">

                @foreach($bestSellerList as $product)

                    <article class="commerce-card">


                        <div class="commerce-media">


                            @if($product->isOnSale())

                                <span class="commerce-sale">

                                    -{{
                                        $product
                                            ->getDiscountPercent()
                                    }}%

                                </span>

                            @endif


                            <a
                                href="{{
                                    route(
                                        'products.show',
                                        $product
                                    )
                                }}"
                            >

                                @if($product->image)

                                    <img
                                        src="{{
                                            asset(
                                                'storage/'
                                                . $product->image
                                            )
                                        }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="commerce-no-image">
                                        🧺
                                    </div>

                                @endif

                            </a>

                        </div>


                        <div class="commerce-body">

                            <div class="commerce-category">

                                {{
                                    $product
                                        ->category
                                        ?->name
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
                                class="commerce-name"
                            >
                                {{ $product->name }}
                            </a>


                            <div class="commerce-rating">

                                ★★★★★

                                <span class="commerce-sold">

                                    Đã bán

                                    {{
                                        number_format(
                                            (float)
                                            (
                                                $product
                                                    ->sold_quantity
                                                ??
                                                0
                                            ),
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="commerce-price-box">

                                <div class="commerce-old-price">

                                    @if($product->isOnSale())

                                        {{
                                            number_format(
                                                (float)
                                                $product->price,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                        đ

                                    @endif

                                </div>


                                <div class="commerce-price">

                                    {{
                                        number_format(
                                            $product
                                                ->getCurrentPrice(),
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                    đ

                                    @if($product->unit)

                                        <span class="commerce-unit">
                                            /{{ $product->unit }}
                                        </span>

                                    @endif

                                </div>


                                <div
                                    class="
                                        commerce-stock
                                        {{
                                            $product->quantity > 0
                                            ? ''
                                            : 'out'
                                        }}
                                    "
                                >

                                    {{
                                        $product->quantity > 0
                                        ? 'Còn hàng'
                                        : 'Hết hàng'
                                    }}

                                </div>

                            </div>


                            <div class="commerce-actions">


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="commerce-detail-btn"
                                    title="Xem chi tiết"
                                >
                                    👁
                                </a>


                                @if(Auth::check() && Auth::user()->role === 'admin')

                                    <a
                                        href="{{
                                            route(
                                                'admin.products.edit',
                                                $product
                                            )
                                        }}"
                                        class="commerce-admin-btn"
                                    >
                                        Quản lý
                                    </a>


                                @elseif(Auth::check())

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
                                            class="commerce-cart-btn"
                                            {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                        >
                                            🛒 Thêm vào giỏ
                                        </button>

                                    </form>


                                @else

                                    <a
                                        href="{{ route('login') }}"
                                        class="commerce-admin-btn"
                                        style="
                                            background:#b43e2e;
                                        "
                                    >
                                        Đăng nhập để mua
                                    </a>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>

    @endif


    {{-- =====================================================
        WIDE PROMO
    ====================================================== --}}
    <section class="shop-section">

        <div class="wide-promo">


            <div class="wide-promo-copy">

                <div class="wide-promo-label">
                    Đặc sản Tây Bắc
                </div>

                <h2>
                    Một món ngon, một món quà mang hương vị núi rừng.
                </h2>

                <p>

                    Chọn những sản phẩm đặc trưng
                    cho gia đình hoặc làm quà
                    với giá bán,
                    tồn kho và khuyến mãi
                    được hiển thị rõ ràng.

                </p>

            </div>


            <a
                href="{{ route('products.promotions') }}"
                class="wide-promo-btn"
            >
                Khám phá ưu đãi →
            </a>

        </div>

    </section>


    {{-- =====================================================
        NEW PRODUCTS
    ====================================================== --}}
  <section class="tb-home-section tb-new-products-section">


        <div class="shop-section-header">

            <div>

                <div class="shop-section-label">
                    🆕 Sản phẩm mới
                </div>

                <h2 class="shop-section-title">
                    Vừa lên kệ
                </h2>

                <div class="shop-section-subtitle">
                    Những sản phẩm mới nhất
                    tại Tinh Hoa Tây Bắc.
                </div>

            </div>


            <a
                href="{{ route('products.index') }}"
                class="shop-more-link"
            >
                Tất cả sản phẩm →
            </a>

        </div>


        <div class="commerce-grid">

            @php
    $newProducts = $products instanceof \Illuminate\Pagination\AbstractPaginator
        ? collect($products->items())->take(5)
        : $products->take(5);
@endphp

@forelse($newProducts as $product)

                <article class="commerce-card">


                    <div class="commerce-media">


                        @if($product->isOnSale())

                            <span class="commerce-sale">

                                -{{
                                    $product
                                        ->getDiscountPercent()
                                }}%

                            </span>

                        @endif


                        <a
                            href="{{
                                route(
                                    'products.show',
                                    $product
                                )
                            }}"
                        >

                            @if($product->image)

                                <img
                                    src="{{
                                        asset(
                                            'storage/'
                                            . $product->image
                                        )
                                    }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="commerce-no-image">
                                    🧺
                                </div>

                            @endif

                        </a>

                    </div>


                    <div class="commerce-body">

                        <div class="commerce-category">

                            {{
                                $product
                                    ->category
                                    ?->name
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
                            class="commerce-name"
                        >
                            {{ $product->name }}
                        </a>


                        <div class="commerce-rating">

                            ★★★★★

                            <span class="commerce-sold">

                                Đã bán

                                {{
                                    number_format(
                                        (float)
                                        (
                                            $product
                                                ->sold_quantity
                                            ??
                                            0
                                        ),
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </span>

                        </div>


                        <div class="commerce-price-box">

                            <div class="commerce-old-price">

                                @if($product->isOnSale())

                                    {{
                                        number_format(
                                            (float)
                                            $product->price,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                    đ

                                @endif

                            </div>


                            <div class="commerce-price">

                                {{
                                    number_format(
                                        $product
                                            ->getCurrentPrice(),
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}
                                đ

                                @if($product->unit)

                                    <span class="commerce-unit">
                                        /{{ $product->unit }}
                                    </span>

                                @endif

                            </div>


                            <div
                                class="
                                    commerce-stock
                                    {{
                                        $product->quantity > 0
                                        ? ''
                                        : 'out'
                                    }}
                                "
                            >

                                {{
                                    $product->quantity > 0
                                    ? 'Còn hàng'
                                    : 'Hết hàng'
                                }}

                            </div>

                        </div>


                        <div class="commerce-actions">


                            <a
                                href="{{
                                    route(
                                        'products.show',
                                        $product
                                    )
                                }}"
                                class="commerce-detail-btn"
                                title="Xem chi tiết"
                            >
                                👁
                            </a>


                            @if(Auth::check() && Auth::user()->role === 'admin')

                                <a
                                    href="{{
                                        route(
                                            'admin.products.edit',
                                            $product
                                        )
                                    }}"
                                    class="commerce-admin-btn"
                                >
                                    Quản lý
                                </a>


                            @elseif(Auth::check())

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
                                        class="commerce-cart-btn"
                                        {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                    >
                                        🛒 Thêm vào giỏ
                                    </button>

                                </form>


                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="commerce-admin-btn"
                                    style="
                                        background:#b43e2e;
                                    "
                                >
                                    Đăng nhập để mua
                                </a>

                            @endif

                        </div>

                    </div>

                </article>


            @empty

                <div class="commerce-empty">

                    🧺

                    <div class="fw-bold mt-2">
                        Chưa có sản phẩm.
                    </div>

                </div>

            @endforelse

        </div>


        @if($products->hasPages())

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>

        @endif

    </section>


    @if(file_exists(public_path('videos/tay-bac-nature.mp4')))
        <section class="shop-section taybac-discovery" aria-labelledby="taybac-discovery-title">
            <div class="taybac-discovery-copy">
                <p class="taybac-discovery-label">Miền đất của những hương vị</p>
                <h2 id="taybac-discovery-title">Khám phá Tây Bắc</h2>
                <p class="taybac-discovery-description">
                    Ngắm những thửa ruộng bậc thang Mù Cang Chải và cảm nhận
                    vẻ đẹp bình dị của núi rừng Tây Bắc.
                </p>
                <a class="taybac-discovery-credit"
                   href="https://pixabay.com/videos/rice-fields-terraces-mountain-rice-87041/"
                   target="_blank" rel="noopener noreferrer">
                    Video: trilemedia / Pixabay
                </a>
            </div>
            <video controls playsinline muted preload="metadata" aria-label="Phong cảnh ruộng bậc thang Mù Cang Chải">
                <source src="{{ asset('videos/tay-bac-nature.mp4') }}" type="video/mp4">
                Trình duyệt của bạn chưa hỗ trợ phát video.
            </video>
        </section>
    @endif




</div>

@endsection