@extends('layouts.app')

@section('title', $product->name . ' | Tinh Hoa Tây Bắc')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | GALLERY SẢN PHẨM
    |--------------------------------------------------------------------------
    */

   $gallery = collect();


/*
|--------------------------------------------------------------------------
| ẢNH ĐẠI DIỆN
|--------------------------------------------------------------------------
*/

if (
    $product->image
    &&
    Storage::disk('public')->exists(
        $product->image
    )
) {

    $gallery->push([
        'url' =>
            Storage::disk('public')->url(
                $product->image
            ),

        'alt' =>
            $product->name
            . ' - ảnh đại diện',
    ]);

}


/*
|--------------------------------------------------------------------------
| ẢNH CHI TIẾT
|--------------------------------------------------------------------------
*/

foreach ($product->images as $galleryImage) {

    if (
        $galleryImage->path
        &&
        Storage::disk('public')->exists(
            $galleryImage->path
        )
    ) {

        $gallery->push([
            'url' =>
                Storage::disk('public')->url(
                    $galleryImage->path
                ),

            'alt' =>
                $product->name
                . ' - ảnh chi tiết',
        ]);

    }

}


    /*
    |--------------------------------------------------------------------------
    | REVIEW
    |--------------------------------------------------------------------------
    */

    $reviews =
        $product
            ->reviews()

            ->with('user')

            ->latest()

            ->get();


    $reviewCount =
        $reviews->count();


    $averageRating =
        $reviewCount > 0

        ? round(
            (float)
            $reviews->avg('rating'),
            1
        )

        : 0;


    $myReview =
        Auth::check()

        ? $reviews->firstWhere(
            'user_id',
            Auth::id()
        )

        : null;


    /*
    |--------------------------------------------------------------------------
    | SẢN PHẨM TƯƠNG TỰ
    |--------------------------------------------------------------------------
    */

    $relatedProducts =
        \App\Models\Product::query()

            ->where(
                'category_id',
                $product->category_id
            )

            ->where(
                'id',
                '!=',
                $product->id
            )

            ->orderBy('name')

            ->limit(4)

            ->get();


    /*
    |--------------------------------------------------------------------------
    | QUY CÁCH BÁN
    |--------------------------------------------------------------------------
    */

    $minQty =
        (float)
        (
            $product->min_quantity
            ??
            1
        );


    $stepQty =
        (float)
        (
            $product->quantity_step
            ??
            1
        );


    $stockQty =
        (float)
        $product->quantity;


    $stockText =
        rtrim(
            rtrim(
                number_format(
                    $stockQty,
                    2,
                    '.',
                    ''
                ),
                '0'
            ),
            '.'
        );


    $soldText =
        rtrim(
            rtrim(
                number_format(
                    (float)
                    $product->sold_quantity,
                    2,
                    '.',
                    ''
                ),
                '0'
            ),
            '.'
        );

@endphp


