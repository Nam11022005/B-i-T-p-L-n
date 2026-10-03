@extends('layouts.app')

@section('title', 'Khuyến mãi | Tinh Hoa Tây Bắc')

@section('content')

<style>
    :root {
        --promo-brown: #5f341d;
        --promo-dark: #2c1810;
        --promo-red: #a83b2d;
        --promo-gold: #f2c15c;
        --promo-green: #48633b;
        --promo-cream: #fffaf0;
        --promo-soft: #f8efe2;
        --promo-border: #ead8bf;
        --promo-text: #2f241e;
    }


    /* =========================================================
       PAGE WRAPPER - LAYOUT MỚI
       BỎ GIỚI HẠN BOOTSTRAP .container
    ========================================================= */

    .promotions-page {
        position: relative;
        isolation: isolate;

        width: min(
            1480px,
            calc(100% - 38px)
        );

        max-width: none;

        margin: 0 auto;

        padding: 34px 0 82px;
    }


    .promotions-page::before {
        content: "";

        position: absolute;

        z-index: -3;

        top: -30px;
        left: 50%;

        width: min(100vw, 1760px);
        height: 760px;

        transform: translateX(-50%);

        pointer-events: none;

        background:
            radial-gradient(
                circle at 8% 8%,
                rgba(242,193,92,.22),
                transparent 24%
            ),
            radial-gradient(
                circle at 94% 11%,
                rgba(72,99,59,.13),
                transparent 29%
            ),
            radial-gradient(
                circle at 50% 22%,
                rgba(168,59,45,.055),
                transparent 31%
            ),
            linear-gradient(
                180deg,
                rgba(255,250,240,.98),
                rgba(255,255,255,0)
            );
    }


    .promotions-page::after {
        content: "";

        position: absolute;

        z-index: -2;

        top: 155px;
        right: -70px;

        width: 250px;
        height: 250px;

        border-radius: 50%;

        opacity: .08;

        pointer-events: none;

        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.35) 0 1px,
                transparent 1px 14px
            );
    }


/* =========================================================
   HERO KHUYẾN MÃI - LAYOUT MỚI SÁNG, ĐỒNG BỘ WEBSITE
========================================================= */

.promotions-hero {
    position: relative;

    overflow: hidden;

    min-height: 260px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 42px;

    padding: 46px 48px;

    margin-bottom: 28px;

    border: 1px solid #ead8bf;

    border-radius: 28px;

    color: #33261f;

    background:
        radial-gradient(
            circle at 92% 8%,
            rgba(229,173,66,.18),
            transparent 27%
        ),
        radial-gradient(
            circle at 4% 100%,
            rgba(53,86,47,.08),
            transparent 31%
        ),
        linear-gradient(
            135deg,
            #fffefb 0%,
            #fff9ee 52%,
            #f7f5eb 100%
        );

    box-shadow:
        0 18px 45px rgba(99,56,32,.09),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* Đường nhấn màu phía trên */
.promotions-hero::before {
    content: "";

    position: absolute;

    top: 0;

    left: 6%;

    right: 6%;

    height: 4px;

    border-radius: 0 0 999px 999px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #e5ad42 22%,
            #b43e2e 50%,
            #35562f 78%,
            transparent
        );

    opacity: .9;
}


/* Họa tiết nhẹ bên phải */
.promotions-hero::after {
    content: "✦";

    position: absolute;

    right: 44px;

    top: 24px;

    font-size: 118px;

    opacity: .055;

    transform: rotate(-10deg);

    pointer-events: none;
}


.promotions-hero > * {
    position: relative;

    z-index: 2;
}


/* =========================================================
   BADGE
========================================================= */

.promotions-kicker {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 13px;

    margin-bottom: 17px;

    border: 1px solid #ebc983;

    border-radius: 999px;

    color: #9a4b27;

    background:
        linear-gradient(
            135deg,
            #fff5d7,
            #ffedbd
        );

    font-size: 11px;

    font-weight: 900;

    letter-spacing: .08em;

    text-transform: uppercase;

    box-shadow:
        0 5px 14px rgba(229,173,66,.10);
}


/* =========================================================
   TITLE
========================================================= */

.promotions-hero h1 {
    max-width: 760px;

    margin: 0 0 13px;

    color: #34251d;

    font-size:
        clamp(
            38px,
            4vw,
            56px
        );

    line-height: 1.06;

    font-weight: 950;

    letter-spacing: -1.1px;

    text-shadow: none;
}


