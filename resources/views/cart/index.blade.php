@extends('layouts.app')

@section('title', 'Giỏ hàng | Tinh Hoa Tây Bắc')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DỮ LIỆU GIỎ HÀNG
    |--------------------------------------------------------------------------
    */

    $cartIds = array_keys($cart);

    $cartProducts = empty($cartIds)
        ? collect()
        : \App\Models\Product::query()
            ->whereIn('id', $cartIds)
            ->get()
            ->keyBy('id');


    $cartTotal = 0;

    $cartQuantityTotal = 0;


    foreach ($cart as $cartId => $cartDetails) {
        $itemPrice =
            (float) ($cartDetails['price'] ?? 0);

        $itemQuantity =
            (float) ($cartDetails['quantity'] ?? 0);

        $cartTotal +=
            $itemPrice * $itemQuantity;

        $cartQuantityTotal +=
            $itemQuantity;
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT SỐ LƯỢNG
    |--------------------------------------------------------------------------
    */

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
       ECOMMERCE CART - TINH HOA TAY BAC
    ========================================================= */

    .tb-cart {
        --cart-green: #35562f;
        --cart-green-dark: #274522;

        --cart-brown: #633820;
        --cart-brown-dark: #3d2316;

        --cart-red: #b43e2e;
        --cart-red-dark: #8c2f24;

        --cart-gold: #e4ac42;
        --cart-gold-light: #fff0c8;

        --cart-border: #e8dfd4;

        --cart-text: #302923;
        --cart-muted: #766d66;

        --cart-shadow:
            0 8px 28px
            rgba(55, 39, 27, .07);

        --cart-shadow-hover:
            0 17px 38px
            rgba(55, 39, 27, .12);

        color: var(--cart-text);
    }


    .tb-cart *,
    .tb-cart *::before,
    .tb-cart *::after {
        box-sizing: border-box;
    }


    .tb-cart a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .tb-cart-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958a82;

        font-size: 10px;
    }


    .tb-cart-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .tb-cart-breadcrumb a:hover {
        color: var(--cart-red);
    }


    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .tb-cart-heading {
        position: relative;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 24px;

        margin-bottom: 20px;

        padding:
            23px 27px;

        border:
            1px solid #e2d4c2;

        border-radius: 18px;

        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(228,172,66,.17),
                transparent 28%
            ),
            linear-gradient(
                120deg,
                #fffdf8,
                #fff7ea 58%,
                #f0f5ed
            );

        box-shadow:
            var(--cart-shadow);
    }


    .tb-cart-heading::after {
        content: "";

        position: absolute;

        right: -30px;
        bottom: -55px;

        width: 260px;
        height: 150px;

        opacity: .075;

        background:
            var(--cart-green);

        clip-path:
            polygon(
                0 100%,
                21% 50%,
                38% 71%,
                57% 24%,
                76% 61%,
                100% 13%,
                100% 100%
            );
    }


    .tb-cart-heading-copy {
        position: relative;

        z-index: 2;
    }


    .tb-cart-eyebrow {
        margin-bottom: 5px;

        color: var(--cart-red);

        font-size: 9px;

        font-weight: 950;

        letter-spacing: .1em;

        text-transform: uppercase;
    }


    .tb-cart-title {
        margin: 0;

        color: var(--cart-text);

        font-size:
            clamp(27px, 3vw, 38px);

        line-height: 1.1;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .tb-cart-description {
        margin-top: 7px;

        color: var(--cart-muted);

        font-size: 11px;

        line-height: 1.6;
    }


    .tb-cart-heading-stat {
        position: relative;

        z-index: 2;

        min-width: 140px;

        padding:
            12px 15px;

        border:
            1px solid #e5ca96;

        border-radius: 13px;

        background:
            rgba(255,255,255,.86);

        text-align: center;
    }


    .tb-cart-heading-stat strong {
        display: block;

        color: var(--cart-brown-dark);

        font-size: 21px;

        font-weight: 950;
    }


    .tb-cart-heading-stat span {
        color: var(--cart-muted);

        font-size: 9px;
    }


    /* =========================================================
       LAYOUT
    ========================================================= */

    .tb-cart-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            355px;

        gap: 20px;

        align-items: start;
    }


    .tb-cart-main {
        min-width: 0;
    }


    /* =========================================================
       CART TOP
    ========================================================= */

    .tb-cart-list-head {
        min-height: 54px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 11px;

        padding:
            10px 14px;

        border:
            1px solid var(--cart-border);

        border-radius: 13px;

        background: #fff;

        box-shadow:
            var(--cart-shadow);
    }


    .tb-cart-list-head strong {
        color: #473a32;

        font-size: 12px;

        font-weight: 950;
    }


    .tb-cart-continue {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        color: var(--cart-green);

        font-size: 10px;

        font-weight: 900;
    }


    .tb-cart-continue:hover {
        color: var(--cart-red);
    }


    /* =========================================================
       ITEM CARD
    ========================================================= */

    .tb-cart-items {
        display: grid;

        gap: 11px;
    }


    .tb-cart-item {
        position: relative;

        overflow: hidden;

        display: grid;

        grid-template-columns:
            125px
            minmax(0, 1fr);

        gap: 15px;

        padding: 14px;

        border:
            1px solid var(--cart-border);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            var(--cart-shadow);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }


    .tb-cart-item:hover {
        border-color: #dcc5a7;

        transform:
            translateY(-2px);

        box-shadow:
            var(--cart-shadow-hover);
    }


    /* =========================================================
       ITEM IMAGE
    ========================================================= */

    .tb-cart-media {
        position: relative;

        width: 125px;
        height: 125px;

        overflow: hidden;

        border:
            1px solid #ece3d9;

        border-radius: 12px;

        background:
            linear-gradient(
                145deg,
                #fbfaf7,
                #fff5e5
            );
    }


    .tb-cart-media a {
        width: 100%;
        height: 100%;

        display: block;
    }


    .tb-cart-media img {
        width: 100%;
        height: 100%;

        padding: 7px;

        object-fit: contain;

        transition:
            transform .2s ease;
    }


    .tb-cart-item:hover
    .tb-cart-media img {
        transform:
            scale(1.045);
    }


    .tb-cart-no-image {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #97887c;

        font-size: 36px;
    }


    .tb-cart-sale {
        position: absolute;

        z-index: 3;

        top: 6px;
        left: 6px;

        padding:
            4px 6px;

        border-radius: 6px;

        color: #fff;

        background:
            var(--cart-red);

        font-size: 8px;

        font-weight: 950;
    }


    /* =========================================================
       ITEM INFORMATION
    ========================================================= */

    .tb-cart-content {
        min-width: 0;

        display: flex;
        flex-direction: column;
    }


    .tb-cart-item-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 15px;
    }


    .tb-cart-product-info {
        min-width: 0;
    }


    .tb-cart-category {
        display: inline-flex;

        margin-bottom: 5px;

        padding:
            4px 7px;

        border:
            1px solid #ead7bc;

        border-radius: 999px;

        color: #705038;

        background: #fff8e8;

        font-size: 8px;

        font-weight: 850;
    }


    .tb-cart-product-name {
        display: block;

        overflow: hidden;

        color: #302923;

        font-size: 14px;

        line-height: 1.4;

        font-weight: 950;

        white-space: nowrap;

        text-overflow: ellipsis;
    }


    .tb-cart-product-name:hover {
        color: var(--cart-red);
    }


    .tb-cart-unit {
        margin-top: 4px;

        color: #8d8178;

        font-size: 9px;
    }


    .tb-cart-remove {
        flex: 0 0 auto;

        border: 0;

        color: #a34a40;

        background: transparent;

        font-size: 9px;

        font-weight: 850;

        cursor: pointer;
    }


    .tb-cart-remove:hover {
        color: #d02e24;
    }


    /* =========================================================
       PRICE ROW
    ========================================================= */

    .tb-cart-price-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 12px;

        margin-top: auto;

        padding-top: 11px;
    }


    .tb-cart-unit-price-label {
        margin-bottom: 2px;

        color: #978b83;

        font-size: 8px;
    }


    .tb-cart-unit-price {
        color: #6a5141;

        font-size: 12px;

        font-weight: 850;
    }


    .tb-cart-current-price {
        color: var(--cart-red);

        font-size: 16px;

        font-weight: 950;
    }


    .tb-cart-old-price {
        margin-left: 5px;

        color: #aaa09a;

        font-size: 9px;

        text-decoration:
            line-through;
    }


    /* =========================================================
       QUANTITY
    ========================================================= */

    .tb-cart-controls {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .tb-cart-qty-form {
        display: flex;
        align-items: center;

        gap: 7px;
    }


    .tb-cart-qty-control {
        display: flex;

        overflow: hidden;

        height: 38px;

        border:
            1px solid #ddd0c0;

        border-radius: 9px;

        background: #fff;
    }


    .tb-cart-qty-button {
        width: 34px;

        flex: 0 0 34px;

        border: 0;

        color: var(--cart-brown);

        background: #faf5ee;

        font-size: 16px;

        font-weight: 900;

        cursor: pointer;
    }


    .tb-cart-qty-button:hover {
        color: #fff;

        background:
            var(--cart-brown);
    }


    .tb-cart-qty-input {
        width: 68px;

        border: 0;

        border-left:
            1px solid #e6dbcf;

        border-right:
            1px solid #e6dbcf;

        outline: 0;

        color: #41362e;

        background: #fff;

        text-align: center;

        font-size: 10px;

        font-weight: 900;

        -moz-appearance:
            textfield;
    }


    .tb-cart-qty-input::-webkit-inner-spin-button,
    .tb-cart-qty-input::-webkit-outer-spin-button {
        margin: 0;

        -webkit-appearance: none;
    }


    .tb-cart-update {
        height: 38px;

        padding:
            0 10px;

        border:
            1px solid #c4d0bd;

        border-radius: 9px;

        color:
            var(--cart-green-dark);

        background:
            #f1f7ee;

        font-size: 8px;

        font-weight: 900;

        cursor: pointer;
    }


    .tb-cart-update:hover {
        color: #fff;

        border-color:
            var(--cart-green);

        background:
            var(--cart-green);
    }


    .tb-cart-step {
        margin-top: 4px;

        color: #978b82;

        font-size: 8px;
    }


    /* =========================================================
       SUBTOTAL
    ========================================================= */

    .tb-cart-subtotal {
        min-width: 130px;

        text-align: right;
    }


    .tb-cart-subtotal-label {
        color: #93877f;

        font-size: 8px;
    }


    .tb-cart-subtotal-price {
        margin-top: 2px;

        color: var(--cart-red);

        font-size: 17px;

        font-weight: 950;

        letter-spacing: -.02em;
    }


    /* =========================================================
       SUMMARY
    ========================================================= */

    .tb-cart-summary {
        position: sticky;

        top: 177px;

        overflow: hidden;

        border:
            1px solid var(--cart-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--cart-shadow);
    }


    .tb-cart-summary-head {
        padding:
            16px 17px;

        border-bottom:
            1px solid var(--cart-border);

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--cart-brown-dark),
                var(--cart-brown)
            );
    }


    .tb-cart-summary-head strong {
        display: block;

        font-size: 14px;

        font-weight: 950;
    }


    .tb-cart-summary-head span {
        display: block;

        margin-top: 2px;

        color:
            rgba(255,255,255,.67);

        font-size: 9px;
    }


    .tb-cart-summary-body {
        padding: 17px;
    }


    .tb-cart-summary-line {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 13px;

        color: #756a62;

        font-size: 10px;
    }


    .tb-cart-summary-line strong {
        color: #453a32;

        font-size: 11px;
    }


    .tb-cart-summary-note {
        color: #988d84;

        font-size: 9px;

        text-align: right;
    }


    .tb-cart-summary-divider {
        height: 1px;

        margin:
            16px 0;

        background:
            #ebe2d8;
    }


    .tb-cart-summary-total {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 12px;
    }


    .tb-cart-total-title {
        color: #43372f;

        font-size: 13px;

        font-weight: 950;
    }


    .tb-cart-total-note {
        margin-top: 2px;

        color: #958981;

        font-size: 8px;
    }


    .tb-cart-total-price {
        color: var(--cart-red);

        font-size: 23px;

        line-height: 1;

        font-weight: 950;

        letter-spacing: -.035em;

        text-align: right;
    }


    /* =========================================================
       CHECKOUT BUTTON
    ========================================================= */

    .tb-cart-checkout {
        min-height: 49px;

        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        margin-top: 18px;

        border-radius: 11px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--cart-red),
                var(--cart-red-dark)
            );

        box-shadow:
            0 9px 21px
            rgba(180,62,46,.2);

        font-size: 11px;

        font-weight: 950;

        transition:
            transform .17s ease,
            box-shadow .17s ease;
    }


    .tb-cart-checkout:hover {
        color: #fff;

        transform:
            translateY(-2px);

        box-shadow:
            0 13px 27px
            rgba(180,62,46,.27);
    }


    /* =========================================================
       SAFE BUY
    ========================================================= */

    .tb-cart-security {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 7px;

        margin-top: 12px;
    }


    .tb-cart-security-item {
        min-height: 54px;

        padding:
            9px;

        border:
            1px solid #eee4da;

        border-radius: 9px;

        color: #6a594d;

        background: #fdfbf8;

        font-size: 8px;

        line-height: 1.45;
    }


    .tb-cart-security-item strong {
        display: block;

        margin-bottom: 2px;

        color: #4e4037;

        font-size: 9px;
    }


    /* =========================================================
       CUSTOMER HELP
    ========================================================= */

    .tb-cart-help {
        margin-top: 12px;

        padding:
            12px;

        border:
            1px solid #ecd9af;

        border-radius: 10px;

        background:
            #fff9e9;

        color: #67513a;

        font-size: 9px;

        line-height: 1.55;
    }


    .tb-cart-help a {
        color: var(--cart-red);

        font-weight: 900;
    }


    /* =========================================================
       EMPTY CART
    ========================================================= */

    .tb-cart-empty {
        min-height: 470px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            50px 20px;

        overflow: hidden;

        border:
            1px dashed #ddc7aa;

        border-radius: 20px;

        background:
            radial-gradient(
                circle at 50% 0%,
                rgba(228,172,66,.16),
                transparent 32%
            ),
            linear-gradient(
                180deg,
                #fffdf9,
                #fff9ef
            );

        box-shadow:
            var(--cart-shadow);

        text-align: center;
    }


    .tb-cart-empty-icon {
        width: 94px;
        height: 94px;

        display: grid;
        place-items: center;

        margin:
            0 auto 15px;

        border:
            1px solid #e3c895;

        border-radius: 50%;

        background:
            #fff0ca;

        font-size: 41px;
    }


    .tb-cart-empty h2 {
        margin: 0;

        color: var(--cart-text);

        font-size: 24px;

        font-weight: 950;
    }


    .tb-cart-empty p {
        max-width: 420px;

        margin:
            8px auto 20px;

        color: var(--cart-muted);

        font-size: 11px;

        line-height: 1.6;
    }


    .tb-cart-empty-btn {
        min-height: 45px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 18px;

        border-radius: 10px;

        color: #fff;

        background:
            var(--cart-green);

        font-size: 10px;

        font-weight: 950;
    }


    .tb-cart-empty-btn:hover {
        color: #fff;

        background:
            var(--cart-green-dark);
    }


    /* =========================================================
       MOBILE ITEM SUMMARY
    ========================================================= */

    .tb-cart-mobile-summary {
        display: none;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .tb-cart-layout {
            grid-template-columns:
                minmax(0, 1fr)
                315px;
        }


        .tb-cart-subtotal {
            min-width: 110px;
        }

    }


    @media (max-width: 991.98px) {

        .tb-cart-layout {
            grid-template-columns: 1fr;
        }


        .tb-cart-summary {
            position: static;
        }

    }


    @media (max-width: 767.98px) {

        .tb-cart-heading {
            align-items: flex-start;

            flex-direction: column;

            gap: 13px;

            padding:
                20px;
        }


        .tb-cart-heading-stat {
            min-width: 115px;

            text-align: left;
        }


        .tb-cart-item {
            grid-template-columns:
                105px
                minmax(0, 1fr);
        }


        .tb-cart-media {
            width: 105px;
            height: 105px;
        }


        .tb-cart-price-row {
            align-items: flex-start;

            flex-direction: column;
        }


        .tb-cart-subtotal {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            text-align: left;
        }

    }


    @media (max-width: 575.98px) {

        .tb-cart-list-head {
            align-items: flex-start;

            flex-direction: column;
        }


        .tb-cart-item {
            grid-template-columns:
                88px
                minmax(0, 1fr);

            gap: 10px;

            padding: 10px;
        }


        .tb-cart-media {
            width: 88px;
            height: 88px;
        }


        .tb-cart-product-name {
            font-size: 12px;
        }


        .tb-cart-item-top {
            gap: 5px;
        }


        .tb-cart-price-row {
            grid-column:
                1 / -1;
        }


        .tb-cart-controls {
            width: 100%;

            align-items: stretch;

            flex-direction: column;
        }


        .tb-cart-qty-form {
            width: 100%;
        }


        .tb-cart-qty-control {
            flex: 1;
        }


        .tb-cart-qty-input {
            flex: 1;

            width: auto;
        }


        .tb-cart-update {
            flex: 0 0 auto;
        }


        .tb-cart-security {
            grid-template-columns: 1fr;
        }


        .tb-cart-total-price {
            font-size: 20px;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-cart *,
        .tb-cart *::before,
        .tb-cart *::after {
            transition: none !important;
        }

    }
</style>


<div class="tb-cart">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="tb-cart-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <a href="{{ route('products.index') }}">
            Sản phẩm
        </a>

        <span>›</span>

        <span>
            Giỏ hàng
        </span>

    </div>


    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <section class="tb-cart-heading">

        <div class="tb-cart-heading-copy">

            <div class="tb-cart-eyebrow">
                • Giỏ hàng của bạn
            </div>


            <h1 class="tb-cart-title">
                Kiểm tra sản phẩm trước khi đặt hàng
            </h1>


            <div class="tb-cart-description">

                Điều chỉnh số lượng,
                kiểm tra giá bán
                và sản phẩm trước khi chuyển sang bước thanh toán.

            </div>

        </div>


        @if(count($cart) > 0)

            <div class="tb-cart-heading-stat">

                <strong>
                    {{ count($cart) }}
                </strong>

                <span>
                    loại sản phẩm trong giỏ
                </span>

            </div>

        @endif

    </section>


    {{-- =====================================================
        CART HAS ITEMS
    ====================================================== --}}
    @if(count($cart) > 0)

        <div class="tb-cart-layout">


            {{-- =================================================
                CART ITEMS
            ================================================== --}}
            <div class="tb-cart-main">


                <div class="tb-cart-list-head">

                    <strong>
                        Sản phẩm đã chọn
                    </strong>


                    <a
                        href="{{ route('products.index') }}"
                        class="tb-cart-continue"
                    >
                        ← Tiếp tục mua sắm
                    </a>

                </div>


                <div class="tb-cart-items">


                    @foreach($cart as $id => $details)

                        @php
                            $price =
                                (float) (
                                    $details['price']
                                    ??
                                    0
                                );


                            $quantity =
                                (float) (
                                    $details['quantity']
                                    ??
                                    0
                                );


                            $unit =
                                $details['unit']
                                ??
                                'sản phẩm';


                            $product =
                                $cartProducts->get(
                                    (int) $id
                                );


                            $minQty = $product
                                ? $product->minimumOrderQuantity()
                                : (float) ($details['min_quantity'] ?? 1);


                            $stepQty = $product
                                ? $product->orderQuantityStep()
                                : (float) ($details['quantity_step'] ?? 1);


                            $subtotal =
                                $price
                                *
                                $quantity;


                            $displayQty =
                                $formatQuantity(
                                    $quantity
                                );


                            $displayMinQty =
                                $formatQuantity(
                                    $minQty
                                );


                            $displayStepQty =
                                $formatQuantity(
                                    $stepQty
                                );


                            $productUrl =
                                $product

                                ? route(
                                    'products.show',
                                    $product
                                )

                                : route(
                                    'products.index'
                                );


                            $productImage =
                                null;


                            if (
                                $product
                                &&
                                $product->image
                            ) {

                                $productImage =
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


                        <article class="tb-cart-item">


                            {{-- =========================================
                                IMAGE
                            ========================================== --}}
                            <div class="tb-cart-media">


                                @if(
                                    $product
                                    &&
                                    $product->isOnSale()
                                )

                                    <span class="tb-cart-sale">

                                        -{{
                                            $product
                                                ->getDiscountPercent()
                                        }}%

                                    </span>

                                @endif


                                <a href="{{ $productUrl }}">

                                    @if($productImage)

                                        <img
                                            src="{{ $productImage }}"
                                            alt="{{
                                                $details['name']
                                                ??
                                                'Sản phẩm'
                                            }}"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='grid';
                                            "
                                        >


                                        <div
                                            class="tb-cart-no-image"
                                            style="display:none;"
                                        >
                                            •
                                        </div>

                                    @else

                                        <div class="tb-cart-no-image">
                                            •
                                        </div>

                                    @endif

                                </a>

                            </div>


                            {{-- =========================================
                                CONTENT
                            ========================================== --}}
                            <div class="tb-cart-content">


                                <div class="tb-cart-item-top">


                                    <div class="tb-cart-product-info">


                                        <span class="tb-cart-category">

                                            {{
                                                $details['category']
                                                ??
                                                'Đặc sản Tây Bắc'
                                            }}

                                        </span>


                                        <a
                                            href="{{ $productUrl }}"
                                            class="tb-cart-product-name"
                                        >
                                            {{
                                                $details['name']
                                                ??
                                                'Sản phẩm'
                                            }}
                                        </a>


                                        <div class="tb-cart-unit">

                                            Bán theo
                                            <strong>
                                                {{ $unit }}
                                            </strong>

                                            · Tối thiểu

                                            <strong>
                                                {{ $displayMinQty }}
                                                {{ $unit }}
                                            </strong>

                                        </div>

                                    </div>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{
                                            route(
                                                'cart.destroy',
                                                [
                                                    'product'
                                                    =>
                                                    $id
                                                ]
                                            )
                                        }}"
                                        method="POST"
                                        onsubmit="
                                            return confirm(
                                                'Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?'
                                            );
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="tb-cart-remove"
                                            title="Xóa khỏi giỏ"
                                        >
                                            • Xóa
                                        </button>

                                    </form>

                                </div>


                                {{-- =====================================
                                    PRICE / QUANTITY / SUBTOTAL
                                ====================================== --}}
                                <div class="tb-cart-price-row">


                                    {{-- PRICE --}}
                                    <div>

                                        <div class="tb-cart-unit-price-label">
                                            Đơn giá
                                        </div>


                                        <div>

                                            <span class="tb-cart-current-price">

                                                {{
                                                    number_format(
                                                        $price,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}đ

                                            </span>


                                            <span class="tb-cart-unit-price">
                                                / {{ $unit }}
                                            </span>


                                            @if(
                                                $product
                                                &&
                                                $product->isOnSale()
                                            )

                                                <span class="tb-cart-old-price">

                                                    {{
                                                        number_format(
                                                            (float)
                                                            $product->price,
                                                            0,
                                                            ',',
                                                            '.'
                                                        )
                                                    }}đ

                                                </span>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- QUANTITY --}}
                                    <div class="tb-cart-controls">

                                        <div>

                                            <form
                                                action="{{
                                                    route(
                                                        'cart.update',
                                                        [
                                                            'id'
                                                            =>
                                                            $id
                                                        ]
                                                    )
                                                }}"
                                                method="POST"
                                                class="tb-cart-qty-form"
                                                data-cart-quantity-form
                                            >

                                                @csrf
                                                @method('PATCH')


                                                <div class="tb-cart-qty-control">

                                                    <button
                                                        type="button"
                                                        class="tb-cart-qty-button"
                                                        data-cart-minus
                                                        aria-label="Giảm số lượng"
                                                    >
                                                        −
                                                    </button>


                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        value="{{ $displayQty }}"
                                                        min="{{ $displayMinQty }}"
                                                        step="{{ $displayStepQty }}"
                                                        @if($product)
                                                            max="{{ $product->quantity }}"
                                                        @endif
                                                        class="tb-cart-qty-input"
                                                        data-cart-qty
                                                        required
                                                    >


                                                    <button
                                                        type="button"
                                                        class="tb-cart-qty-button"
                                                        data-cart-plus
                                                        aria-label="Tăng số lượng"
                                                    >
                                                        +
                                                    </button>

                                                </div>


                                                <button
                                                    type="submit"
                                                    class="tb-cart-update"
                                                >
                                                    Cập nhật
                                                </button>

                                            </form>


                                            <div class="tb-cart-step">

                                                Tối thiểu:
                                                {{ $displayMinQty }}
                                                {{ $unit }}
                                                · Bước tăng:
                                                {{ $displayStepQty }}
                                                {{ $unit }}

                                                @if($product)

                                                    · Còn
                                                    {{
                                                        $formatQuantity(
                                                            $product->quantity
                                                        )
                                                    }}
                                                    {{ $unit }}

                                                @endif

                                            </div>

                                        </div>

                                    </div>


                                    {{-- SUBTOTAL --}}
                                    <div class="tb-cart-subtotal">

                                        <div class="tb-cart-subtotal-label">
                                            Thành tiền
                                        </div>


                                        <div class="tb-cart-subtotal-price">

                                            {{
                                                number_format(
                                                    $subtotal,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}đ

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>


            {{-- =================================================
                ORDER SUMMARY
            ================================================== --}}
            <aside class="tb-cart-summary">

                <div class="tb-cart-summary-head">

                    <strong>
                        • Tóm tắt đơn hàng
                    </strong>

                    <span>
                        Kiểm tra trước khi thanh toán
                    </span>

                </div>


                <div class="tb-cart-summary-body">


                    <div class="tb-cart-summary-line">

                        <span>
                            Sản phẩm
                        </span>

                        <strong>
                            {{ count($cart) }}
                            loại
                        </strong>

                    </div>


                    <div class="tb-cart-summary-line">

                        <span>
                            Tổng tiền sản phẩm
                        </span>

                        <strong>

                            {{
                                number_format(
                                    $cartTotal,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    <div class="tb-cart-summary-line">

                        <span>
                            Phí vận chuyển
                        </span>

                        <span class="tb-cart-summary-note">
                            Chọn ở bước thanh toán
                        </span>

                    </div>


                    <div class="tb-cart-summary-line">

                        <span>
                            Voucher
                        </span>

                        <span class="tb-cart-summary-note">
                            Áp dụng ở bước thanh toán
                        </span>

                    </div>


                    <div class="tb-cart-summary-divider">
                    </div>


                    <div class="tb-cart-summary-total">

                        <div>

                            <div class="tb-cart-total-title">
                                Tạm tính
                            </div>

                            <div class="tb-cart-total-note">
                                Chưa gồm vận chuyển &amp; ưu đãi
                            </div>

                        </div>


                        <div class="tb-cart-total-price">

                            {{
                                number_format(
                                    $cartTotal,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </div>

                    </div>


                    <a
                        href="{{ route('checkout') }}"
                        class="tb-cart-checkout"
                    >
                        Tiến hành thanh toán
                        →
                    </a>


                    {{-- TRUST --}}
                    <div class="tb-cart-security">

                        <div class="tb-cart-security-item">

                            <strong>
                                • Đặt hàng an toàn
                            </strong>

                            Thông tin đơn hàng
                            được bảo vệ.

                        </div>


                        <div class="tb-cart-security-item">

                            <strong>
                                • Thanh toán
                            </strong>

                            COD hoặc
                            chuyển khoản ngân hàng.

                        </div>


                        <div class="tb-cart-security-item">

                            <strong>
                                • Vận chuyển
                            </strong>

                            Lựa chọn phương thức
                            ở bước tiếp theo.

                        </div>


                        <div class="tb-cart-security-item">

                            <strong>
                                • Theo dõi đơn
                            </strong>

                            Kiểm tra trạng thái
                            sau khi đặt hàng.

                        </div>

                    </div>


                    <div class="tb-cart-help">

                        <strong>
                            Cần hỗ trợ?
                        </strong>

                        Liên hệ

                        <a href="tel:0385742505">
                            0385 742 505
                        </a>

                        hoặc Zalo để được hỗ trợ đặt hàng.

                    </div>

                </div>

            </aside>

        </div>


    {{-- =====================================================
        EMPTY CART
    ====================================================== --}}
    @else

        <div class="tb-cart-empty">

            <div>

                <div class="tb-cart-empty-icon">
                    •
                </div>


                <h2>
                    Giỏ hàng của bạn đang trống
                </h2>


                <p>

                    Bạn chưa chọn sản phẩm nào.
                    Hãy khám phá những đặc sản Tây Bắc
                    và thêm món bạn yêu thích vào giỏ hàng.

                </p>


                <a
                    href="{{ route('products.index') }}"
                    class="tb-cart-empty-btn"
                >
                    • Khám phá sản phẩm →
                </a>

            </div>

        </div>

    @endif

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | QUANTITY BUTTONS
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '[data-cart-quantity-form]'
            )
            .forEach(
                function (form) {

                    const input =
                        form.querySelector(
                            '[data-cart-qty]'
                        );


                    const minus =
                        form.querySelector(
                            '[data-cart-minus]'
                        );


                    const plus =
                        form.querySelector(
                            '[data-cart-plus]'
                        );


                    if (
                        !input
                        ||
                        !minus
                        ||
                        !plus
                    ) {
                        return;
                    }


                    const min =
                        Number(
                            input.min
                            ||
                            0.01
                        );


                    const step =
                        Number(
                            input.step
                            ||
                            1
                        );


                    const max =
                        input.max !== ''
                        ? Number(
                            input.max
                        )
                        : Infinity;


                    const precision =
                        function () {

                            const stringStep =
                                String(step);


                            if (
                                !stringStep.includes(
                                    '.'
                                )
                            ) {
                                return 0;
                            }


                            return stringStep
                                .split('.')[1]
                                .length;

                        };


                    const decimals =
                        Math.min(
                            4,
                            precision()
                        );


                    const normalize =
                        function (value) {

                            let result =
                                Number(value);


                            if (
                                !Number.isFinite(
                                    result
                                )
                            ) {
                                result = min;
                            }


                            result =
                                Math.max(
                                    min,
                                    Math.min(
                                        max,
                                        result
                                    )
                                );


                            const steps =
                                Math.round(
                                    (
                                        result
                                        -
                                        min
                                    )
                                    /
                                    step
                                );


                            result =
                                min
                                +
                                (
                                    steps
                                    *
                                    step
                                );


                            result =
                                Math.max(
                                    min,
                                    Math.min(
                                        max,
                                        result
                                    )
                                );


                            return Number(
                                result.toFixed(
                                    Math.max(
                                        decimals,
                                        2
                                    )
                                )
                            );

                        };


                    const render =
                        function (value) {

                            const normalized =
                                normalize(
                                    value
                                );


                            input.value =
                                String(
                                    normalized
                                );


                            minus.disabled =
                                normalized
                                <=
                                min;


                            plus.disabled =
                                normalized
                                +
                                step
                                >
                                max
                                +
                                0.00001;

                        };


                    minus.addEventListener(
                        'click',
                        function () {

                            render(
                                Number(
                                    input.value
                                    ||
                                    min
                                )
                                -
                                step
                            );

                        }
                    );


                    plus.addEventListener(
                        'click',
                        function () {

                            render(
                                Number(
                                    input.value
                                    ||
                                    min
                                )
                                +
                                step
                            );

                        }
                    );


                    input.addEventListener(
                        'change',
                        function () {

                            render(
                                input.value
                            );

                        }
                    );


                    render(
                        input.value
                    );

                }
            );

    }
);
</script>

@endsection