<style>
    .ecom-product-page {
        --brown: #5f341d;
        --green: #48633b;
        --red: #aa3c2e;
        --gold: #e3ad4a;
        --border: #ead8bf;
        --ink: #32241c;
        --muted: #76685e;

        padding:
            24px 0 66px;
    }

    .ecom-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 18px;

        color: #8b7a6f;

        font-size: 12px;
    }

    .ecom-breadcrumb a {
        color: #654128;

        text-decoration: none;

        font-weight: 800;
    }

    .ecom-breadcrumb a:hover {
        color: var(--red);
    }

    .product-market-card {
        overflow: hidden;

        border:
            1px solid var(--border);

        border-radius: 26px;

        background: #fff;

        box-shadow:
            0 18px 48px
            rgba(77,47,28,.09);
    }

    .product-market-body {
        padding: 30px;
    }


    /* =========================================================
       GALLERY
    ========================================================= */

    .product-gallery-layout {
        display: grid;

        grid-template-columns:
            82px
            minmax(0,1fr);

        gap: 14px;

        position: sticky;

        top: 145px;
    }

    .product-thumbnails {
        display: flex;

        flex-direction: column;

        gap: 10px;

        max-height: 555px;

        overflow-y: auto;

        padding-right: 2px;

        scrollbar-width: thin;
    }

    .product-thumb {
        width: 76px;
        height: 76px;

        flex:
            0 0 76px;

        padding: 4px;

        overflow: hidden;

        border:
            1px solid #e4d4c0;

        border-radius: 12px;

        background: #fff;

        cursor: pointer;

        transition:
            .18s ease;
    }

    .product-thumb img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        border-radius: 8px;
    }

    .product-thumb:hover,
    .product-thumb.active {
        border-color:
            #b56a35;

        box-shadow:
            0 0 0 2px
            rgba(181,106,53,.13);

        transform:
            translateY(-1px);
    }

    .product-main-image-box {
        position: relative;

        min-height: 545px;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        border:
            1px solid #ead8bf;

        border-radius: 22px;

        background:
            radial-gradient(
                circle at 82% 17%,
                rgba(242,193,92,.18),
                transparent 28%
            ),

            linear-gradient(
                145deg,
                #fffdf8,
                #fff7eb
            );
    }

    .product-main-image {
        width: 100%;
        height: 545px;

        padding: 22px;

        object-fit: contain;

        cursor: zoom-in;

        filter:
            drop-shadow(
                0 14px 22px
                rgba(95,52,29,.10)
            );

        transition:
            transform .25s ease;
    }

    .product-main-image:hover {
        transform:
            scale(1.025);
    }

    .gallery-nav-btn {
        position: absolute;

        z-index: 4;

        top: 50%;

        width: 42px;
        height: 42px;

        display: grid;
        place-items: center;

        border:
            1px solid rgba(95,52,29,.14);

        border-radius: 50%;

        color: #5f341d;

        background:
            rgba(255,255,255,.92);

        box-shadow:
            0 8px 20px
            rgba(68,42,25,.12);

        transform:
            translateY(-50%);

        transition:
            .18s ease;
    }

    .gallery-nav-btn:hover {
        color: #fff;

        background:
            var(--brown);
    }

    .gallery-nav-btn.prev {
        left: 14px;
    }

    .gallery-nav-btn.next {
        right: 14px;
    }

    .gallery-count {
        position: absolute;

        right: 14px;
        bottom: 14px;

        z-index: 4;

        padding:
            7px 10px;

        border-radius: 999px;

        color: #fff;

        background:
            rgba(48,34,25,.78);

        font-size: 11px;

        font-weight: 900;

        backdrop-filter:
            blur(7px);
    }

    .product-no-image {
        min-height: 545px;

        width: 100%;

        display: grid;
        place-items: center;

        color: #7d6d62;

        text-align: center;
    }

    .product-no-image-mark {
        font-size: 64px;
    }


    /* =========================================================
       PRODUCT INFO
    ========================================================= */

    .product-category-chip {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            7px 11px;

        border:
            1px solid #e7d1b2;

        border-radius: 999px;

        color: #684126;

        background:
            #fff8e9;

        font-size: 11px;

        font-weight: 900;
    }

    .product-title-shop {
        margin:
            14px 0 10px;

        color: var(--ink);

        font-size:
            clamp(29px,3vw,42px);

        line-height: 1.12;

        font-weight: 950;

        letter-spacing: -.045em;
    }

    .product-rating-line {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 9px;

        padding-bottom: 16px;

        border-bottom:
            1px solid #efe2d1;

        color: #766a62;

        font-size: 12px;
    }

    .product-stars {
        color: #e8a20f;

        letter-spacing: 1px;

        font-size: 17px;
    }

    .sold-chip {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            5px 9px;

        border-radius: 999px;

        color: #9a4624;

        background:
            #fff2df;

        font-weight: 900;
    }

    .product-short-copy {
        margin:
            17px 0;

        color: #6c6059;

        font-size: 14px;

        line-height: 1.75;
    }


    /* =========================================================
       PRICE / CART
    ========================================================= */

    .purchase-panel {
        overflow: hidden;

        border:
            1px solid #e7d1b3;

        border-radius: 20px;

        background: #fffdf9;
    }

    .price-panel {
        padding: 20px;

        background:
            radial-gradient(
                circle at 95% 10%,
                rgba(242,193,92,.18),
                transparent 32%
            ),

            linear-gradient(
                135deg,
                #fffaf0,
                #f8efe2
            );
    }

    .price-label {
        color: #8c7b6f;

        font-size: 11px;
    }

    .price-main-shop {
        color: var(--red);

        font-size:
            clamp(29px,3vw,38px);

        font-weight: 950;

        letter-spacing: -.03em;
    }

    .price-unit {
        color: #5f402b;

        font-size: 12px;

        font-weight: 800;
    }

    .old-price-shop {
        color: #948982;

        font-size: 13px;

        text-decoration:
            line-through;
    }

    .sale-chip {
        display: inline-flex;

        margin-left: 7px;

        padding:
            4px 7px;

        border-radius: 8px;

        color: #fff;

        background:
            var(--red);

        font-size: 10px;

        font-weight: 950;
    }

    .stock-chip {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            7px 10px;

        border-radius: 999px;

        color: #37632f;

        background:
            #edf6e9;

        font-size: 11px;

        font-weight: 900;
    }

    .stock-chip::before {
        content: "";

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background:
            #5d8c50;
    }

    .stock-chip.out {
        color: #9d3f34;

        background:
            #fff0ed;
    }

    .stock-chip.out::before {
        background:
            #b64b3e;
    }

    .commerce-benefits {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0,1fr)
            );

        border-top:
            1px solid #ead8bf;

        border-bottom:
            1px solid #ead8bf;

        background: #fff;
    }

    .commerce-benefit {
        padding:
            12px 8px;

        text-align: center;

        color: #604129;

        font-size: 10px;

        font-weight: 850;
    }

    .commerce-benefit:not(:last-child) {
        border-right:
            1px solid #eee1cf;
    }

    .purchase-body {
        padding: 20px;
    }

    .quantity-heading {
        color: var(--ink);

        font-size: 13px;

        font-weight: 900;
    }

    .quantity-hint {
        margin-top: 3px;

        color: #8a7b70;

        font-size: 10px;
    }

    .quantity-control-shop {
        display: inline-flex;

        overflow: hidden;

        border:
            1px solid #d9c5aa;

        border-radius: 11px;

        background: #fff;
    }

    .quantity-control-shop button {
        width: 45px;
        height: 45px;

        border: 0;

        color: #5f341d;

        background:
            #f8efe2;

        font-size: 20px;

        font-weight: 900;
    }

    .quantity-control-shop input {
        width: 105px;
        height: 45px;

        border: 0;

        border-left:
            1px solid #e5d5c1;

        border-right:
            1px solid #e5d5c1;

        outline: 0;

        text-align: center;

        font-weight: 900;
    }

    .order-total-shop {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin:
            16px 0;

        padding:
            13px 14px;

        border:
            1px dashed #dfbb77;

        border-radius: 13px;

        background:
            #fff7e6;
    }

    .live-total-shop {
        color: var(--red);

        font-size: 23px;

        font-weight: 950;
    }

    .btn-add-cart-shop {
        min-height: 51px;

        width: 100%;

        border: 0;

        border-radius: 12px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #b43c2e,
                #6d291f
            );

        box-shadow:
            0 10px 22px
            rgba(168,59,45,.18);

        font-size: 13px;

        font-weight: 950;

        transition:
            .18s ease;
    }

    .btn-add-cart-shop:hover {
        color: #fff;

        transform:
            translateY(-1px);
    }

    .trust-grid-shop {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0,1fr)
            );

        gap: 8px;

        margin-top: 12px;
    }

    .trust-item-shop {
        padding: 10px;

        border:
            1px solid #eee1d0;

        border-radius: 11px;

        color: #67462e;

        background: #fff;

        font-size: 10px;

        font-weight: 800;
    }

    .product-facts-shop {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0,1fr)
            );

        gap: 9px;

        margin-top: 14px;
    }

    .product-fact-shop {
        padding: 11px;

        border:
            1px solid #eee1cf;

        border-radius: 11px;

        background:
            #fffdf9;
    }

    .product-fact-shop small {
        display: block;

        margin-bottom: 2px;

        color: #94857a;

        font-size: 9px;
    }

    .product-fact-shop strong {
        color: #51382a;

        font-size: 11px;
    }

    .admin-mode-shop {
        margin-bottom: 14px;

        padding: 13px;

        border:
            1px solid #efd897;

        border-radius: 12px;

        color: #6f4a19;

        background:
            #fff8df;

        font-size: 12px;
    }


    /* =========================================================
       CONTENT SECTION
    ========================================================= */

    .shop-detail-section {
        margin-top: 26px;

        overflow: hidden;

        border:
            1px solid var(--border);

        border-radius: 22px;

        background: #fff;

        box-shadow:
            0 12px 34px
            rgba(77,47,28,.06);
    }

    .shop-detail-section-body {
        padding: 28px;
    }

    .shop-section-title {
        position: relative;

        margin:
            0 0 20px;

        padding-bottom: 12px;

        color: var(--ink);

        font-size: 22px;

        font-weight: 950;
    }

    .shop-section-title::after {
        content: "";

        position: absolute;

        left: 0;
        bottom: 0;

        width: 76px;
        height: 3px;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                var(--red),
                var(--gold),
                var(--green)
            );
    }

    .product-description-shop {
        color: #625852;

        font-size: 15px;

        line-height: 1.9;

        white-space: pre-line;
    }


    /* =========================================================
       REVIEW
    ========================================================= */

    .review-head-shop {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 22px;
    }

    .review-score-shop {
        min-width: 120px;

        padding: 14px;

        border:
            1px solid #ead8bf;

        border-radius: 15px;

        text-align: center;

        background:
            #fff8ea;
    }

    .review-score-number {
        color: var(--red);

        font-size: 32px;

        line-height: 1;

        font-weight: 950;
    }

    .review-form-shop {
        margin-bottom: 22px;

        padding: 20px;

        border:
            1px solid #ead8bf;

        border-radius: 16px;

        background:
            #fffdf9;
    }

    .star-rating-input {
        display: flex;

        flex-direction:
            row-reverse;

        justify-content:
            flex-end;

        gap: 4px;
    }

    .star-rating-input input {
        display: none;
    }

    .star-rating-input label {
        margin: 0;

        color: #d8d3ce;

        font-size: 32px;

        cursor: pointer;
    }

    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label,
    .star-rating-input input:checked ~ label {
        color: #e8a20f;
    }

    .review-item-shop {
        padding:
            18px 0;

        border-bottom:
            1px solid #eee2d2;
    }

    .review-item-shop:last-child {
        border-bottom: 0;
    }

    .review-avatar-shop {
        width: 42px;
        height: 42px;

        flex:
            0 0 42px;

        display: grid;
        place-items: center;

        border-radius: 50%;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #5f341d,
                #48633b
            );

        font-weight: 950;
    }


    .product-reviews-compact .shop-detail-section-body {
        padding: 20px;
    }

    .product-reviews-compact .review-head-shop {
        gap: 12px;
        margin-bottom: 12px;
    }

    .product-reviews-compact .shop-section-title {
        padding-bottom: 8px;
        font-size: 20px;
    }

    .product-reviews-compact .review-score-shop {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        min-width: 0;
        padding: 10px 12px;
    }

    .product-reviews-compact .review-score-number {
        font-size: 24px;
    }

    .product-reviews-compact .review-score-shop .mt-1 {
        margin-top: 0 !important;
    }

    .product-reviews-compact .review-score-shop .product-stars {
        font-size: 16px;
        white-space: nowrap;
    }

    .product-reviews-compact .review-form-shop {
        margin-bottom: 12px;
        padding: 14px;
    }

    .product-reviews-compact .star-rating-input label {
        font-size: 26px;
    }

    .product-reviews-compact .review-item-shop {
        padding: 12px 0;
    }

    .product-reviews-compact .review-empty-shop {
        padding: 12px 0 0;
        border-top: 1px solid var(--border);
    }

    /* =========================================================
       RELATED
    ========================================================= */

    .related-grid-shop {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0,1fr)
            );

        gap: 16px;
    }

    .related-card-shop {
        overflow: hidden;

        border:
            1px solid #ead8bf;

        border-radius: 16px;

        background: #fff;

        transition:
            .2s ease;
    }

    .related-card-shop:hover {
        transform:
            translateY(-5px);

        box-shadow:
            0 15px 30px
            rgba(77,47,28,.11);
    }

    .related-image-shop {
        position: relative;

        height: 185px;

        overflow: hidden;

        background:
            #fff8ed;
    }

    .related-image-shop img {
        width: 100%;
        height: 100%;

        object-fit: contain;

        padding: 10px;
    }

    .related-body-shop {
        padding: 14px;
    }

    .related-name-shop {
        min-height: 42px;

        display:
            -webkit-box;

        -webkit-line-clamp: 2;

        -webkit-box-orient:
            vertical;

        overflow: hidden;

        color: var(--ink);

        font-size: 13px;

        font-weight: 900;
    }

    .related-name-shop:hover {
        color: var(--red);
    }


    /* =========================================================
       LIGHTBOX
    ========================================================= */

    .gallery-lightbox {
        position: fixed;

        z-index: 9999;

        inset: 0;

        display: none;

        align-items: center;
        justify-content: center;

        padding: 24px;

        background:
            rgba(20,14,10,.92);

        backdrop-filter:
            blur(7px);
    }

    .gallery-lightbox.show {
        display: flex;
    }

    .gallery-lightbox-image {
        max-width:
            min(1100px,88vw);

        max-height: 86vh;

        object-fit: contain;

        border-radius: 14px;

        box-shadow:
            0 25px 70px
            rgba(0,0,0,.45);
    }

    .lightbox-close,
    .lightbox-nav {
        position: absolute;

        display: grid;
        place-items: center;

        border:
            1px solid rgba(255,255,255,.2);

        color: #fff;

        background:
            rgba(255,255,255,.09);

        backdrop-filter:
            blur(8px);
    }

    .lightbox-close {
        top: 22px;
        right: 22px;

        width: 44px;
        height: 44px;

        border-radius: 50%;

        font-size: 22px;
    }

    .lightbox-nav {
        top: 50%;

        width: 48px;
        height: 48px;

        border-radius: 50%;

        transform:
            translateY(-50%);

        font-size: 27px;
    }

    .lightbox-nav.prev {
        left: 22px;
    }

    .lightbox-nav.next {
        right: 22px;
    }

    .lightbox-counter {
        position: absolute;

        left: 50%;
        bottom: 20px;

        padding:
            7px 12px;

        border-radius: 999px;

        color: #fff;

        background:
            rgba(255,255,255,.09);

        transform:
            translateX(-50%);

        font-size: 11px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .product-gallery-layout {
            position: relative;

            top: auto;
        }

        .product-main-image-box,
        .product-main-image,
        .product-no-image {
            min-height: 470px;

            height: 470px;
        }

    }


    @media (max-width: 991.98px) {

        .product-gallery-layout {
            grid-template-columns:
                1fr;
        }

        .product-thumbnails {
            order: 2;

            flex-direction: row;

            max-height: none;

            overflow-x: auto;

            padding:
                2px 0 4px;
        }

        .product-thumb {
            width: 68px;
            height: 68px;

            flex-basis: 68px;
        }

        .related-grid-shop {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0,1fr)
                );
        }

    }


    @media (max-width: 575.98px) {

        .ecom-product-page {
            padding-top: 12px;
        }

        .product-market-card,
        .shop-detail-section {
            border-radius: 18px;
        }

        .product-market-body,
        .shop-detail-section-body {
            padding: 18px;
        }

        .product-main-image-box,
        .product-main-image,
        .product-no-image {
            min-height: 330px;

            height: 330px;
        }

        .product-main-image {
            padding: 13px;
        }

        .commerce-benefits,
        .trust-grid-shop,
        .product-facts-shop {
            grid-template-columns:
                1fr;
        }

        .commerce-benefit:not(:last-child) {
            border-right: 0;

            border-bottom:
                1px solid #eee1cf;
        }

        .review-head-shop {
            align-items:
                flex-start;

            flex-direction:
                column;
        }

        .related-grid-shop {
            grid-template-columns:
                1fr;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
        }

        .lightbox-nav.prev {
            left: 8px;
        }

        .lightbox-nav.next {
            right: 8px;
        }

    }