/* Nhấn từ "ưu đãi" */
.promotions-hero h1::after {
    content: "";

    display: block;

    width: 68px;

    height: 4px;

    margin-top: 18px;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            #b43e2e,
            #e5ad42,
            #35562f
        );
}


/* =========================================================
   DESCRIPTION
========================================================= */

.promotions-hero p {
    max-width: 760px;

    margin: 0;

    color: #75675e;

    font-size: 15px;

    line-height: 1.75;
}


/* =========================================================
   STAT BOX
========================================================= */

.promotions-hero-stat {
    min-width: 190px;

    padding: 26px 24px;

    border: 1px solid #dcd9c4;

    border-radius: 22px;

    background:
        radial-gradient(
            circle at 85% 10%,
            rgba(229,173,66,.17),
            transparent 35%
        ),
        linear-gradient(
            145deg,
            #f7f9f3,
            #eef4e9
        );

    text-align: center;

    backdrop-filter: none;

    box-shadow:
        0 12px 28px rgba(53,86,47,.08),
        inset 0 1px 0 rgba(255,255,255,.95);
}


.promotions-hero-stat strong {
    display: block;

    color: #35562f;

    font-size: 42px;

    line-height: 1;

    font-weight: 950;

    letter-spacing: -1px;
}


.promotions-hero-stat span {
    display: block;

    margin-top: 9px;

    color: #6b715f;

    font-size: 11px;

    font-weight: 900;

    text-transform: uppercase;

    letter-spacing: .07em;
}


/* =========================================================
   HOVER NHẸ
========================================================= */

.promotions-hero {
    transition:
        transform .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}


