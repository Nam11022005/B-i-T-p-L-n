@extends('layouts.app')

@section('title', 'Thanh toán | Tinh Hoa Tây Bắc')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | CẤU HÌNH CHECKOUT
    |--------------------------------------------------------------------------
    */

    $selectedShipping =
        old(
            'shipping_method',
            'standard'
        );

    $selectedPayment =
        old(
            'payment_method',
            'cod'
        );


    /*
    |--------------------------------------------------------------------------
    | ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    $defaultAddress =
        $addresses->firstWhere(
            'is_default',
            true
        )
        ??
        $addresses->first();


    $selectedAddressId =
        old(
            'selected_address_id',
            $defaultAddress?->id
        );


    /*
    |--------------------------------------------------------------------------
    | SẢN PHẨM ĐỂ HIỂN THỊ ẢNH
    |--------------------------------------------------------------------------
    */

    $checkoutProductIds =
        array_keys($cart);


    $checkoutProducts =
        empty($checkoutProductIds)

        ? collect()

        : \App\Models\Product::query()
            ->whereIn(
                'id',
                $checkoutProductIds
            )
            ->get()
            ->keyBy('id');


    /*
    |--------------------------------------------------------------------------
    | PHÍ VẬN CHUYỂN
    |--------------------------------------------------------------------------
    */

    $shippingOptions = [
        'standard' => [
            'name' => 'Giao hàng tiết kiệm',
            'description' => 'Dự kiến 3 - 5 ngày',
            'fee' => 25000,
            'icon' => '📦',
        ],

        'fast' => [
            'name' => 'Giao hàng nhanh',
            'description' => 'Dự kiến 1 - 2 ngày',
            'fee' => 35000,
            'icon' => '🚚',
        ],

        'express' => [
            'name' => 'Giao hàng hỏa tốc',
            'description' => 'Ưu tiên giao trong ngày',
            'fee' => 50000,
            'icon' => '⚡',
        ],
    ];


    $initialShippingFee =
        $shippingOptions[
            $selectedShipping
        ]['fee']
        ??
        25000;


    /*
    |--------------------------------------------------------------------------
    | FORMAT QUANTITY
    |--------------------------------------------------------------------------
    */

    $formatQuantity =
        function ($value) {

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


    /*
    |--------------------------------------------------------------------------
    | VOUCHER DATA FOR JAVASCRIPT
    |--------------------------------------------------------------------------
    */

    $voucherJsData =
        $availableVouchers

            ->map(
                function ($voucher) {

                    return [
                        'code' =>
                            $voucher->code,

                        'type' =>
                            $voucher->type,

                        'value' =>
                            (float)
                            $voucher->value,

                        'min_order_value' =>
                            (float)
                            $voucher
                                ->min_order_value,

                        'max_discount' =>
                            $voucher
                                ->max_discount
                            !==
                            null

                            ? (float)
                                $voucher
                                    ->max_discount

                            : null,
                    ];

                }
            )

            ->values();
@endphp


<style>
    /* =========================================================
       CHECKOUT ECOMMERCE
    ========================================================= */

    .checkout-shop {
        --checkout-green: #35562f;
        --checkout-green-dark: #274522;

        --checkout-brown: #633820;
        --checkout-brown-dark: #3d2316;

        --checkout-red: #b43e2e;
        --checkout-red-dark: #8c2f24;

        --checkout-gold: #e5ad42;
        --checkout-gold-light: #fff1cd;

        --checkout-border: #e7dfd5;

        --checkout-text: #302923;
        --checkout-muted: #786f68;

        --checkout-shadow:
            0 8px 28px
            rgba(55, 39, 27, .07);

        --checkout-shadow-lg:
            0 18px 45px
            rgba(55, 39, 27, .12);

        color:
            var(--checkout-text);
    }


    .checkout-shop *,
    .checkout-shop *::before,
    .checkout-shop *::after {
        box-sizing: border-box;
    }


    .checkout-shop a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .checkout-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .checkout-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .checkout-breadcrumb a:hover {
        color:
            var(--checkout-red);
    }


    /* =========================================================
       PROGRESS
    ========================================================= */

    .checkout-progress {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        margin-bottom: 18px;

        overflow: hidden;

        border:
            1px solid
            var(--checkout-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--checkout-shadow);
    }


    .checkout-progress-item {
        min-height: 57px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 9px;

        padding:
            10px;

        color: #766c64;

        font-size: 11px;

        font-weight: 850;
    }


    .checkout-progress-item:not(:last-child) {
        border-right:
            1px solid
            var(--checkout-border);
    }


    .checkout-progress-item.done {
        color:
            var(--checkout-green);
    }


    .checkout-progress-item.active {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--checkout-brown-dark),
                var(--checkout-brown)
            );
    }


    .checkout-progress-number {
        width: 27px;
        height: 27px;

        flex: 0 0 27px;

        display: grid;
        place-items: center;

        border:
            1px solid
            currentColor;

        border-radius: 50%;

        font-size: 10px;

        font-weight: 950;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .checkout-heading {
        position: relative;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;

        margin-bottom: 20px;

        padding:
            24px 28px;

        border:
            1px solid #e1d3c0;

        border-radius: 18px;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(229,173,66,.18),
                transparent 28%
            ),

            linear-gradient(
                120deg,
                #fffdf9,
                #fff7ea 58%,
                #f1f6ee
            );

        box-shadow:
            var(--checkout-shadow);
    }


    .checkout-heading::after {
        content: "";

        position: absolute;

        right: -30px;
        bottom: -55px;

        width: 250px;
        height: 145px;

        opacity: .075;

        background:
            var(--checkout-green);

        clip-path:
            polygon(
                0 100%,
                20% 51%,
                38% 72%,
                58% 23%,
                77% 62%,
                100% 13%,
                100% 100%
            );
    }


    .checkout-heading-copy {
        position: relative;

        z-index: 2;
    }


    .checkout-eyebrow {
        margin-bottom: 5px;

        color:
            var(--checkout-red);

        font-size: 10px;

        font-weight: 950;

        letter-spacing: .1em;

        text-transform: uppercase;
    }


    .checkout-title {
        margin: 0;

        color:
            var(--checkout-text);

        font-size:
            clamp(
                27px,
                3vw,
                38px
            );

        line-height: 1.1;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .checkout-description {
        max-width: 680px;

        margin-top: 7px;

        color:
            var(--checkout-muted);

        font-size: 12.5px;

        line-height: 1.65;
    }


    .checkout-safe {
        position: relative;

        z-index: 2;

        flex: 0 0 auto;

        padding:
            11px 14px;

        border:
            1px solid #cbd8c5;

        border-radius: 12px;

        color:
            var(--checkout-green-dark);

        background:
            rgba(255,255,255,.85);

        font-size: 10px;

        font-weight: 900;
    }


    /* =========================================================
       MAIN LAYOUT
    ========================================================= */

    .checkout-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            390px;

        gap: 20px;

        align-items: start;
    }


    .checkout-main {
        min-width: 0;

        display: grid;

        gap: 15px;
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .checkout-card {
        overflow: hidden;

        border:
            1px solid
            var(--checkout-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--checkout-shadow);
    }


    .checkout-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            16px 18px;

        border-bottom:
            1px solid
            var(--checkout-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf7
            );
    }


    .checkout-card-title-wrap {
        display: flex;
        align-items: center;

        gap: 11px;

        min-width: 0;
    }


    .checkout-card-icon {
        width: 39px;
        height: 39px;

        flex: 0 0 39px;

        display: grid;
        place-items: center;

        border:
            1px solid #e7ca96;

        border-radius: 11px;

        background:
            var(--checkout-gold-light);

        font-size: 18px;
    }


    .checkout-card-title {
        margin: 0;

        color:
            #453930;

        font-size: 14px;

        font-weight: 950;
    }


    .checkout-card-subtitle {
        margin-top: 2px;

        color:
            var(--checkout-muted);

        font-size: 10px;
    }


    .checkout-card-body {
        padding: 18px;
    }


    .checkout-manage-link {
        flex: 0 0 auto;

        min-height: 34px;

        display: inline-flex;
        align-items: center;

        padding:
            0 10px;

        border:
            1px solid #dfc5a3;

        border-radius: 8px;

        color:
            var(--checkout-brown);

        background: #fff;

        font-size: 9px;

        font-weight: 900;
    }


    .checkout-manage-link:hover {
        color: #fff;

        border-color:
            var(--checkout-brown);

        background:
            var(--checkout-brown);
    }


    /* =========================================================
       ADDRESSES
    ========================================================= */

    .checkout-address-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 10px;

        margin-bottom: 17px;
    }


    .checkout-address-card {
        position: relative;

        min-height: 130px;

        display: block;

        padding: 14px;

        border:
            1px solid #e6ddd2;

        border-radius: 12px;

        color:
            var(--checkout-text);

        background: #fff;

        cursor: pointer;

        transition:
            border-color .18s ease,
            background .18s ease,
            box-shadow .18s ease,
            transform .18s ease;
    }


    .checkout-address-card:hover {
        border-color: #d8b780;

        transform:
            translateY(-1px);
    }


    .checkout-address-card.selected {
        border-color:
            var(--checkout-red);

        background:
            #fff8f4;

        box-shadow:
            0 0 0 3px
            rgba(180,62,46,.07);
    }


    .checkout-address-card input {
        position: absolute;

        opacity: 0;

        pointer-events: none;
    }


    .checkout-address-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 8px;
    }


    .checkout-address-label {
        color:
            var(--checkout-brown-dark);

        font-size: 11px;

        font-weight: 950;
    }


    .checkout-default-badge {
        flex: 0 0 auto;

        padding:
            4px 6px;

        border-radius: 999px;

        color:
            var(--checkout-green-dark);

        background:
            #edf5e9;

        font-size: 8px;

        font-weight: 900;
    }


    .checkout-address-person {
        margin-top: 8px;

        color:
            #4b4038;

        font-size: 11px;

        font-weight: 850;
    }


    .checkout-address-text {
        margin-top: 5px;

        color:
            var(--checkout-muted);

        font-size: 10px;

        line-height: 1.5;
    }


    .checkout-address-other {
        display: flex;
        align-items: center;
        justify-content: center;

        min-height: 130px;

        text-align: center;
    }


    .checkout-address-other-icon {
        font-size: 26px;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .checkout-form-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 13px;
    }


    .checkout-field.full {
        grid-column:
            1 / -1;
    }


    .checkout-label {
        display: block;

        margin-bottom: 6px;

        color: #51443b;

        font-size: 10.5px;

        font-weight: 900;
    }


    .checkout-required {
        color:
            var(--checkout-red);
    }


    .checkout-input-wrap {
        position: relative;
    }


    .checkout-input-icon {
        position: absolute;

        z-index: 2;

        top: 50%;
        left: 12px;

        transform:
            translateY(-50%);

        font-size: 15px;

        pointer-events: none;
    }


    .checkout-textarea-wrap
    .checkout-input-icon {
        top: 15px;

        transform: none;
    }


    .checkout-input,
    .checkout-textarea {
        width: 100%;

        border:
            1px solid #ddd3c7;

        border-radius: 10px;

        outline: 0;

        color:
            var(--checkout-text);

        background: #fff;

        font-size: 12px;

        transition:
            border-color .17s ease,
            box-shadow .17s ease;
    }


    .checkout-input {
        height: 45px;

        padding:
            0 12px 0 38px;
    }


    .checkout-textarea {
        min-height: 95px;

        padding:
            12px 12px 12px 38px;

        resize: vertical;

        line-height: 1.55;
    }


    .checkout-input:focus,
    .checkout-textarea:focus {
        border-color:
            var(--checkout-gold);

        box-shadow:
            0 0 0 3px
            rgba(229,173,66,.11);
    }


    .checkout-help-note {
        display: flex;
        align-items: flex-start;

        gap: 7px;

        margin-top: 14px;

        padding:
            10px 11px;

        border:
            1px solid #ebd6aa;

        border-radius: 9px;

        color: #69543e;

        background: #fff9e8;

        font-size: 9.5px;

        line-height: 1.55;
    }


    /* =========================================================
       SHIPPING
    ========================================================= */

    .checkout-options {
        display: grid;

        gap: 9px;
    }


    .checkout-option {
        position: relative;
    }


    .checkout-option input {
        position: absolute;

        opacity: 0;

        pointer-events: none;
    }


    .checkout-option-label {
        min-height: 73px;

        display: grid;

        grid-template-columns:
            43px
            minmax(0, 1fr)
            auto;

        align-items: center;

        gap: 12px;

        padding:
            12px 13px;

        border:
            1px solid #e4dbd0;

        border-radius: 11px;

        background: #fff;

        cursor: pointer;

        transition:
            border-color .18s ease,
            background .18s ease,
            box-shadow .18s ease;
    }


    .checkout-option-label:hover {
        border-color:
            #d6bc96;
    }


    .checkout-option input:checked
    +
    .checkout-option-label {
        border-color:
            var(--checkout-green);

        background:
            #f4f8f2;

        box-shadow:
            0 0 0 3px
            rgba(53,86,47,.06);
    }


    .checkout-option-icon {
        width: 43px;
        height: 43px;

        display: grid;
        place-items: center;

        border-radius: 10px;

        background:
            #fff2d5;

        font-size: 20px;
    }


    .checkout-option-title {
        color: #463a32;

        font-size: 11.5px;

        font-weight: 950;
    }


    .checkout-option-description {
        margin-top: 2px;

        color:
            var(--checkout-muted);

        font-size: 9.5px;
    }


    .checkout-option-price {
        color:
            var(--checkout-red);

        font-size: 12px;

        font-weight: 950;

        white-space: nowrap;
    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .checkout-payment-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 10px;
    }


    .checkout-payment {
        position: relative;
    }


    .checkout-payment input {
        position: absolute;

        opacity: 0;

        pointer-events: none;
    }


    .checkout-payment-label {
        min-height: 107px;

        display: flex;
        align-items: flex-start;
        flex-direction: column;

        padding: 14px;

        border:
            1px solid #e4dbd0;

        border-radius: 12px;

        background: #fff;

        cursor: pointer;

        transition:
            .18s ease;
    }


    .checkout-payment-label:hover {
        border-color:
            #d8ba8d;
    }


    .checkout-payment input:checked
    +
    .checkout-payment-label {
        border-color:
            var(--checkout-red);

        background:
            #fff8f5;

        box-shadow:
            0 0 0 3px
            rgba(180,62,46,.06);
    }


    .checkout-payment-icon {
        font-size: 24px;
    }


    .checkout-payment-title {
        margin-top: 7px;

        color:
            #463a32;

        font-size: 11.5px;

        font-weight: 950;
    }


    .checkout-payment-description {
        margin-top: 3px;

        color:
            var(--checkout-muted);

        font-size: 9.5px;

        line-height: 1.45;
    }


    .checkout-bank-info {
        display: none;

        margin-top: 11px;

        padding: 13px;

        border:
            1px solid #d7c8b5;

        border-radius: 11px;

        background:
            linear-gradient(
                135deg,
                #fffaf0,
                #f2f7ef
            );
    }


    .checkout-bank-info.show {
        display: block;
    }


    .checkout-bank-info-title {
        color:
            var(--checkout-brown-dark);

        font-size: 11px;

        font-weight: 950;
    }


    .checkout-bank-info p {
        margin:
            5px 0 0;

        color:
            var(--checkout-muted);

        font-size: 9.5px;

        line-height: 1.55;
    }


    .checkout-payment-code {
        display: inline-flex;

        margin-top: 8px;

        padding:
            5px 8px;

        border:
            1px dashed #d8b46d;

        border-radius: 7px;

        color:
            var(--checkout-red);

        background: #fff;

        font-size: 10px;

        font-weight: 950;

        letter-spacing: .04em;
    }


    /* =========================================================
       VOUCHERS
    ========================================================= */

    .checkout-voucher-input {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto;

        gap: 7px;
    }


    .checkout-voucher-button {
        min-width: 87px;

        border: 0;

        border-radius: 9px;

        color: #fff;

        background:
            var(--checkout-red);

        font-size: 10px;

        font-weight: 900;
    }


    .checkout-voucher-button:hover {
        background:
            var(--checkout-red-dark);
    }


    .checkout-voucher-message {
        min-height: 21px;

        margin-top: 6px;

        font-size: 9.5px;
    }


    .checkout-voucher-list {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 9px;

        margin-top: 13px;
    }


    .checkout-voucher {
        position: relative;

        overflow: hidden;

        min-height: 115px;

        display: flex;
        justify-content: space-between;
        flex-direction: column;

        gap: 8px;

        padding:
            12px;

        border:
            1px dashed #dfbf7d;

        border-radius: 11px;

        background:
            #fffaf0;
    }


    .checkout-voucher::before {
        content: "";

        position: absolute;

        top: 0;
        bottom: 0;
        left: 0;

        width: 4px;

        background:
            var(--checkout-gold);
    }


    .checkout-voucher.disabled {
        opacity: .55;

        filter:
            grayscale(.25);

        background: #f6f5f3;
    }


    .checkout-voucher-code {
        display: inline-flex;

        width: fit-content;

        padding:
            4px 7px;

        border-radius: 6px;

        color:
            var(--checkout-red);

        background: #fff;

        font-size: 9px;

        font-weight: 950;

        letter-spacing: .03em;
    }


    .checkout-voucher-name {
        margin-top: 5px;

        color:
            #4c4037;

        font-size: 10.5px;

        font-weight: 900;
    }


    .checkout-voucher-description {
        margin-top: 3px;

        color:
            var(--checkout-muted);

        font-size: 9px;

        line-height: 1.45;
    }


    .checkout-voucher-action {
        width: 100%;
        min-height: 30px;

        border:
            1px solid #dab6ad;

        border-radius: 7px;

        color:
            var(--checkout-red);

        background: #fff;

        font-size: 8.5px;

        font-weight: 900;
    }


    .checkout-voucher-action:hover:not(:disabled) {
        color: #fff;

        border-color:
            var(--checkout-red);

        background:
            var(--checkout-red);
    }


    .checkout-voucher-action:disabled {
        cursor: not-allowed;
    }


    /* =========================================================
       ORDER SUMMARY
    ========================================================= */

    .checkout-summary {
        position: sticky;

        top: 177px;

        overflow: hidden;

        border:
            1px solid
            var(--checkout-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--checkout-shadow-lg);
    }


    .checkout-summary-head {
        padding:
            16px 17px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--checkout-brown-dark),
                var(--checkout-brown)
            );
    }


    .checkout-summary-title {
        font-size: 14px;

        font-weight: 950;
    }


    .checkout-summary-subtitle {
        margin-top: 2px;

        color:
            rgba(255,255,255,.67);

        font-size: 9.5px;
    }


    /* =========================================================
       PRODUCTS
    ========================================================= */

    .checkout-products {
        max-height: 355px;

        overflow-y: auto;

        padding:
            4px 15px;
    }


    .checkout-product {
        display: grid;

        grid-template-columns:
            62px
            minmax(0, 1fr)
            auto;

        gap: 9px;

        padding:
            11px 0;

        border-bottom:
            1px solid #eee7df;
    }


    .checkout-product:last-child {
        border-bottom: 0;
    }


    .checkout-product-media {
        position: relative;

        width: 62px;
        height: 62px;

        overflow: hidden;

        border:
            1px solid #e9e0d6;

        border-radius: 9px;

        background:
            #faf8f4;
    }


    .checkout-product-media img {
        width: 100%;
        height: 100%;

        padding: 3px;

        object-fit: contain;
    }


    .checkout-product-fallback {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #9c8d81;

        font-size: 24px;
    }


    .checkout-product-qty {
        position: absolute;

        top: -1px;
        right: -1px;

        min-width: 19px;
        height: 19px;

        display: grid;
        place-items: center;

        padding:
            0 4px;

        border-radius:
            0 8px 0 8px;

        color: #fff;

        background:
            var(--checkout-red);

        font-size: 8px;

        font-weight: 950;
    }


    .checkout-product-info {
        min-width: 0;
    }


    .checkout-product-name {
        color: #3c332d;

        font-size: 10.5px;

        line-height: 1.4;

        font-weight: 900;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    .checkout-product-meta {
        margin-top: 4px;

        color:
            var(--checkout-muted);

        font-size: 8.5px;
    }


    .checkout-product-price {
        align-self: center;

        color:
            var(--checkout-brown-dark);

        font-size: 10.5px;

        font-weight: 950;

        white-space: nowrap;
    }


    /* =========================================================
       SUMMARY TOTAL
    ========================================================= */

    .checkout-summary-body {
        padding:
            15px 17px 17px;

        border-top:
            1px solid
            var(--checkout-border);
    }


    .checkout-summary-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 10px;

        color:
            var(--checkout-muted);

        font-size: 10.5px;
    }


    .checkout-summary-row strong {
        color: #4a3e36;

        font-size: 11px;
    }


    .checkout-summary-discount {
        color:
            var(--checkout-green) !important;
    }


    .checkout-summary-divider {
        height: 1px;

        margin:
            14px 0;

        background:
            #eae1d7;
    }


    .checkout-summary-total {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 10px;
    }


    .checkout-summary-total-label {
        color: #40352e;

        font-size: 13px;

        font-weight: 950;
    }


    .checkout-summary-total-note {
        margin-top: 2px;

        color: #998d84;

        font-size: 8.5px;
    }


    .checkout-summary-total-price {
        color:
            var(--checkout-red);

        font-size: 23px;

        line-height: 1;

        font-weight: 950;

        letter-spacing: -.035em;

        text-align: right;
    }


    .checkout-order-button {
        width: 100%;
        min-height: 49px;

        margin-top: 16px;

        border: 0;

        border-radius: 10px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--checkout-red),
                var(--checkout-red-dark)
            );

        box-shadow:
            0 9px 20px
            rgba(180,62,46,.21);

        font-size: 11.5px;

        font-weight: 950;

        transition:
            transform .17s ease,
            box-shadow .17s ease;
    }


    .checkout-order-button:hover {
        transform:
            translateY(-1px);

        box-shadow:
            0 13px 27px
            rgba(180,62,46,.27);
    }


    .checkout-order-button.bank {
        background:
            linear-gradient(
                135deg,
                var(--checkout-green),
                var(--checkout-green-dark)
            );

        box-shadow:
            0 9px 20px
            rgba(53,86,47,.19);
    }


    .checkout-back {
        min-height: 39px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-top: 7px;

        border:
            1px solid #ddd3c7;

        border-radius: 9px;

        color: #66574d;

        background: #fff;

        font-size: 9.5px;

        font-weight: 850;
    }


    .checkout-back:hover {
        color:
            var(--checkout-red);

        border-color:
            #dab9b0;

        background: #fff8f5;
    }


    .checkout-trust {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 6px;

        margin-top: 11px;
    }


    .checkout-trust-item {
        padding:
            8px;

        border:
            1px solid #eee5da;

        border-radius: 8px;

        color: #6b5b50;

        background:
            #fdfbf8;

        font-size: 8.5px;

        line-height: 1.4;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .checkout-layout {
            grid-template-columns:
                minmax(0, 1fr)
                340px;
        }

    }


    @media (max-width: 991.98px) {

        .checkout-layout {
            grid-template-columns: 1fr;
        }


        .checkout-summary {
            position: static;
        }

    }


    @media (max-width: 767.98px) {

        .checkout-heading {
            align-items: flex-start;

            flex-direction: column;
        }


        .checkout-progress-item span:last-child {
            display: none;
        }


        .checkout-address-grid,
        .checkout-form-grid,
        .checkout-payment-grid,
        .checkout-voucher-list {
            grid-template-columns: 1fr;
        }


        .checkout-field.full {
            grid-column: auto;
        }

    }


    @media (max-width: 575.98px) {

        .checkout-progress-item {
            min-height: 48px;

            padding:
                8px 4px;
        }


        .checkout-heading {
            padding:
                20px 17px;

            border-radius: 14px;
        }


        .checkout-card-head {
            align-items: flex-start;

            flex-direction: column;
        }


        .checkout-manage-link {
            width: 100%;

            justify-content: center;
        }


        .checkout-card-body {
            padding: 14px;
        }


        .checkout-option-label {
            grid-template-columns:
                39px
                minmax(0, 1fr);

            gap: 9px;
        }


        .checkout-option-price {
            grid-column: 2;
        }


        .checkout-product {
            grid-template-columns:
                54px
                minmax(0, 1fr);
        }


        .checkout-product-media {
            width: 54px;
            height: 54px;
        }


        .checkout-product-price {
            grid-column:
                2;

            justify-self: start;
        }

    }