</style>


<div class="ecom-product-page container">


    {{-- BREADCRUMB --}}
    <div class="ecom-breadcrumb">

        <a href="{{ route('welcome') }}">
            Trang chủ
        </a>

        <span>›</span>

        <a href="{{ route('products.index') }}">
            Sản phẩm
        </a>

        <span>›</span>

        <span>
            {{ $product->name }}
        </span>

    </div>


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- =====================================================
        KHỐI SẢN PHẨM CHÍNH
    ====================================================== --}}
    <div class="product-market-card">

        <div class="product-market-body">

            <div
                class="
                    row
                    g-4
                    g-xl-5
                    align-items-start
                "
            >


                {{-- =========================
                    GALLERY
                ========================== --}}
                <div class="col-lg-6">


                    @if($gallery->isNotEmpty())

                        <div class="product-gallery-layout">


                            {{-- THUMBNAILS --}}
                            <div
                                class="product-thumbnails"
                                id="productThumbnails"
                            >

                                @foreach($gallery as $galleryItem)

                                    <button
                                        type="button"
                                        class="
                                            product-thumb
                                            {{
                                                $loop->first
                                                ? 'active'
                                                : ''
                                            }}
                                        "
                                        data-gallery-index="{{
                                            $loop->index
                                        }}"
                                        aria-label="
                                            Xem ảnh
                                            {{ $loop->iteration }}
                                        "
                                    >

                                        <img
                                            src="{{
                                                $galleryItem['url']
                                            }}"
                                            alt="{{
                                                $galleryItem['alt']
                                            }}"
                                            loading="lazy"
                                        >

                                    </button>

                                @endforeach

                            </div>


                            {{-- MAIN --}}
                            <div class="product-main-image-box">

                                <img
                                    id="productMainImage"
                                    src="{{
                                        $gallery
                                            ->first()['url']
                                    }}"
                                    alt="{{
                                        $gallery
                                            ->first()['alt']
                                    }}"
                                    class="product-main-image"
                                >


                                @if($gallery->count() > 1)

                                    <button
                                        type="button"
                                        class="
                                            gallery-nav-btn
                                            prev
                                        "
                                        id="galleryPrev"
                                        aria-label="Ảnh trước"
                                    >
                                        ‹
                                    </button>


                                    <button
                                        type="button"
                                        class="
                                            gallery-nav-btn
                                            next
                                        "
                                        id="galleryNext"
                                        aria-label="Ảnh tiếp theo"
                                    >
                                        ›
                                    </button>

                                @endif


                                <div
                                    class="gallery-count"
                                    id="galleryCount"
                                >
                                    1 /
                                    {{ $gallery->count() }}
                                </div>

                            </div>

                        </div>


                    @else

                        <div class="product-main-image-box">

                            <div class="product-no-image">

                                <div>

                                    <div class="product-no-image-mark">
                                        🧺
                                    </div>

                                    <strong>
                                        Sản phẩm chưa có ảnh
                                    </strong>

                                </div>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- =========================
                    THÔNG TIN SẢN PHẨM
                ========================== --}}
                <div class="col-lg-6">


                    <span class="product-category-chip">

                        🌿
                        {{
                            $product
                                ->category
                                ?->name
                            ??
                            'Chưa phân loại'
                        }}

                    </span>


                    <h1 class="product-title-shop">

                        {{ $product->name }}

                    </h1>


                    <div class="product-rating-line">

                        <span class="product-stars">

                            @for(
                                $i = 1;
                                $i <= 5;
                                $i++
                            )

                                {{
                                    $i
                                    <=
                                    round($averageRating)

                                    ? '★'
                                    : '☆'
                                }}

                            @endfor

                        </span>


                        <strong>
                            {{
                                number_format(
                                    $averageRating,
                                    1
                                )
                            }}/5
                        </strong>


                        <span>
                            {{ $reviewCount }}
                            đánh giá
                        </span>


                        <span class="sold-chip">

                            🔥 Đã bán
                            {{ $soldText }}
                            {{ $product->unit }}

                        </span>

                    </div>


                    <div class="product-short-copy">

                        {{
                            \Illuminate\Support\Str::limit(
                                $product->description
                                ??
                                'Đặc sản Tây Bắc tuyển chọn, mang hương vị đặc trưng của vùng cao.',
                                190
                            )
                        }}

                    </div>


                    @if(
                        Auth::check()
                        &&
                        Auth::user()->role
                        ===
                        'admin'
                    )

                        <div class="admin-mode-shop">

                            👑 Bạn đang xem sản phẩm
                            với quyền quản trị viên.

                        </div>

                    @endif


                    {{-- PURCHASE PANEL --}}
                    <div class="purchase-panel">


                        {{-- PRICE --}}
                        <div class="price-panel">

                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    align-items-start
                                    gap-3
                                    flex-wrap
                                "
                            >

                                <div>

                                    <div class="price-label mb-1">
                                        Giá bán
                                    </div>


                                    @if($product->isOnSale())

                                        <div class="mb-1">

                                            <span class="old-price-shop">

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

                                            </span>


                                            <span class="sale-chip">

                                                -{{
                                                    $product
                                                        ->getDiscountPercent()
                                                }}%

                                            </span>

                                        </div>

                                    @endif


                                    <div>

                                        <span class="price-main-shop">

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

                                        </span>


                                        <span class="price-unit">

                                            /
                                            {{
                                                $product->unit
                                                ??
                                                'sản phẩm'
                                            }}

                                        </span>

                                    </div>

                                </div>


                                <div class="text-end">

                                    <div class="price-label mb-2">
                                        Tình trạng
                                    </div>


                                    <span
                                        class="
                                            stock-chip
                                            {{
                                                $stockQty <= 0
                                                ? 'out'
                                                : ''
                                            }}
                                        "
                                    >

                                        @if($stockQty > 0)

                                            Còn
                                            {{ $stockText }}
                                            {{
                                                $product->unit
                                                ??
                                                'sản phẩm'
                                            }}

                                        @else

                                            Hết hàng

                                        @endif

                                    </span>

                                </div>

                            </div>

                        </div>


                        @if(
                            !Auth::check()
                            ||
                            Auth::user()->role
                            !==
                            'admin'
                        )

                            <div class="commerce-benefits">

                                <div class="commerce-benefit">
                                    🚚 Giao hàng toàn quốc
                                </div>

                                <div class="commerce-benefit">
                                    💳 COD / chuyển khoản
                                </div>

                                <div class="commerce-benefit">
                                    🌿 Đặc sản chọn lọc
                                </div>

                            </div>

                        @endif


                        {{-- ADMIN --}}
                        @if(
                            Auth::check()
                            &&
                            Auth::user()->role
                            ===
                            'admin'
                        )

                            <div class="purchase-body">

                                <div class="d-grid gap-2">

                                    <a
                                        href="{{
                                            route(
                                                'admin.products.edit',
                                                $product
                                            )
                                        }}"
                                        class="
                                            btn
                                            btn-warning
                                            fw-bold
                                        "
                                    >
                                        ✏️ Chỉnh sửa sản phẩm
                                    </a>


                                    <a
                                        href="{{
                                            route(
                                                'admin.products.index'
                                            )
                                        }}"
                                        class="
                                            btn
                                            btn-outline-secondary
                                        "
                                    >
                                        ⚙️ Quản lý sản phẩm
                                    </a>

                                </div>

                            </div>


                        {{-- CUSTOMER --}}
                        @elseif(Auth::check())

                            <div class="purchase-body">

                                <form
                                    action="{{
                                        route(
                                            'cart.add',
                                            $product->id
                                        )
                                    }}"
                                    method="POST"
                                    id="addToCartForm"
                                >

                                    @csrf


                                    <div
                                        class="
                                            d-flex
                                            justify-content-between
                                            align-items-center
                                            flex-wrap
                                            gap-3
                                        "
                                    >

                                        <div>

                                            <div class="quantity-heading">

                                                {{
                                                    (
                                                        $product->unit
                                                        ??
                                                        ''
                                                    )
                                                    ===
                                                    'kg'

                                                    ? '⚖️ Chọn khối lượng'

                                                    : '📦 Chọn số lượng'
                                                }}

                                            </div>


                                            <div class="quantity-hint">

                                                Tối thiểu
                                                {{ $minQty }}
                                                {{
                                                    $product->unit
                                                    ??
                                                    'sản phẩm'
                                                }}

                                                · bước
                                                {{ $stepQty }}
                                                {{
                                                    $product->unit
                                                    ??
                                                    'sản phẩm'
                                                }}

                                            </div>

                                        </div>


                                        <div class="quantity-control-shop">

                                            <button
                                                type="button"
                                                id="minusBtn"
                                                aria-label="Giảm số lượng"
                                            >
                                                −
                                            </button>


                                            <input
                                                type="number"
                                                id="buyQuantity"
                                                name="quantity"
                                                value="{{ $minQty }}"
                                                min="{{ $minQty }}"
                                                max="{{ $stockQty }}"
                                                step="{{ $stepQty }}"
                                                required
                                            >


                                            <button
                                                type="button"
                                                id="plusBtn"
                                                aria-label="Tăng số lượng"
                                            >
                                                +
                                            </button>

                                        </div>

                                    </div>


                                    <div class="order-total-shop">

                                        <div>

                                            <div class="price-label">
                                                Thành tiền
                                            </div>

                                            <div
                                                class="live-total-shop"
                                                id="liveTotal"
                                            >
                                                0 đ
                                            </div>

                                        </div>


                                        <strong id="quantityText">

                                            {{ $minQty }}
                                            {{
                                                $product->unit
                                                ??
                                                'sản phẩm'
                                            }}

                                        </strong>

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn-add-cart-shop"
                                        {{
                                            $stockQty <= 0
                                            ? 'disabled'
                                            : ''
                                        }}
                                    >

                                        @if($stockQty > 0)

                                            🛒 THÊM VÀO GIỎ HÀNG

                                        @else

                                            SẢN PHẨM ĐÃ HẾT HÀNG

                                        @endif

                                    </button>

                                </form>


                                <div class="trust-grid-shop">

                                    <div class="trust-item-shop">
                                        🛡️ Nguồn gốc rõ ràng
                                    </div>

                                    <div class="trust-item-shop">
                                        📦 Đóng gói cẩn thận
                                    </div>

                                    <div class="trust-item-shop">
                                        💵 Thanh toán linh hoạt
                                    </div>

                                    <div class="trust-item-shop">
                                        ☎️ Hỗ trợ khi cần
                                    </div>

                                </div>

                            </div>


                        {{-- GUEST --}}
                        @else

                            <div class="purchase-body">

                                <a
                                    href="{{ route('login') }}"
                                    class="
                                        btn
                                        btn-warning
                                        btn-lg
                                        w-100
                                        fw-bold
                                    "
                                >
                                    🔐 Đăng nhập để mua sản phẩm
                                </a>


                                <div class="trust-grid-shop">

                                    <div class="trust-item-shop">
                                        🚚 Giao hàng toàn quốc
                                    </div>

                                    <div class="trust-item-shop">
                                        💳 COD / chuyển khoản
                                    </div>

                                    <div class="trust-item-shop">
                                        🌿 Đặc sản Tây Bắc
                                    </div>

                                    <div class="trust-item-shop">
                                        📦 Theo dõi đơn hàng
                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>


                    {{-- FACTS --}}
                    <div class="product-facts-shop">

                        <div class="product-fact-shop">

                            <small>
                                Danh mục
                            </small>

                            <strong>
                                {{
                                    $product
                                        ->category
                                        ?->name
                                    ??
                                    'Chưa phân loại'
                                }}
                            </strong>

                        </div>


                        <div class="product-fact-shop">

                            <small>
                                Đơn vị bán
                            </small>

                            <strong>
                                {{
                                    $product->unit
                                    ??
                                    'sản phẩm'
                                }}
                            </strong>

                        </div>


                        <div class="product-fact-shop">

                            <small>
                                Ảnh sản phẩm
                            </small>

                            <strong>
                                {{ $gallery->count() }}
                                ảnh
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        DESCRIPTION
    ====================================================== --}}
    <section class="shop-detail-section">

        <div class="shop-detail-section-body">

            <h2 class="shop-section-title">
                Thông tin chi tiết sản phẩm
            </h2>


            <div class="product-description-shop">

                {{
                    $product->description
                    ??
                    'Chưa có mô tả chi tiết cho sản phẩm này.'
                }}

            </div>

        </div>

    </section>


    {{-- =====================================================
        RELATED PRODUCTS
    ====================================================== --}}
    @if($relatedProducts->isNotEmpty())

        <section class="shop-detail-section">

            <div class="shop-detail-section-body">


                <div
                    class="
                        d-flex
                        justify-content-between
                        align-items-end
                        flex-wrap
                        gap-3
                        mb-4
                    "
                >

                    <div>

                        <h2 class="shop-section-title mb-1">
                            Sản phẩm tương tự
                        </h2>

                        <div class="text-muted small">

                            Khám phá thêm sản phẩm trong

                            {{
                                $product
                                    ->category
                                    ?->name
                                ??
                                'cùng danh mục'
                            }}.

                        </div>

                    </div>


                    <a
                        href="{{
                            route(
                                'products.index',
                                [
                                    'category_id'
                                    =>
                                    $product->category_id
                                ]
                            )
                        }}"
                        class="
                            btn
                            btn-outline-secondary
                        "
                    >
                        Xem thêm →
                    </a>

                </div>


                <div class="related-grid-shop">


                    @foreach($relatedProducts as $related)

                        <article class="related-card-shop">


                            <a
                                href="{{
                                    route(
                                        'products.show',
                                        $related
                                    )
                                }}"
                            >

                                <div class="related-image-shop">


                                    @if(
                                        $related->image
                                        &&
                                        Storage::disk('public')
                                            ->exists(
                                                $related->image
                                            )
                                    )

                                        <img
                                            src="{{
                                                Storage::disk('public')
                                                    ->url(
                                                        $related->image
                                                    )
                                            }}"
                                            alt="{{ $related->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <div
                                            style="
                                                height:100%;
                                                display:grid;
                                                place-items:center;
                                                color:#8b7c72;
                                            "
                                        >
                                            🧺 Chưa có ảnh
                                        </div>

                                    @endif


                                    @if($related->isOnSale())

                                        <span
                                            class="
                                                badge
                                                bg-danger
                                                position-absolute
                                                top-0
                                                start-0
                                                m-2
                                            "
                                        >
                                            -{{
                                                $related
                                                    ->getDiscountPercent()
                                            }}%
                                        </span>

                                    @endif

                                </div>

                            </a>


                            <div class="related-body-shop">

                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $related
                                        )
                                    }}"
                                    class="related-name-shop"
                                >
                                    {{ $related->name }}
                                </a>


                                <div class="small text-warning mt-2">

                                    ★
                                    {{
                                        number_format(
                                            round(
                                                (float)
                                                $related
                                                    ->reviews()
                                                    ->avg('rating'),
                                                1
                                            ),
                                            1
                                        )
                                    }}

                                </div>


                                <div class="mt-2">


                                    @if($related->isOnSale())

                                        <div
                                            class="
                                                small
                                                text-muted
                                                text-decoration-line-through
                                            "
                                        >
                                            {{
                                                number_format(
                                                    (float)
                                                    $related->price,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                            đ
                                        </div>

                                    @endif


                                    <strong
                                        style="
                                            color:#a83b2d;
                                            font-size:17px;
                                        "
                                    >
                                        {{
                                            number_format(
                                                $related
                                                    ->getCurrentPrice(),
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}
                                        đ
                                    </strong>


                                    <span class="small text-muted">

                                        /
                                        {{
                                            $related->unit
                                            ??
                                            'sản phẩm'
                                        }}

                                    </span>

                                </div>


                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $related
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-outline-dark
                                        w-100
                                        mt-3
                                    "
                                >
                                    Xem sản phẩm
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
        REVIEWS
    ====================================================== --}}
    <section class="shop-detail-section product-reviews-compact">

        <div class="shop-detail-section-body">


            <div class="review-head-shop">

                <div>

                    <h2 class="shop-section-title mb-1">
                        Đánh giá sản phẩm
                    </h2>

                    <div class="text-muted small">

                        Nhận xét từ khách hàng
                        đã trải nghiệm sản phẩm.

                    </div>

                </div>


                <div class="review-score-shop">

                    <div class="review-score-number">

                        {{
                            number_format(
                                $averageRating,
                                1
                            )
                        }}

                    </div>


                    <div class="product-stars mt-1">

                        @for(
                            $i = 1;
                            $i <= 5;
                            $i++
                        )

                            {{
                                $i
                                <=
                                round($averageRating)

                                ? '★'
                                : '☆'
                            }}

                        @endfor

                    </div>


                    <div class="small text-muted mt-1">

                        {{ $reviewCount }}
                        đánh giá

                    </div>

                </div>

            </div>


            {{-- REVIEW FORM --}}
            @if(
                Auth::check()
                &&
                Auth::user()->role
                !==
                'admin'
            )

                <div class="review-form-shop">

                    <h5 class="fw-bold mb-3">

                        {{
                            $myReview

                            ? '✏️ Chỉnh sửa đánh giá của bạn'

                            : '✍️ Viết đánh giá'
                        }}

                    </h5>


                    <form
                        action="{{
                            route(
                                'reviews.store',
                                $product->id
                            )
                        }}"
                        method="POST"
                    >

                        @csrf


                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Số sao
                            </label>


                            <div class="star-rating-input">

                                @for(
                                    $star = 5;
                                    $star >= 1;
                                    $star--
                                )

                                    <input
                                        type="radio"
                                        id="rating{{ $star }}"
                                        name="rating"
                                        value="{{ $star }}"
                                        {{
                                            (
                                                (int)
                                                old(
                                                    'rating',
                                                    $myReview?->rating
                                                    ??
                                                    0
                                                )
                                            )
                                            ===
                                            $star

                                            ? 'checked'
                                            : ''
                                        }}
                                        required
                                    >


                                    <label
                                        for="rating{{ $star }}"
                                        title="{{ $star }} sao"
                                    >
                                        ★
                                    </label>

                                @endfor

                            </div>


                            @error('rating')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="mb-3">

                            <label
                                for="comment"
                                class="form-label fw-bold"
                            >
                                Nhận xét
                            </label>


                            <textarea
                                id="comment"
                                name="comment"
                                class="form-control"
                                rows="3"
                                maxlength="1000"
                                placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                            >{{ old('comment', $myReview?->comment) }}</textarea>


                            @error('comment')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="
                                btn
                                btn-dark
                                px-4
                            "
                        >
                            ⭐
                            {{
                                $myReview

                                ? 'Cập nhật đánh giá'

                                : 'Gửi đánh giá'
                            }}
                        </button>

                    </form>

                </div>


            @elseif(!Auth::check())

                <div class="alert alert-light border mb-2">

                    🔐

                    <a
                        href="{{ route('login') }}"
                        class="fw-bold"
                    >
                        Đăng nhập
                    </a>

                    để đánh giá sản phẩm.

                </div>

            @endif


            {{-- REVIEW LIST --}}
            <div>

                @forelse( $reviews as $review)

                    <div class="review-item-shop">

                        <div class="d-flex gap-3">


                            <div class="review-avatar-shop">

                                {{
                                    strtoupper(
                                        substr(
                                            $review
                                                ->user
                                                ?->name
                                            ??
                                            'K',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            </div>


                            <div class="flex-grow-1">


                                <div
                                    class="
                                        d-flex
                                        justify-content-between
                                        align-items-start
                                        gap-3
                                        flex-wrap
                                    "
                                >

                                    <div>

                                        <div class="fw-bold">

                                            {{
                                                $review
                                                    ->user
                                                    ?->name
                                                ??
                                                'Khách hàng'
                                            }}

                                        </div>


                                        <div
                                            class="product-stars"
                                            style="font-size:15px;"
                                        >

                                            @for(
                                                $i = 1;
                                                $i <= 5;
                                                $i++
                                            )

                                                {{
                                                    $i
                                                    <=
                                                    $review->rating

                                                    ? '★'
                                                    : '☆'
                                                }}

                                            @endfor

                                        </div>

                                    </div>


                                    <div class="small text-muted">

                                        {{
                                            $review
                                                ->created_at
                                                ->format(
                                                    'd/m/Y H:i'
                                                )
                                        }}

                                    </div>

                                </div>


                                @if($review->comment)

                                    <p
                                        class="
                                            mb-0
                                            mt-2
                                            text-secondary
                                        "
                                        style="
                                            white-space:pre-line;
                                        "
                                    >
                                        {{ $review->comment }}
                                    </p>

                                @endif


                                @if(
                                    Auth::check()
                                    &&
                                    Auth::user()->role
                                    ===
                                    'admin'
                                )

                                    <form
                                        action="{{
                                            route(
                                                'admin.reviews.destroy',
                                                $review->id
                                            )
                                        }}"
                                        method="POST"
                                        class="mt-2"
                                        onsubmit="
                                            return confirm(
                                                'Bạn có chắc muốn xóa đánh giá này?'
                                            );
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="
                                                btn
                                                btn-sm
                                                btn-outline-danger
                                            "
                                        >
                                            🗑️ Xóa đánh giá
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    </div>


                @empty

                    <div class="review-empty-shop text-muted">
                        <div class="fw-bold">
                            Chưa có đánh giá nào
                        </div>

                        <div class="small">
                            Hãy là người đầu tiên chia sẻ cảm nhận.
                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>

</div>


{{-- =========================================================
    LIGHTBOX
========================================================= --}}
@if($gallery->isNotEmpty())

    <div
        class="gallery-lightbox"
        id="galleryLightbox"
        aria-hidden="true"
    >

        <button
            type="button"
            class="lightbox-close"
            id="lightboxClose"
            aria-label="Đóng"
        >
            ×
        </button>


        @if($gallery->count() > 1)

            <button
                type="button"
                class="
                    lightbox-nav
                    prev
                "
                id="lightboxPrev"
                aria-label="Ảnh trước"
            >
                ‹
            </button>

        @endif


        <img
            src="{{
                $gallery
                    ->first()['url']
            }}"
            alt="{{
                $gallery
                    ->first()['alt']
            }}"
            class="gallery-lightbox-image"
            id="lightboxImage"
        >


        @if($gallery->count() > 1)

            <button
                type="button"
                class="
                    lightbox-nav
                    next
                "
                id="lightboxNext"
                aria-label="Ảnh tiếp theo"
            >
                ›
            </button>

        @endif


        <div
            class="lightbox-counter"
            id="lightboxCounter"
        >
            1 /
            {{ $gallery->count() }}
        </div>

    </div>