.promotions-hero:hover {
    transform: translateY(-2px);

    border-color: #e1c69e;

    box-shadow:
        0 22px 52px rgba(99,56,32,.11),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 991.98px) {

    .promotions-hero {
        min-height: 0;

        padding: 36px 32px;

        border-radius: 24px;
    }


    .promotions-hero-stat {
        min-width: 165px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 767.98px) {

    .promotions-hero {
        flex-direction: column;

        align-items: flex-start;

        gap: 25px;

        padding: 30px 24px;

        border-radius: 22px;
    }


    .promotions-hero h1 {
        font-size: 38px;
    }


    .promotions-hero-stat {
        width: 100%;

        min-width: 0;
    }


    .promotions-hero::after {
        right: 10px;

        top: 20px;

        font-size: 92px;
    }

}


@media (max-width: 575.98px) {

    .promotions-hero {
        padding: 26px 20px;

        border-radius: 19px;
    }


    .promotions-hero h1 {
        font-size: 33px;

        line-height: 1.1;
    }


    .promotions-hero p {
        font-size: 14px;
    }


    .promotions-hero-stat {
        padding: 21px 18px;

        border-radius: 17px;
    }


    .promotions-hero-stat strong {
        font-size: 36px;
    }

}

    .promotions-hero-stat span {
        display: block;

        margin-top: 8px;

        color:
            rgba(255,255,255,.74);

        font-size: 12px;

        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .06em;
    }


    /* =========================================================
       INFO STRIP
    ========================================================= */

    .promo-info-strip {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0,1fr)
            );

        gap: 14px;

        margin-bottom: 30px;
    }


    .promo-info-item {
        display: flex;

        align-items: center;

        gap: 12px;

        padding: 16px 18px;

        border:
            1px solid
            var(--promo-border);

        border-radius: 17px;

        background:
            radial-gradient(
                circle at 95% 10%,
                rgba(242,193,92,.10),
                transparent 28%
            ),
            #fff;

        box-shadow:
            0 9px 24px
            rgba(95,52,29,.055);
    }


    .promo-info-icon {
        width: 43px;
        height: 43px;

        flex: 0 0 43px;

        display: grid;

        place-items: center;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #fff1cc,
                #f7dfad
            );

        border:
            1px solid
            #e5cb9f;

        font-size: 20px;
    }


    .promo-info-item strong {
        display: block;

        color:
            var(--promo-dark);

        font-size: 14px;
    }


    .promo-info-item small {
        color: #827267;

        line-height: 1.45;
    }


    /* =========================================================
       SECTION HEAD
    ========================================================= */

    .promotions-section-head {
        display: flex;

        justify-content:
            space-between;

        align-items: end;

        gap: 20px;

        margin-bottom: 18px;
    }


    .promotions-section-head h2 {
        margin: 0;

        color:
            var(--promo-dark);

        font-size: 28px;

        font-weight: 950;

        letter-spacing: -.4px;
    }


    .promotions-section-head p {
        margin: 4px 0 0;

        color: #847268;
    }


    /* =========================================================
       PRODUCT CARD
    ========================================================= */

    .promo-product-card {
        position: relative;

        overflow: hidden;

        height: 100%;

        display: flex;

        flex-direction: column;

        border:
            1px solid
            #e6d1b4;

        border-radius: 22px;

        background: #fff;

        box-shadow:
            0 13px 34px
            rgba(95,52,29,.075),
            inset 0 1px 0
            rgba(255,255,255,.95);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }


    .promo-product-card:hover {
        transform:
            translateY(-5px);

        border-color:
            #d8ba8c;

        box-shadow:
            0 20px 42px
            rgba(95,52,29,.13);
    }


    .promo-image-wrap {
        position: relative;

        height: 240px;

        overflow: hidden;

        display: grid;

        place-items: center;

        background:
            radial-gradient(
                circle at 82% 12%,
                rgba(242,193,92,.18),
                transparent 30%
            ),
            linear-gradient(
                180deg,
                #fffaf0,
                #f8efe2
            );

        border-bottom:
            1px solid
            #ead8bf;
    }


    .promo-image-wrap img {
        width: 100%;
        height: 100%;

        object-fit: contain;

        padding: 18px;

        transition:
            transform .28s ease;
    }


    .promo-product-card:hover
    .promo-image-wrap img {
        transform:
            scale(1.035);
    }


    .promo-placeholder {
        font-size: 70px;

        opacity: .44;
    }


    .promo-sale-badge {
        position: absolute;

        z-index: 3;

        top: 14px;
        left: 14px;

        padding: 8px 11px;

        border-radius: 999px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #d54b3d,
                #a83b2d
            );

        font-size: 12px;

        font-weight: 950;

        box-shadow:
            0 8px 18px
            rgba(168,59,45,.24);
    }


    .promo-stock-badge {
        position: absolute;

        z-index: 3;

        top: 14px;
        right: 14px;

        padding: 7px 10px;

        border-radius: 999px;

        font-size: 11px;

        font-weight: 900;

        border:
            1px solid
            rgba(255,255,255,.8);

        box-shadow:
            0 5px 14px
            rgba(44,24,16,.08);
    }


    .promo-stock-badge.in-stock {
        color: #2e5b34;

        background: #eaf6eb;
    }


    .promo-stock-badge.out-stock {
        color: #8e382d;

        background: #fff0ed;
    }


    .promo-card-body {
        display: flex;

        flex: 1;

        flex-direction: column;

        padding: 20px;
    }


    .promo-category {
        width: fit-content;

        margin-bottom: 9px;

        padding: 5px 9px;

        border:
            1px solid
            #e5d2b8;

        border-radius: 999px;

        color:
            var(--promo-green);

        background: #fbf7ef;

        font-size: 11px;

        font-weight: 850;
    }


    .promo-name {
        margin-bottom: 9px;

        color:
            var(--promo-text);

        font-size: 18px;

        font-weight: 900;

        line-height: 1.35;
    }


    .promo-description {
        display: -webkit-box;

        overflow: hidden;

        margin-bottom: 14px;

        color: #7b6c62;

        font-size: 13px;

        line-height: 1.6;

        -webkit-box-orient:
            vertical;

        -webkit-line-clamp: 2;
    }


    .promo-price-row {
        display: flex;

        align-items: end;

        flex-wrap: wrap;

        gap: 7px 10px;

        margin-top: auto;

        margin-bottom: 12px;
    }


    .promo-sale-price {
        color:
            var(--promo-red);

        font-size: 24px;

        font-weight: 950;

        letter-spacing: -.3px;
    }


    .promo-original-price {
        color: #9b8d84;

        font-size: 13px;

        text-decoration:
            line-through;
    }




    .promo-saving {
        margin-bottom: 14px;

        padding: 9px 11px;

        border:
            1px solid
            #efd9aa;

        border-radius: 12px;

        color: #785520;

        background:
            linear-gradient(
                135deg,
                #fff9e5,
                #fff1cb
            );

        font-size: 12px;

        font-weight: 800;
    }


    .promo-time-box {
        margin-bottom: 16px;

        padding: 10px 12px;

        border:
            1px solid
            #e9dcc9;

        border-radius: 12px;

        background: #fffdf9;

        color: #77685e;

        font-size: 12px;

        line-height: 1.55;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .promo-actions {
        display: grid;

        grid-template-columns:
            1fr 1.2fr;

        gap: 9px;

        margin-top: auto;
    }


    .promo-actions .btn {
        min-height: 44px;

        border-radius: 12px;

        font-size: 13px;

        font-weight: 850;
    }


    .btn-promo-outline {
        border:
            1px solid
            #c8aa82;

        color:
            var(--promo-brown);

        background: #fff;
    }


    .btn-promo-outline:hover {
        border-color:
            var(--promo-brown);

        color: #fff;

        background:
            var(--promo-brown);
    }


    .btn-promo-main {
        border: 0;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #a83b2d,
                #5f341d 54%,
                #48633b
            );

        box-shadow:
            0 8px 18px
            rgba(95,52,29,.16);
    }


    .btn-promo-main:hover {
        color: #fff;

        transform:
            translateY(-1px);

        box-shadow:
            0 11px 22px
            rgba(95,52,29,.21);
    }


    .promo-admin-btn {
        border:
            1px solid
            #dfb55f;

        color: #684518;

        background: #fff7dc;
    }


    .promo-admin-btn:hover {
        color: #3e2910;

        background: #f5dd9e;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .promo-empty {
        padding: 64px 24px;

        border:
            1px dashed
            #dcbf96;

        border-radius: 24px;

        background:
            radial-gradient(
                circle at 80% 10%,
                rgba(242,193,92,.12),
                transparent 25%
            ),
            linear-gradient(
                180deg,
                #fffdf9,
                #fff8eb
            );

        text-align: center;

        box-shadow:
            0 14px 34px
            rgba(95,52,29,.055);
    }


    .promo-empty-icon {
        font-size: 68px;

        opacity: .72;
    }


    .promo-empty h3 {
        color:
            var(--promo-dark);

        font-weight: 950;
    }


    .promo-empty p {
        max-width: 580px;

        margin-left: auto;
        margin-right: auto;

        color: #7c6d63;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .promotions-page .pagination {
        justify-content: center;

        gap: 6px;

        margin-top: 30px;
    }


    .promotions-page .page-link {
        min-width: 42px;
        min-height: 42px;

        display: grid;

        place-items: center;

        border-radius:
            11px !important;

        border-color:
            #e2cdb0;

        color:
            var(--promo-brown);

        box-shadow:
            0 4px 10px
            rgba(95,52,29,.04);
    }


    .promotions-page
    .page-item.active
    .page-link {
        border-color:
            transparent;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #5f341d,
                #48633b
            );
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .promotions-page {
            width:
                calc(100% - 30px);
        }


        .promotions-hero {
            min-height: 0;

            padding:
                34px 30px;

            border-radius: 24px;
        }


        .promo-info-strip {
            grid-template-columns:
                1fr;
        }


        .promo-image-wrap {
            height: 220px;
        }
    }


    @media (max-width: 767.98px) {

        .promotions-page {
            width:
                calc(100% - 28px);

            padding-top: 22px;

            padding-bottom: 60px;
        }


        .promotions-page::after {
            display: none;
        }


        .promotions-hero {
            flex-direction: column;

            align-items: flex-start;

            padding:
                28px 22px;

            border-radius: 21px;
        }


        .promotions-hero-stat {
            width: 100%;
        }


        .promotions-section-head {
            align-items: flex-start;

            flex-direction: column;
        }
    }


    @media (max-width: 575.98px) {

        .promotions-page {
            width:
                calc(100% - 24px);

            padding-top: 18px;

            padding-bottom: 48px;
        }


        .promotions-hero {
            gap: 22px;

            padding:
                25px 19px;

            margin-bottom: 22px;

            border-radius: 19px;
        }


        .promotions-hero h1 {
            font-size: 34px;

            line-height: 1.08;
        }


        .promotions-hero p {
            font-size: 14px;
        }


        .promotions-hero::after {
            right: 5px;

            font-size: 90px;
        }


        .promo-info-strip {
            gap: 10px;

            margin-bottom: 25px;
        }


        .promo-info-item {
            padding: 14px 15px;
        }


        .promotions-section-head h2 {
            font-size: 25px;
        }


        .promo-image-wrap {
            height: 205px;
        }


        .promo-actions {
            grid-template-columns:
                1fr;
        }


        .promo-product-card:hover {
            transform: none;
        }
    }


    @media (prefers-reduced-motion: reduce) {

        .promotions-page *,
        .promotions-page *::before,
        .promotions-page *::after {
            transition:
                none !important;

            animation:
                none !important;
        }
    }