</style>


<div class="checkout-shop">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="checkout-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <a href="{{ route('cart.index') }}">
            Giỏ hàng
        </a>

        <span>›</span>

        <span>
            Thanh toán
        </span>

    </div>


    {{-- =====================================================
        PROGRESS
    ====================================================== --}}
    <div class="checkout-progress">

        <div class="checkout-progress-item done">

            <span class="checkout-progress-number">
                ✓
            </span>

            <span>
                Giỏ hàng
            </span>

        </div>


        <div class="checkout-progress-item active">

            <span class="checkout-progress-number">
                2
            </span>

            <span>
                Thanh toán
            </span>

        </div>


        <div class="checkout-progress-item">

            <span class="checkout-progress-number">
                3
            </span>

            <span>
                Hoàn tất đơn
            </span>

        </div>

    </div>


    {{-- =====================================================
        HEADING
    ====================================================== --}}
    <section class="checkout-heading">

        <div class="checkout-heading-copy">

            <div class="checkout-eyebrow">
                🔒 Checkout an toàn
            </div>


            <h1 class="checkout-title">
                Hoàn tất đơn hàng
            </h1>


            <div class="checkout-description">

                Xác nhận thông tin nhận hàng,
                lựa chọn vận chuyển,
                voucher và phương thức thanh toán
                trước khi tạo đơn.

            </div>

        </div>


        <div class="checkout-safe">
            🛡️ Thông tin đơn hàng được bảo vệ
        </div>

    </section>


    {{-- =====================================================
        FORM
    ====================================================== --}}
    <form
        action="{{ route('checkout.process') }}"
        method="POST"
        id="checkoutForm"
    >

        @csrf


        <div class="checkout-layout">


            {{-- =================================================
                LEFT SIDE
            ================================================== --}}
            <div class="checkout-main">


                {{-- =============================================
                    ADDRESS
                ============================================== --}}
                <section class="checkout-card">

                    <div class="checkout-card-head">

                        <div class="checkout-card-title-wrap">

                            <div class="checkout-card-icon">
                                📍
                            </div>


                            <div>

                                <h2 class="checkout-card-title">
                                    Thông tin nhận hàng
                                </h2>

                                <div class="checkout-card-subtitle">
                                    Chọn địa chỉ đã lưu hoặc nhập địa chỉ khác.
                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ route('addresses.index') }}"
                            class="checkout-manage-link"
                        >
                            ⚙️ Quản lý địa chỉ
                        </a>

                    </div>


                    <div class="checkout-card-body">


                        {{-- SAVED ADDRESSES --}}
                        @if($addresses->isNotEmpty())

                            <div class="checkout-address-grid">


                                @foreach($addresses as $address)

                                    @php
                                        $fullAddress =
                                            collect([
                                                $address->address_detail,
                                                $address->ward,
                                                $address->province,
                                            ])
                                            ->filter()
                                            ->implode(', ');


                                        $addressSelected =
                                            (string)
                                            $selectedAddressId
                                            ===
                                            (string)
                                            $address->id;
                                    @endphp


                                    <label
                                        class="
                                            checkout-address-card
                                            {{
                                                $addressSelected
                                                ? 'selected'
                                                : ''
                                            }}
                                        "
                                    >

                                        <input
                                            type="radio"
                                            name="selected_address_id"
                                            value="{{ $address->id }}"
                                            class="checkout-address-radio"
                                            data-name="{{
                                                $address->receiver_name
                                            }}"
                                            data-phone="{{
                                                $address->phone
                                            }}"
                                            data-address="{{
                                                $fullAddress
                                            }}"
                                            {{
                                                $addressSelected
                                                ? 'checked'
                                                : ''
                                            }}
                                        >


                                        <div class="checkout-address-top">

                                            <span class="checkout-address-label">

                                                {{
                                                    $address->label
                                                    ??
                                                    'Địa chỉ'
                                                }}

                                            </span>


                                            @if($address->is_default)

                                                <span class="checkout-default-badge">
                                                    Mặc định
                                                </span>

                                            @endif

                                        </div>


                                        <div class="checkout-address-person">

                                            {{
                                                $address->receiver_name
                                            }}

                                            ·

                                            {{ $address->phone }}

                                        </div>


                                        <div class="checkout-address-text">
                                            {{ $fullAddress }}
                                        </div>

                                    </label>

                                @endforeach


                                {{-- OTHER ADDRESS --}}
                                <label
                                    class="
                                        checkout-address-card
                                        checkout-address-other
                                        {{
                                            old(
                                                'selected_address_id'
                                            )
                                            ===
                                            'other'
                                            ? 'selected'
                                            : ''
                                        }}
                                    "
                                >

                                    <input
                                        type="radio"
                                        name="selected_address_id"
                                        value="other"
                                        class="checkout-address-radio"
                                        {{
                                            old(
                                                'selected_address_id'
                                            )
                                            ===
                                            'other'
                                            ? 'checked'
                                            : ''
                                        }}
                                    >


                                    <div>

                                        <div class="checkout-address-other-icon">
                                            ＋
                                        </div>

                                        <div class="checkout-address-label mt-2">
                                            Sử dụng địa chỉ khác
                                        </div>

                                        <div class="checkout-address-text">
                                            Nhập thông tin nhận hàng
                                            riêng cho đơn này.
                                        </div>

                                    </div>

                                </label>

                            </div>


                        @else

                            <div class="checkout-help-note mb-3">

                                <span>
                                    📍
                                </span>

                                <span>

                                    Bạn chưa lưu địa chỉ nào.
                                    Có thể nhập thông tin bên dưới
                                    hoặc

                                    <a
                                        href="{{ route('addresses.index') }}"
                                        style="
                                            color:#b43e2e;
                                            font-weight:900;
                                        "
                                    >
                                        thêm địa chỉ mới
                                    </a>.

                                </span>

                            </div>

                        @endif


                        {{-- MANUAL FIELDS --}}
                        <div class="checkout-form-grid">


                            <div class="checkout-field">

                                <label
                                    for="customerName"
                                    class="checkout-label"
                                >
                                    Họ và tên

                                    <span class="checkout-required">
                                        *
                                    </span>
                                </label>


                                <div class="checkout-input-wrap">

                                    <span class="checkout-input-icon">
                                        👤
                                    </span>


                                    <input
                                        type="text"
                                        id="customerName"
                                        name="customer_name"
                                        class="checkout-input"
                                        value="{{
                                            old(
                                                'customer_name',
                                                $defaultAddress
                                                    ?->receiver_name
                                                ??
                                                Auth::user()->name
                                            )
                                        }}"
                                        placeholder="Tên người nhận"
                                        maxlength="255"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="checkout-field">

                                <label
                                    for="customerPhone"
                                    class="checkout-label"
                                >
                                    Số điện thoại

                                    <span class="checkout-required">
                                        *
                                    </span>
                                </label>


                                <div class="checkout-input-wrap">

                                    <span class="checkout-input-icon">
                                        ☎️
                                    </span>


                                    <input
                                        type="tel"
                                        id="customerPhone"
                                        name="customer_phone"
                                        class="checkout-input"
                                        value="{{
                                            old(
                                                'customer_phone',
                                                $defaultAddress
                                                    ?->phone
                                            )
                                        }}"
                                        placeholder="Ví dụ: 0385742505"
                                        maxlength="20"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="checkout-field full">

                                <label
                                    for="shippingAddress"
                                    class="checkout-label"
                                >
                                    Địa chỉ giao hàng

                                    <span class="checkout-required">
                                        *
                                    </span>
                                </label>


                                <div
                                    class="
                                        checkout-input-wrap
                                        checkout-textarea-wrap
                                    "
                                >

                                    <span class="checkout-input-icon">
                                        🏠
                                    </span>


                                    <textarea
                                        id="shippingAddress"
                                        name="shipping_address"
                                        class="checkout-textarea"
                                        maxlength="500"
                                        placeholder="Số nhà, đường, phường/xã, tỉnh/thành phố..."
                                        required
                                    >{{ old(
                                        'shipping_address',
                                        $defaultAddress
                                            ? collect([
                                                $defaultAddress->address_detail,
                                                $defaultAddress->ward,
                                                $defaultAddress->province,
                                            ])->filter()->implode(', ')
                                            : ''
                                    ) }}</textarea>

                                </div>

                            </div>

                        </div>


                        <div class="checkout-help-note">

                            <span>
                                ℹ️
                            </span>

                            <span>

                                Khi chọn một địa chỉ đã lưu,
                                thông tin người nhận sẽ được
                                tự động điền vào biểu mẫu.
                                Bạn vẫn có thể chỉnh sửa
                                trước khi đặt hàng.

                            </span>

                        </div>

                    </div>

                </section>


                {{-- =============================================
                    SHIPPING
                ============================================== --}}
                <section class="checkout-card">

                    <div class="checkout-card-head">

                        <div class="checkout-card-title-wrap">

                            <div class="checkout-card-icon">
                                🚚
                            </div>


                            <div>

                                <h2 class="checkout-card-title">
                                    Phương thức vận chuyển
                                </h2>

                                <div class="checkout-card-subtitle">
                                    Chọn tốc độ giao hàng phù hợp.
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="checkout-card-body">

                        <div class="checkout-options">


                            @foreach($shippingOptions as $shippingKey => $shipping)

                                <div class="checkout-option">

                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        id="shipping_{{
                                            $shippingKey
                                        }}"
                                        value="{{
                                            $shippingKey
                                        }}"
                                        data-fee="{{
                                            $shipping['fee']
                                        }}"
                                        {{
                                            $selectedShipping
                                            ===
                                            $shippingKey
                                            ? 'checked'
                                            : ''
                                        }}
                                    >


                                    <label
                                        for="shipping_{{
                                            $shippingKey
                                        }}"
                                        class="checkout-option-label"
                                    >

                                        <span class="checkout-option-icon">

                                            {{
                                                $shipping['icon']
                                            }}

                                        </span>


                                        <span>

                                            <span class="checkout-option-title">

                                                {{
                                                    $shipping['name']
                                                }}

                                            </span>

                                            <span class="checkout-option-description">

                                                {{
                                                    $shipping['description']
                                                }}

                                            </span>

                                        </span>


                                        <span class="checkout-option-price">

                                            {{
                                                number_format(
                                                    $shipping['fee'],
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}đ

                                        </span>

                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </section>


                {{-- =============================================
                    VOUCHER
                ============================================== --}}
                <section class="checkout-card">

                    <div class="checkout-card-head">

                        <div class="checkout-card-title-wrap">

                            <div class="checkout-card-icon">
                                🎟️
                            </div>


                            <div>

                                <h2 class="checkout-card-title">
                                    Voucher
                                </h2>

                                <div class="checkout-card-subtitle">
                                    Nhập mã hoặc chọn voucher khả dụng.
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="checkout-card-body">


                        <div class="checkout-voucher-input">

                            <input
                                type="text"
                                name="voucher_code"
                                id="voucherCode"
                                class="checkout-input"
                                value="{{
                                    old(
                                        'voucher_code'
                                    )
                                }}"
                                placeholder="Nhập mã giảm giá"
                                maxlength="50"
                                style="
                                    padding-left:12px;
                                "
                            >


                            <button
                                type="button"
                                class="checkout-voucher-button"
                                id="applyVoucherButton"
                            >
                                Áp dụng
                            </button>

                        </div>


                        <div
                            id="voucherMessage"
                            class="checkout-voucher-message"
                        >
                        </div>


                        @if($availableVouchers->isNotEmpty())

                            <div class="checkout-voucher-list">


                                @foreach($availableVouchers as $voucher)

                                    @php
                                        $canUseVoucher =
                                            $subtotal
                                            >=
                                            (float)
                                            $voucher
                                                ->min_order_value;


                                        if (
                                            $voucher->type
                                            ===
                                            'percent'
                                        ) {

                                            $voucherDescription =
                                                'Giảm '
                                                .
                                                rtrim(
                                                    rtrim(
                                                        number_format(
                                                            $voucher->value,
                                                            2,
                                                            '.',
                                                            ''
                                                        ),
                                                        '0'
                                                    ),
                                                    '.'
                                                )
                                                .
                                                '%';


                                            if (
                                                $voucher
                                                    ->max_discount
                                                !==
                                                null
                                            ) {

                                                $voucherDescription .=
                                                    ' · tối đa '
                                                    .
                                                    number_format(
                                                        $voucher
                                                            ->max_discount,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                    .
                                                    'đ';

                                            }

                                        }
                                        elseif (
                                            $voucher->type
                                            ===
                                            'fixed'
                                        ) {

                                            $voucherDescription =
                                                'Giảm '
                                                .
                                                number_format(
                                                    $voucher->value,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                                .
                                                'đ';

                                        }
                                        else {

                                            $voucherDescription =
                                                'Giảm phí vận chuyển tối đa '
                                                .
                                                number_format(
                                                    $voucher->value,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                                .
                                                'đ';

                                        }
                                    @endphp


                                    <div
                                        class="
                                            checkout-voucher
                                            {{
                                                $canUseVoucher
                                                ? ''
                                                : 'disabled'
                                            }}
                                        "
                                    >

                                        <div>

                                            <span class="checkout-voucher-code">

                                                {{ $voucher->code }}

                                            </span>


                                            <div class="checkout-voucher-name">

                                                {{ $voucher->name }}

                                            </div>


                                            <div class="checkout-voucher-description">

                                                {{ $voucherDescription }}

                                                <br>

                                                Đơn tối thiểu:

                                                {{
                                                    number_format(
                                                        $voucher
                                                            ->min_order_value,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}đ


                                                @if(
                                                    $voucher
                                                        ->usage_limit
                                                    !==
                                                    null
                                                )

                                                    · Còn

                                                    {{
                                                        max(
                                                            $voucher
                                                                ->usage_limit
                                                            -
                                                            $voucher
                                                                ->used_count,
                                                            0
                                                        )
                                                    }}

                                                    lượt

                                                @endif

                                            </div>

                                        </div>


                                        <button
                                            type="button"
                                            class="checkout-voucher-action"
                                            data-voucher-code="{{
                                                $voucher->code
                                            }}"
                                            {{
                                                $canUseVoucher
                                                ? ''
                                                : 'disabled'
                                            }}
                                        >

                                            {{
                                                $canUseVoucher
                                                ? 'Dùng voucher này'
                                                : 'Chưa đủ điều kiện'
                                            }}

                                        </button>

                                    </div>

                                @endforeach

                            </div>


                        @else

                            <div class="checkout-help-note">

                                <span>
                                    ℹ️
                                </span>

                                <span>
                                    Hiện chưa có voucher khả dụng.
                                </span>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- =============================================
                    PAYMENT
                ============================================== --}}
                <section class="checkout-card">

                    <div class="checkout-card-head">

                        <div class="checkout-card-title-wrap">

                            <div class="checkout-card-icon">
                                💳
                            </div>


                            <div>

                                <h2 class="checkout-card-title">
                                    Phương thức thanh toán
                                </h2>

                                <div class="checkout-card-subtitle">
                                    Chọn cách bạn muốn thanh toán đơn hàng.
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="checkout-card-body">


                        <div class="checkout-payment-grid">


                            {{-- COD --}}
                            <div class="checkout-payment">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cod"
                                    id="paymentCod"
                                    {{
                                        $selectedPayment
                                        ===
                                        'cod'
                                        ? 'checked'
                                        : ''
                                    }}
                                >


                                <label
                                    for="paymentCod"
                                    class="checkout-payment-label"
                                >

                                    <span class="checkout-payment-icon">
                                        💵
                                    </span>


                                    <span class="checkout-payment-title">
                                        Thanh toán khi nhận hàng
                                    </span>


                                    <span class="checkout-payment-description">

                                        Thanh toán tiền
                                        cho đơn vị vận chuyển
                                        khi nhận sản phẩm.

                                    </span>

                                </label>

                            </div>


                            {{-- BANK --}}
                            <div class="checkout-payment">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="bank"
                                    id="paymentBank"
                                    {{
                                        $selectedPayment
                                        ===
                                        'bank'
                                        ? 'checked'
                                        : ''
                                    }}
                                >


                                <label
                                    for="paymentBank"
                                    class="checkout-payment-label"
                                >

                                    <span class="checkout-payment-icon">
                                        🏦
                                    </span>


                                    <span class="checkout-payment-title">
                                        Chuyển khoản ngân hàng
                                    </span>


                                    <span class="checkout-payment-description">

                                        Tạo đơn trước,
                                        sau đó quét QR
                                        với đúng số tiền
                                        và nội dung chuyển khoản.

                                    </span>

                                </label>

                            </div>


                            {{-- WALLET --}}
                            <div class="checkout-payment">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="wallet"
                                    id="paymentWallet"
                                    {{ $selectedPayment === 'wallet' ? 'checked' : '' }}
                                >

                                <label for="paymentWallet" class="checkout-payment-label">
                                    <span class="checkout-payment-icon">💳</span>
                                    <span class="checkout-payment-title">Ví Tinh Hoa</span>
                                    <span class="checkout-payment-description">
                                        Thanh toán ngay bằng số dư ví.
                                        Số dư: {{ number_format((float) Auth::user()->wallet_balance, 0, ',', '.') }}đ
                                    </span>
                                </label>

                            </div>

                        </div>


                        <div
                            class="checkout-bank-info"
                            id="bankTransferInfo"
                        >

                            <div class="checkout-bank-info-title">

                                🔔 Thanh toán QR tự động

                            </div>


                            <p>

                                Sau khi bấm
                                <strong>
                                    “Tạo đơn &amp; thanh toán QR”
                                </strong>,
                                hệ thống sẽ chuyển đến
                                trang chi tiết đơn hàng
                                để hiển thị QR
                                đúng số tiền.

                            </p>


                            <p>

                                Mã thanh toán riêng
                                của phiên này:

                            </p>


                            <span class="checkout-payment-code">

                                {{ $paymentCode }}

                            </span>

                        </div>

                    </div>

                </section>


                {{-- =============================================
                    NOTES
                ============================================== --}}
                <section class="checkout-card">

                    <div class="checkout-card-head">

                        <div class="checkout-card-title-wrap">

                            <div class="checkout-card-icon">
                                📝
                            </div>


                            <div>

                                <h2 class="checkout-card-title">
                                    Ghi chú đơn hàng
                                </h2>

                                <div class="checkout-card-subtitle">
                                    Không bắt buộc.
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="checkout-card-body">

                        <div
                            class="
                                checkout-input-wrap
                                checkout-textarea-wrap
                            "
                        >

                            <span class="checkout-input-icon">
                                📝
                            </span>


                            <textarea
                                name="notes"
                                class="checkout-textarea"
                                rows="4"
                                maxlength="1000"
                                placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao..."
                            >{{ old('notes') }}</textarea>

                        </div>

                    </div>

                </section>

            </div>


            {{-- =================================================
                RIGHT SUMMARY
            ================================================== --}}
            <aside class="checkout-summary">


                <div class="checkout-summary-head">

                    <div class="checkout-summary-title">
                        📦 Đơn hàng của bạn
                    </div>

                    <div class="checkout-summary-subtitle">

                        {{ count($cart) }}
                        loại sản phẩm

                    </div>

                </div>


                {{-- PRODUCTS --}}
                <div class="checkout-products">


                    @foreach($cart as $id => $item)

                        @php
                            $checkoutProduct =
                                $checkoutProducts
                                    ->get(
                                        (int) $id
                                    );


                            $checkoutImage =
                                null;


                            if (
                                $checkoutProduct
                                &&
                                $checkoutProduct->image
                            ) {

                                $checkoutImage =
                                    str_starts_with(
                                        $checkoutProduct->image,
                                        'http'
                                    )

                                    ? $checkoutProduct->image

                                    : asset(
                                        'storage/'
                                        .
                                        ltrim(
                                            $checkoutProduct->image,
                                            '/'
                                        )
                                    );

                            }


                            $itemPrice =
                                (float)
                                $item['price'];


                            $itemQuantity =
                                (float)
                                $item['quantity'];


                            $itemTotal =
                                $itemPrice
                                *
                                $itemQuantity;


                            $itemUnit =
                                $item['unit']
                                ??
                                'sản phẩm';
                        @endphp


                        <div class="checkout-product">


                            <div class="checkout-product-media">

                                @if($checkoutImage)

                                    <img
                                        src="{{ $checkoutImage }}"
                                        alt="{{ $item['name'] }}"
                                        loading="lazy"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='grid';
                                        "
                                    >


                                    <div
                                        class="checkout-product-fallback"
                                        style="display:none;"
                                    >
                                        🧺
                                    </div>

                                @else

                                    <div class="checkout-product-fallback">
                                        🧺
                                    </div>

                                @endif


                                <span class="checkout-product-qty">

                                    {{
                                        $formatQuantity(
                                            $itemQuantity
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="checkout-product-info">

                                <div class="checkout-product-name">

                                    {{ $item['name'] }}

                                </div>


                                <div class="checkout-product-meta">

                                    {{
                                        number_format(
                                            $itemPrice,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ

                                    /

                                    {{ $itemUnit }}

                                </div>

                            </div>


                            <div class="checkout-product-price">

                                {{
                                    number_format(
                                        $itemTotal,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}đ

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- TOTAL --}}
                <div class="checkout-summary-body">


                    <div class="checkout-summary-row">

                        <span>
                            Tạm tính
                        </span>

                        <strong id="subtotal">

                            {{
                                number_format(
                                    $subtotal,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    <div class="checkout-summary-row">

                        <span>
                            Phí vận chuyển
                        </span>

                        <strong id="shippingFee">

                            {{
                                number_format(
                                    $initialShippingFee,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    <div class="checkout-summary-row">

                        <span>
                            Voucher
                        </span>

                        <strong
                            id="discount"
                            class="checkout-summary-discount"
                        >
                            -0đ
                        </strong>

                    </div>


                    <div class="checkout-summary-divider">
                    </div>


                    <div class="checkout-summary-total">

                        <div>

                            <div class="checkout-summary-total-label">
                                Tổng thanh toán
                            </div>

                            <div class="checkout-summary-total-note">
                                Đã gồm phí vận chuyển
                            </div>

                        </div>


                        <div
                            class="checkout-summary-total-price"
                            id="total"
                        >

                            {{
                                number_format(
                                    $subtotal
                                    +
                                    $initialShippingFee,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </div>

                    </div>


                    <button
                        type="submit"
                        id="orderButton"
                        class="checkout-order-button"
                    >
                        ✅ Đặt hàng COD
                    </button>


                    <a
                        href="{{ route('cart.index') }}"
                        class="checkout-back"
                    >
                        ← Quay lại giỏ hàng
                    </a>


                    <div class="checkout-trust">

                        <div class="checkout-trust-item">
                            🛡️ Đặt hàng an toàn
                        </div>

                        <div class="checkout-trust-item">
                            📦 Theo dõi đơn hàng
                        </div>

                        <div class="checkout-trust-item">
                            💳 Thanh toán linh hoạt
                        </div>

                        <div class="checkout-trust-item">
                            ☎️ Hỗ trợ khi cần
                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </form>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const subtotal =
            Number(
                @json(
                    (float) $subtotal
                )
            );


        const availableVouchers =
            @json($voucherJsData);


        const voucherInput =
            document.getElementById(
                'voucherCode'
            );


        const voucherMessage =
            document.getElementById(
                'voucherMessage'
            );


        const shippingFeeElement =
            document.getElementById(
                'shippingFee'
            );


        const discountElement =
            document.getElementById(
                'discount'
            );


        const totalElement =
            document.getElementById(
                'total'
            );


        const applyVoucherButton =
            document.getElementById(
                'applyVoucherButton'
            );


        const orderButton =
            document.getElementById(
                'orderButton'
            );


        const bankTransferInfo =
            document.getElementById(
                'bankTransferInfo'
            );


        let discount = 0;

        let voucherApplied = false;


        /*
        |--------------------------------------------------------------------------
        | MONEY
        |--------------------------------------------------------------------------
        */

        function formatMoney(value) {

            return new Intl
                .NumberFormat(
                    'vi-VN'
                )
                .format(
                    Math.round(
                        Number(value)
                        ||
                        0
                    )
                )
                +
                'đ';

        }


        /*
        |--------------------------------------------------------------------------
        | SHIPPING FEE
        |--------------------------------------------------------------------------
        */

        function getShippingFee() {

            const selected =
                document.querySelector(
                    'input[name="shipping_method"]:checked'
                );


            if (!selected) {
                return 0;
            }


            return Number(
                selected.dataset.fee
                ||
                0
            );

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        function updateTotal() {

            const shippingFee =
                getShippingFee();


            const total =
                Math.max(
                    subtotal
                    +
                    shippingFee
                    -
                    discount,
                    0
                );


            shippingFeeElement.textContent =
                formatMoney(
                    shippingFee
                );


            discountElement.textContent =
                '-'
                +
                formatMoney(
                    discount
                );


            totalElement.textContent =
                formatMoney(
                    total
                );

        }


        /*
        |--------------------------------------------------------------------------
        | VOUCHER
        |--------------------------------------------------------------------------
        */

        function calculateVoucher(
            code,
            showMessage = true
        ) {

            const normalizedCode =
                String(
                    code
                    ||
                    ''
                )
                .trim()
                .toUpperCase();


            discount = 0;

            voucherApplied = false;


            if (
                normalizedCode
                ===
                ''
            ) {

                if (showMessage) {

                    voucherMessage.innerHTML =
                        '<span style="color:#b43e2e;">Vui lòng nhập mã voucher.</span>';

                }
                else {

                    voucherMessage.innerHTML =
                        '';

                }


                updateTotal();

                return false;

            }


            const voucher =
                availableVouchers.find(
                    function (item) {

                        return String(
                            item.code
                        )
                        .toUpperCase()
                        ===
                        normalizedCode;

                    }
                );


            if (!voucher) {

                if (showMessage) {

                    voucherMessage.innerHTML =
                        '<span style="color:#b43e2e;">❌ Voucher không tồn tại hoặc hiện không khả dụng.</span>';

                }


                updateTotal();

                return false;

            }


            if (
                subtotal
                <
                Number(
                    voucher
                        .min_order_value
                )
            ) {

                if (showMessage) {

                    voucherMessage.innerHTML =
                        '<span style="color:#b43e2e;">⚠️ Đơn hàng phải đạt tối thiểu '
                        +
                        formatMoney(
                            voucher
                                .min_order_value
                        )
                        +
                        ' để dùng voucher này.</span>';

                }


                updateTotal();

                return false;

            }


            const shippingFee =
                getShippingFee();


            if (
                voucher.type
                ===
                'percent'
            ) {

                const percent =
                    Math.min(
                        Number(
                            voucher.value
                        ),
                        100
                    );


                discount =
                    subtotal
                    *
                    (
                        percent
                        /
                        100
                    );

            }
            else if (
                voucher.type
                ===
                'fixed'
            ) {

                discount =
                    Math.min(
                        Number(
                            voucher.value
                        ),
                        subtotal
                    );

            }
            else if (
                voucher.type
                ===
                'shipping'
            ) {

                discount =
                    Math.min(
                        Number(
                            voucher.value
                        ),
                        shippingFee
                    );

            }


            if (
                voucher.max_discount
                !==
                null
            ) {

                discount =
                    Math.min(
                        discount,
                        Number(
                            voucher
                                .max_discount
                        )
                    );

            }


            discount =
                Math.max(
                    discount,
                    0
                );


            voucherApplied = true;


            voucherInput.value =
                normalizedCode;


            if (showMessage) {

                voucherMessage.innerHTML =
                    '<span style="color:#35562f;font-weight:800;">✅ Đã áp dụng voucher '
                    +
                    normalizedCode
                    +
                    '.</span>';

            }


            updateTotal();

            return true;

        }


        if (applyVoucherButton) {

            applyVoucherButton
                .addEventListener(
                    'click',
                    function () {

                        calculateVoucher(
                            voucherInput.value,
                            true
                        );

                    }
                );

        }


        if (voucherInput) {

            voucherInput
                .addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key
                            ===
                            'Enter'
                        ) {

                            event
                                .preventDefault();


                            calculateVoucher(
                                voucherInput.value,
                                true
                            );

                        }

                    }
                );

        }


        document
            .querySelectorAll(
                '[data-voucher-code]'
            )
            .forEach(
                function (button) {

                    button
                        .addEventListener(
                            'click',
                            function () {

                                const code =
                                    button.dataset
                                        .voucherCode;


                                voucherInput.value =
                                    code;


                                calculateVoucher(
                                    code,
                                    true
                                );

                            }
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | SHIPPING CHANGE
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                'input[name="shipping_method"]'
            )
            .forEach(
                function (input) {

                    input
                        .addEventListener(
                            'change',
                            function () {

                                if (
                                    voucherApplied
                                ) {

                                    calculateVoucher(
                                        voucherInput.value,
                                        false
                                    );

                                }
                                else {

                                    updateTotal();

                                }

                            }
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | PAYMENT
        |--------------------------------------------------------------------------
        */

        function updatePaymentMethod() {

            const selected =
                document.querySelector(
                    'input[name="payment_method"]:checked'
                );


            const bankSelected =
                selected
                &&
                selected.value
                ===
                'bank';

            const walletSelected =
                selected
                &&
                selected.value
                ===
                'wallet';


            if (bankTransferInfo) {

                bankTransferInfo
                    .classList
                    .toggle(
                        'show',
                        bankSelected
                    );

            }


            if (!orderButton) {
                return;
            }


            if (bankSelected) {

                orderButton.textContent =
                    '💳 Tạo đơn & thanh toán QR';


                orderButton
                    .classList
                    .add(
                        'bank'
                    );

            }
            else if (walletSelected) {

                orderButton.textContent =
                    '💳 Thanh toán bằng Ví Tinh Hoa';

                orderButton
                    .classList
                    .remove(
                        'bank'
                    );
            }
            else {

                orderButton.textContent =
                    '✅ Đặt hàng COD';


                orderButton
                    .classList
                    .remove(
                        'bank'
                    );

            }

        }


        document
            .querySelectorAll(
                'input[name="payment_method"]'
            )
            .forEach(
                function (input) {

                    input
                        .addEventListener(
                            'change',
                            updatePaymentMethod
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | SAVED ADDRESS
        |--------------------------------------------------------------------------
        */

        const addressCards =
            document.querySelectorAll(
                '.checkout-address-card'
            );


        const addressRadios =
            document.querySelectorAll(
                '.checkout-address-radio'
            );


        const customerName =
            document.getElementById(
                'customerName'
            );


        const customerPhone =
            document.getElementById(
                'customerPhone'
            );


        const shippingAddress =
            document.getElementById(
                'shippingAddress'
            );


        function setSelectedAddressCard(
            input
        ) {

            addressCards
                .forEach(
                    function (card) {

                        card
                            .classList
                            .remove(
                                'selected'
                            );

                    }
                );


            const currentCard =
                input.closest(
                    '.checkout-address-card'
                );


            if (currentCard) {

                currentCard
                    .classList
                    .add(
                        'selected'
                    );

            }

        }


        function applySavedAddress(
            input
        ) {

            setSelectedAddressCard(
                input
            );


            if (
                input.value
                ===
                'other'
            ) {

                customerName.value =
                    '';


                customerPhone.value =
                    '';


                shippingAddress.value =
                    '';


                customerName.focus();

                return;

            }


            customerName.value =
                input.dataset.name
                ||
                '';


            customerPhone.value =
                input.dataset.phone
                ||
                '';


            shippingAddress.value =
                input.dataset.address
                ||
                '';

        }


        addressRadios
            .forEach(
                function (input) {

                    input
                        .addEventListener(
                            'change',
                            function () {

                                applySavedAddress(
                                    input
                                );

                            }
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | KHÔNG GHI ĐÈ OLD INPUT KHI VALIDATION FAIL
        |--------------------------------------------------------------------------
        | Chỉ đồng bộ trạng thái selected của card khi load.
        */

        const checkedAddress =
            document.querySelector(
                '.checkout-address-radio:checked'
            );


        if (checkedAddress) {

            setSelectedAddressCard(
                checkedAddress
            );

        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL VALUES
        |--------------------------------------------------------------------------
        */

        const initialVoucher =
            voucherInput
            ? voucherInput.value.trim()
            : '';


        if (
            initialVoucher
            !==
            ''
        ) {

            calculateVoucher(
                initialVoucher,
                true
            );

        }
        else {

            updateTotal();

        }


        updatePaymentMethod();


        /*
        |--------------------------------------------------------------------------
        | PREVENT DOUBLE SUBMIT
        |--------------------------------------------------------------------------
        */

        const checkoutForm =
            document.getElementById(
                'checkoutForm'
            );


        if (
            checkoutForm
            &&
            orderButton
        ) {

            checkoutForm
                .addEventListener(
                    'submit',
                    function () {

                        orderButton.disabled =
                            true;


                        const selectedPayment =
                            document.querySelector(
                                'input[name="payment_method"]:checked'
                            );


                        if (
                            selectedPayment
                            &&
                            selectedPayment.value
                            ===
                            'bank'
                        ) {

                            orderButton.textContent =
                                'Đang tạo đơn và QR...';

                        }
                        else {

                            orderButton.textContent =
                                'Đang tạo đơn hàng...';

                        }

                    }
                );

        }

    }
);
</script>

@endsection