@endif


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | PRODUCT GALLERY
        |--------------------------------------------------------------------------
        */

        const galleryImages =
            @json(
                $gallery
                    ->pluck('url')
                    ->values()
            );


        const galleryAlts =
            @json(
                $gallery
                    ->pluck('alt')
                    ->values()
            );


        const mainImage =
            document.getElementById(
                'productMainImage'
            );


        const thumbnails =
            Array.from(
                document.querySelectorAll(
                    '[data-gallery-index]'
                )
            );


        const galleryCount =
            document.getElementById(
                'galleryCount'
            );


        const galleryPrev =
            document.getElementById(
                'galleryPrev'
            );


        const galleryNext =
            document.getElementById(
                'galleryNext'
            );


        const lightbox =
            document.getElementById(
                'galleryLightbox'
            );


        const lightboxImage =
            document.getElementById(
                'lightboxImage'
            );


        const lightboxCounter =
            document.getElementById(
                'lightboxCounter'
            );


        const lightboxClose =
            document.getElementById(
                'lightboxClose'
            );


        const lightboxPrev =
            document.getElementById(
                'lightboxPrev'
            );


        const lightboxNext =
            document.getElementById(
                'lightboxNext'
            );


        let currentIndex = 0;


        function normalizeIndex(index) {

            if (!galleryImages.length) {
                return 0;
            }


            return (
                index
                +
                galleryImages.length
            )
            %
            galleryImages.length;

        }


        function setGalleryImage(index) {

            if (
                !mainImage
                ||
                !galleryImages.length
            ) {
                return;
            }


            currentIndex =
                normalizeIndex(
                    index
                );


            mainImage.src =
                galleryImages[
                    currentIndex
                ];


            mainImage.alt =
                galleryAlts[
                    currentIndex
                ]
                ||
                'Ảnh sản phẩm';


            if (galleryCount) {

                galleryCount.textContent =
                    `${currentIndex + 1} / ${galleryImages.length}`;

            }


            thumbnails.forEach(
                function (
                    thumb,
                    thumbIndex
                ) {

                    thumb.classList.toggle(
                        'active',
                        thumbIndex
                        ===
                        currentIndex
                    );

                }
            );

        }


        thumbnails.forEach(
            function (thumb) {

                thumb.addEventListener(
                    'click',
                    function () {

                        setGalleryImage(
                            Number(
                                this.dataset
                                    .galleryIndex
                            )
                        );

                    }
                );

            }
        );


        if (galleryPrev) {

            galleryPrev.addEventListener(
                'click',
                function () {

                    setGalleryImage(
                        currentIndex
                        -
                        1
                    );

                }
            );

        }


        if (galleryNext) {

            galleryNext.addEventListener(
                'click',
                function () {

                    setGalleryImage(
                        currentIndex
                        +
                        1
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LIGHTBOX
        |--------------------------------------------------------------------------
        */

        function openLightbox() {

            if (
                !lightbox
                ||
                !lightboxImage
                ||
                !galleryImages.length
            ) {
                return;
            }


            lightboxImage.src =
                galleryImages[
                    currentIndex
                ];


            lightboxImage.alt =
                galleryAlts[
                    currentIndex
                ]
                ||
                'Ảnh sản phẩm';


            if (lightboxCounter) {

                lightboxCounter.textContent =
                    `${currentIndex + 1} / ${galleryImages.length}`;

            }


            lightbox.classList.add(
                'show'
            );


            lightbox.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.style.overflow =
                'hidden';

        }


        function closeLightbox() {

            if (!lightbox) {
                return;
            }


            lightbox.classList.remove(
                'show'
            );


            lightbox.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.style.overflow =
                '';

        }


        function moveLightbox(step) {

            currentIndex =
                normalizeIndex(
                    currentIndex
                    +
                    step
                );


            setGalleryImage(
                currentIndex
            );


            if (lightboxImage) {

                lightboxImage.src =
                    galleryImages[
                        currentIndex
                    ];


                lightboxImage.alt =
                    galleryAlts[
                        currentIndex
                    ]
                    ||
                    'Ảnh sản phẩm';

            }


            if (lightboxCounter) {

                lightboxCounter.textContent =
                    `${currentIndex + 1} / ${galleryImages.length}`;

            }

        }


        if (mainImage) {

            mainImage.addEventListener(
                'click',
                openLightbox
            );

        }


        if (lightboxClose) {

            lightboxClose.addEventListener(
                'click',
                closeLightbox
            );

        }


        if (lightboxPrev) {

            lightboxPrev.addEventListener(
                'click',
                function () {
                    moveLightbox(-1);
                }
            );

        }


        if (lightboxNext) {

            lightboxNext.addEventListener(
                'click',
                function () {
                    moveLightbox(1);
                }
            );

        }


        if (lightbox) {

            lightbox.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target
                        ===
                        lightbox
                    ) {
                        closeLightbox();
                    }

                }
            );

        }


        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    !lightbox
                    ||
                    !lightbox
                        .classList
                        .contains(
                            'show'
                        )
                ) {
                    return;
                }


                if (
                    event.key
                    ===
                    'Escape'
                ) {

                    closeLightbox();

                }
                else if (
                    event.key
                    ===
                    'ArrowLeft'
                ) {

                    moveLightbox(-1);

                }
                else if (
                    event.key
                    ===
                    'ArrowRight'
                ) {

                    moveLightbox(1);

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | QUANTITY / TOTAL
        |--------------------------------------------------------------------------
        */

        const input =
            document.getElementById(
                'buyQuantity'
            );


        const minus =
            document.getElementById(
                'minusBtn'
            );


        const plus =
            document.getElementById(
                'plusBtn'
            );


        const total =
            document.getElementById(
                'liveTotal'
            );


        const quantityText =
            document.getElementById(
                'quantityText'
            );


        if (
            !input
            ||
            !minus
            ||
            !plus
            ||
            !total
        ) {
            return;
        }


        const price =
            Number(
                @json(
                    (float)
                    $product
                        ->getCurrentPrice()
                )
            );


        const min =
            Number(
                @json($minQty)
            );


        const step =
            Number(
                @json($stepQty)
            );


        const max =
            Number(
                @json($stockQty)
            );


        const unit =
            @json(
                $product->unit
                ??
                'sản phẩm'
            );


        const clampAndSnap =
            function (value) {

                if (
                    !Number.isFinite(
                        value
                    )
                ) {
                    value = min;
                }


                value =
                    Math.max(
                        min,
                        Math.min(
                            max,
                            value
                        )
                    );


                const steps =
                    Math.round(
                        (
                            value
                            -
                            min
                        )
                        /
                        step
                    );


                value =
                    min
                    +
                    (
                        steps
                        *
                        step
                    );


                return Math.round(
                    value * 100
                )
                /
                100;

            };


        const formatQty =
            function (value) {

                return Number(
                    value.toFixed(2)
                )
                .toString();

            };


        const updateQuantity =
            function () {

                const value =
                    clampAndSnap(
                        Number(
                            input.value
                        )
                    );


                input.value =
                    formatQty(
                        value
                    );


                total.textContent =
                    new Intl.NumberFormat(
                        'vi-VN'
                    )
                    .format(
                        Math.round(
                            price
                            *
                            value
                        )
                    )
                    +
                    ' đ';


                if (quantityText) {

                    quantityText.textContent =
                        formatQty(value)
                        +
                        ' '
                        +
                        unit;

                }


                minus.disabled =
                    value <= min;


                plus.disabled =
                    value + step
                    >
                    max
                    +
                    0.00001;

            };


        minus.addEventListener(
            'click',
            function () {

                input.value =
                    Number(
                        input.value
                        ||
                        min
                    )
                    -
                    step;


                updateQuantity();

            }
        );


        plus.addEventListener(
            'click',
            function () {

                input.value =
                    Number(
                        input.value
                        ||
                        min
                    )
                    +
                    step;


                updateQuantity();

            }
        );


        input.addEventListener(
            'change',
            updateQuantity
        );


        input.addEventListener(
            'input',
            updateQuantity
        );


        updateQuantity();

    }
);
</script>

@endsection