</style>


<div class="promotions-page">


    {{-- =====================================================
        HERO
    ====================================================== --}}

    <section class="promotions-hero">

        <div>

            <div class="promotions-kicker">
                🔥 ƯU ĐÃI ĐANG DIỄN RA
            </div>


            <h1>
                Săn đặc sản Tây Bắc với giá ưu đãi
            </h1>


            <p>
                Những sản phẩm đang có giá khuyến mãi hợp lệ
                được hệ thống tự động tổng hợp tại đây.
                Giá sale chỉ hiển thị khi đang trong thời gian áp dụng.
            </p>

        </div>


        <div class="promotions-hero-stat">

            <strong>
                {{ $products->total() }}
            </strong>

            <span>
                Sản phẩm đang sale
            </span>

        </div>

    </section>


    {{-- =====================================================
        INFO STRIP
    ====================================================== --}}

    <div class="promo-info-strip">

        <div class="promo-info-item">

            <div class="promo-info-icon">
                💸
            </div>

            <div>

                <strong>
                    Giá sale thực tế
                </strong>

                <small>
                    Hiển thị trực tiếp mức giá đang được áp dụng.
                </small>

            </div>

        </div>


        <div class="promo-info-item">

            <div class="promo-info-icon">
                ⏱️
            </div>

            <div>

                <strong>
                    Đúng thời gian ưu đãi
                </strong>

                <small>
                    Chỉ những chương trình còn hiệu lực mới xuất hiện.
                </small>

            </div>

        </div>


        <div class="promo-info-item">

            <div class="promo-info-icon">
                🌿
            </div>

            <div>

                <strong>
                    Đặc sản Tây Bắc
                </strong>

                <small>
                    Lựa chọn sản phẩm theo đúng danh mục của cửa hàng.
                </small>

            </div>

        </div>

    </div>


    {{-- =====================================================
        SECTION HEADING
    ====================================================== --}}

    <div class="promotions-section-head">

        <div>

            <h2>
                🔥 Sản phẩm đang khuyến mãi
            </h2>

            <p>
                Chọn sản phẩm để xem chi tiết
                hoặc thêm nhanh vào giỏ hàng.
            </p>

        </div>


        <a
            href="{{ route('products.index') }}"
            class="btn btn-promo-outline rounded-pill px-3"
        >
            Xem tất cả sản phẩm →
        </a>

    </div>


    {{-- =====================================================
        PRODUCTS
    ====================================================== --}}

    @if($products->count() > 0)


        <div class="row g-4">


            @foreach($products as $product)


                @php

                    $discountPercent = 0;


                    if (
                        (float) $product->price > 0
                        &&
                        (float) $product->sale_price
                        <
                        (float) $product->price
                    ) {

                        $discountPercent =
                            (int) round(
                                (
                                    (
                                        (float) $product->price
                                        -
                                        (float) $product->sale_price
                                    )
                                    /
                                    (float) $product->price
                                )
                                *
                                100
                            );

                    }


                    $savingAmount =
                        max(
                            0,
                            (float) $product->price
                            -
                            (float) $product->sale_price
                        );


                    $imageUrl = null;


                    if ($product->image) {

                        $imageUrl =
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
                            );

                    }

                @endphp


                <div class="col-xl-3 col-lg-4 col-md-6">

                    <article class="promo-product-card">


                        {{-- IMAGE --}}
                        <div class="promo-image-wrap">


                            @if($discountPercent > 0)

                                <span class="promo-sale-badge">
                                    🏷️ -{{ $discountPercent }}%
                                </span>

                            @endif


                            <span
                                class="
                                    promo-stock-badge
                                    {{
                                        $product->quantity > 0
                                        ? 'in-stock'
                                        : 'out-stock'
                                    }}
                                "
                            >

                                {{
                                    $product->quantity > 0
                                    ? '✅ Còn hàng'
                                    : '❌ Hết hàng'
                                }}

                            </span>


                            @if($imageUrl)

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="promo-placeholder">
                                    🧺
                                </div>

                            @endif

                        </div>


                        {{-- BODY --}}
                        <div class="promo-card-body">


                            <div class="promo-category">

                                🌿 {{
                                    $product->category->name
                                    ??
                                    'Chưa phân loại'
                                }}

                            </div>


                            <h3 class="promo-name">
                                {{ $product->name }}
                            </h3>


                            @if($product->description)

                                <div class="promo-description">
                                    {{ $product->description }}
                                </div>

                            @endif


                            {{-- PRICE --}}
                            <div class="promo-price-row">

                                <div class="promo-sale-price">

                                    {{
                                        number_format(
                                            (float) $product->sale_price,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ/{{ $product->unit ?: 'sản phẩm' }}

                                </div>


                                <div class="promo-original-price">

                                    {{
                                        number_format(
                                            (float) $product->price,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ/{{ $product->unit ?: 'sản phẩm' }}

                                </div>



                            </div>


                            {{-- SAVING --}}
                            @if($savingAmount > 0)

                                <div class="promo-saving">

                                    💸 Tiết kiệm

                                    {{
                                        number_format(
                                            $savingAmount,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ/{{ $product->unit ?: 'sản phẩm' }}

                                </div>

                            @endif


                            {{-- SALE TIME --}}
                            <div class="promo-time-box">

                                <div>

                                    🕒
                                    <strong>
                                        Bắt đầu:
                                    </strong>

                                    {{
                                        $product->sale_start

                                        ? $product
                                            ->sale_start
                                            ->format(
                                                'd/m/Y H:i'
                                            )

                                        : 'Có hiệu lực ngay'
                                    }}

                                </div>


                                <div class="mt-1">

                                    ⏰
                                    <strong>
                                        Kết thúc:
                                    </strong>

                                    {{
                                        $product->sale_end

                                        ? $product
                                            ->sale_end
                                            ->format(
                                                'd/m/Y H:i'
                                            )

                                        : 'Không giới hạn'
                                    }}

                                </div>

                            </div>


                            {{-- ACTIONS --}}
                            <div class="promo-actions">


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="btn btn-promo-outline"
                                >
                                    👁 Chi tiết
                                </a>


                                @if(
                                    Auth::check()
                                    &&
                                    Auth::user()->role === 'admin'
                                )


                                    <a
                                        href="{{
                                            route(
                                                'admin.products.edit',
                                                $product
                                            )
                                        }}"
                                        class="btn promo-admin-btn"
                                    >
                                        ✏️ Sửa sản phẩm
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
                                            class="btn btn-promo-main w-100"
                                            {{
                                                $product->quantity <= 0
                                                ? 'disabled'
                                                : ''
                                            }}
                                        >

                                            {{
                                                $product->quantity > 0

                                                ? '🛒 Thêm vào giỏ'

                                                : '❌ Hết hàng'
                                            }}

                                        </button>

                                    </form>


                                @else


                                    <a
                                        href="{{ route('login') }}"
                                        class="btn btn-promo-main"
                                    >
                                        🔐 Đăng nhập để mua
                                    </a>


                                @endif

                            </div>

                        </div>

                    </article>

                </div>


            @endforeach

        </div>


        <div class="mt-4">
            {{ $products->links() }}
        </div>


    @else


        {{-- =====================================================
            EMPTY
        ====================================================== --}}

        <div class="promo-empty">

            <div class="promo-empty-icon">
                🏷️
            </div>


            <h3 class="mt-3 mb-2">
                Hiện chưa có sản phẩm khuyến mãi
            </h3>


            <p class="mb-4">

                Các ưu đãi đang còn hiệu lực
                sẽ tự động xuất hiện tại đây
                khi cửa hàng thiết lập giá sale
                cho sản phẩm.

            </p>


            <a
                href="{{ route('products.index') }}"
                class="btn btn-promo-main px-4"
            >
                🛍 Xem sản phẩm
            </a>

        </div>


    @endif

</div>

@endsection
