@extends('layouts.app')

@section('title', 'Tinh Hoa Tây Bắc | Đặc sản núi rừng chính hiệu')

@section('content')

<style>
    :root {
        --tb-brown: #5f341d;
        --tb-brown-dark: #3b2114;
        --tb-red: #a83b2d;
        --tb-orange: #d97706;
        --tb-gold: #f2c15c;
        --tb-green: #48633b;
        --tb-cream: #fffaf0;
        --tb-soft: #f8efe2;
    }

    .hero-taybac {
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        padding: 58px;
        color: white;

        background:
            radial-gradient(
                circle at 80% 20%,
                rgba(242,193,92,.25),
                transparent 28%
            ),
            radial-gradient(
                circle at 15% 85%,
                rgba(168,59,45,.28),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #2c1810 0%,
                #5f341d 48%,
                #48633b 100%
            );

        box-shadow:
            0 22px 55px rgba(59,33,20,.22);
    }

    .hero-taybac::after {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        right: -140px;
        top: -160px;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.03);
    }

    .hero-label {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        padding: 8px 16px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,.25);
        background: rgba(255,255,255,.09);
        font-weight: 700;
    }

    .hero-title {
        font-weight: 850;
        line-height: 1.12;
        max-width: 760px;
    }

    .hero-subtitle {
        max-width: 680px;
        color: rgba(255,255,255,.8);
    }

    .hero-food {
        min-height: 320px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .food-card {
        width: 300px;
        min-height: 255px;
        border-radius: 32px;
        border: 1px solid rgba(255,255,255,.16);

        background:
            linear-gradient(
                145deg,
                rgba(255,255,255,.14),
                rgba(255,255,255,.05)
            );

        box-shadow:
            0 30px 50px rgba(0,0,0,.2);

        backdrop-filter: blur(10px);

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        transform: rotate(-3deg);
    }

    .food-icon {
        font-size: 92px;
        line-height: 1;
    }

    .stat-box {
        background: white;
        border-radius: 19px;
        padding: 22px;
        height: 100%;
        border: 1px solid #f3e8d7;
        box-shadow: 0 8px 25px rgba(95,52,29,.06);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--tb-soft);
        font-size: 24px;
        margin-bottom: 13px;
    }

    .section-kicker {
        color: var(--tb-red);
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .09em;
    }

    .category-box {
        display: block;
        background: white;
        border-radius: 19px;
        border: 1px solid #f1e4d5;
        padding: 22px;
        height: 100%;
        color: #2f241e;
        text-decoration: none;
        transition: .22s ease;
    }

    .category-box:hover {
        transform: translateY(-5px);
        color: #2f241e;
        border-color: #e5c79f;
        box-shadow: 0 16px 35px rgba(95,52,29,.12);
    }

    .category-icon {
        width: 58px;
        height: 58px;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #fff4db, #f4dfc0);
        font-size: 28px;
        margin-bottom: 15px;
    }

    .promo-card {
        overflow: hidden;
        border-radius: 26px;
        color: white;

        background:
            radial-gradient(
                circle at 90% 20%,
                rgba(242,193,92,.18),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #4b2817,
                #852f27
            );
    }

    .promo-badge {
        background: var(--tb-gold);
        color: #3b2114;
        font-weight: 800;
    }

    .product-card-tb {
        height: 100%;
        display: flex;
        flex-direction: column;
        border: none;
        border-radius: 21px;
        overflow: hidden;
        background: white;

        box-shadow:
            0 9px 28px rgba(95,52,29,.07);

        transition: .25s ease;
    }

    .product-card-tb:hover {
        transform: translateY(-6px);

        box-shadow:
            0 18px 42px rgba(95,52,29,.14);
    }

    .product-image-wrap {
        height: 230px;
        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                180deg,
                #fffdf8,
                #f8efe2
            );
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 18px;
        transition: transform .25s ease;
    }

    .product-card-tb:hover .product-image {
        transform: scale(1.05);
    }

    .stock-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 3;
    }

    .price-text {
        color: #b42318;
        font-weight: 850;
        font-size: 21px;
    }

    /* Giữ nội dung và nút của mọi card thẳng hàng */
    .product-card-tb .card-body {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
    }

    .product-title-tb {
        min-height: 48px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .product-description-tb {
        min-height: 60px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }

    .product-price-stock-tb {
        margin-top: auto;
    }

    .product-actions-tb {
        margin-top: 0;
    }

    .feature-strip {
        border-radius: 24px;
        border: 1px solid #ead8bf;
        background:
            linear-gradient(
                135deg,
                #fffaf0,
                #f8efe2
            );
    }

    .btn-taybac {
        background: var(--tb-red);
        border-color: var(--tb-red);
        color: white;
    }

    .btn-taybac:hover {
        background: #8f3025;
        border-color: #8f3025;
        color: white;
    }

    .btn-outline-taybac {
        border-color: var(--tb-red);
        color: var(--tb-red);
    }

    .btn-outline-taybac:hover {
        background: var(--tb-red);
        color: white;
    }

    @media(max-width: 768px) {
        .hero-taybac {
            padding: 32px 24px;
        }

        .hero-title {
            font-size: 37px;
        }

        .hero-food {
            min-height: 230px;
        }

        .food-card {
            width: 235px;
            min-height: 200px;
        }

        .food-icon {
            font-size: 68px;
        }
    }
.category-scroll-wrapper {
    position: relative;
}

.category-scroll {
    display: flex;
    gap: 18px;

    overflow-x: auto;
    overflow-y: hidden;

    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;

    padding: 4px 2px 18px;

    scrollbar-width: thin;
    scrollbar-color: #d8b98f transparent;
}

.category-scroll::-webkit-scrollbar {
    height: 8px;
}

.category-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.category-scroll::-webkit-scrollbar-thumb {
    background: #d8b98f;
    border-radius: 20px;
}

.category-scroll::-webkit-scrollbar-thumb:hover {
    background: #b98b58;
}

.category-scroll-item {
    flex: 0 0 220px;
    scroll-snap-align: start;
}

.category-scroll-item .category-box {
    min-height: 180px;
}

.category-scroll-btn {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    position: absolute;
    top: 50%;
    transform: translateY(-50%);

    z-index: 5;

    border: 1px solid #ead8bf;
    border-radius: 50%;

    background: #ffffff;
    color: #5f341d;

    font-size: 22px;
    font-weight: bold;

    box-shadow: 0 8px 20px rgba(95, 52, 29, .14);

    transition: .2s ease;
}

.category-scroll-btn:hover {
    background: #5f341d;
    color: #ffffff;
}

.category-scroll-btn.left {
    left: -20px;
}

.category-scroll-btn.right {
    right: -20px;
}

@media (max-width: 768px) {
    .category-scroll-item {
        flex-basis: 185px;
    }

    .category-scroll-btn {
        display: none;
    }
}

/* =========================================================
   HOME REDESIGN 2026
   Chỉ thay đổi bố cục/giao diện, giữ nguyên toàn bộ logic Blade.
========================================================= */
.home-redesign {
    --home-card: #ffffff;
    --home-shadow: 0 14px 38px rgba(73, 43, 25, .09);
}

/* Nhịp khoảng cách thống nhất */
.home-redesign > section {
    margin-bottom: 64px !important;
}

.home-redesign .hero-taybac {
    padding: 54px 58px;
    border-radius: 28px;
    min-height: 470px;
    display: flex;
    align-items: center;
}

.home-redesign .hero-title {
    font-size: clamp(42px, 4.5vw, 68px);
    letter-spacing: -1.5px;
    margin-top: 12px;
}

.home-redesign .hero-subtitle {
    font-size: 18px;
    line-height: 1.75;
    max-width: 650px;
}

.home-redesign .hero-food {
    min-height: 330px;
}

.home-redesign .food-card {
    width: 320px;
    min-height: 285px;
    position: relative;
    overflow: hidden;
}

.home-redesign .food-card::before {
    content: "";
    position: absolute;
    width: 190px;
    height: 190px;
    border-radius: 50%;
    background: rgba(242,193,92,.12);
    top: -70px;
    right: -55px;
}

.home-redesign .food-card::after {
    content: "TÂY BẮC";
    position: absolute;
    bottom: 18px;
    right: 22px;
    font-size: 11px;
    letter-spacing: .2em;
    font-weight: 800;
    color: rgba(255,255,255,.28);
}

/* Thống kê thành một dải gọn thay vì 4 ô quá rời */
.home-redesign .stats-home-row {
    background: #fff;
    border: 1px solid var(--tb-border);
    border-radius: 24px;
    padding: 10px;
    box-shadow: var(--home-shadow);
}

.home-redesign .stat-box {
    box-shadow: none;
    border: 0;
    border-radius: 18px;
    position: relative;
}

.home-redesign .stats-home-row > div:not(:last-child) .stat-box::after {
    content: "";
    position: absolute;
    top: 18%;
    right: -6px;
    width: 1px;
    height: 64%;
    background: #eee1cf;
}

.home-redesign .stat-icon {
    margin-bottom: 10px;
}

/* Tiêu đề section */
.home-redesign .section-heading-home {
    position: relative;
    padding-left: 17px;
}

.home-redesign .section-heading-home::before {
    content: "";
    position: absolute;
    left: 0;
    top: 4px;
    bottom: 4px;
    width: 5px;
    border-radius: 10px;
    background: linear-gradient(var(--tb-orange), var(--tb-red));
}

.home-redesign .section-heading-home h2 {
    font-size: clamp(27px, 2.5vw, 36px);
    color: var(--tb-brown-dark);
}

/* Danh mục: nổi bật hơn nhưng vẫn giữ thanh cuộn cũ */
.home-redesign .category-scroll {
    gap: 20px;
    padding: 8px 5px 24px;
}

.home-redesign .category-scroll-item {
    flex-basis: 235px;
}

.home-redesign .category-box {
    min-height: 190px !important;
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 7px 24px rgba(95,52,29,.055);
    position: relative;
    overflow: hidden;
}

.home-redesign .category-box::after {
    content: "→";
    position: absolute;
    right: 20px;
    bottom: 18px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: var(--tb-soft);
    color: var(--tb-brown);
    font-weight: 800;
    transition: .2s ease;
}

.home-redesign .category-box:hover::after {
    background: var(--tb-brown);
    color: white;
}

.home-redesign .category-icon {
    width: 66px;
    height: 66px;
    font-size: 31px;
}

/* Card sản phẩm kiểu shop thương mại điện tử gọn hơn */
.home-redesign .product-card-tb {
    border: 1px solid #f0e1cf;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(95,52,29,.055);
}

.home-redesign .product-image-wrap {
    height: 245px;
    background: #fffaf3;
}

.home-redesign .product-image {
    padding: 12px;
    object-fit: cover;
}

.home-redesign .product-card-tb .card-body {
    padding: 20px !important;
}

.home-redesign .product-title-tb {
    font-size: 17px;
    min-height: 43px;
}

.home-redesign .product-description-tb {
    min-height: 42px;
    -webkit-line-clamp: 2;
}

.home-redesign .price-text {
    font-size: 20px;
}

/* Banner ưu đãi */
.home-redesign .promo-card {
    border-radius: 28px;
    box-shadow: 0 18px 44px rgba(95,52,29,.15);
    position: relative;
}

.home-redesign .promo-card::after {
    content: "🎁";
    position: absolute;
    right: 7%;
    top: 50%;
    transform: translateY(-50%) rotate(-8deg);
    font-size: 100px;
    opacity: .13;
    pointer-events: none;
}

.home-redesign .promo-card .row {
    position: relative;
    z-index: 2;
}

/* Lợi ích cuối trang */
.home-redesign .feature-strip {
    background: #fff;
    box-shadow: var(--home-shadow);
    border-radius: 24px;
    padding: 30px !important;
}

.home-redesign .feature-strip .col-md-3 {
    position: relative;
}

.home-redesign .feature-strip .col-md-3:not(:last-child)::after {
    content: "";
    position: absolute;
    right: 0;
    top: 10%;
    height: 80%;
    width: 1px;
    background: var(--tb-border);
}

.home-redesign .feature-strip .fs-2 {
    width: 56px;
    height: 56px;
    margin: 0 auto 12px !important;
    border-radius: 17px;
    display: grid;
    place-items: center;
    background: var(--tb-soft);
}

/* Nút đồng bộ */
.home-redesign .btn {
    border-radius: 11px;
}

.home-redesign .btn-lg {
    border-radius: 13px;
}

/* Mobile */
@media (max-width: 991.98px) {
    .home-redesign > section {
        margin-bottom: 45px !important;
    }

    .home-redesign .hero-taybac {
        padding: 38px 30px;
        min-height: auto;
    }

    .home-redesign .hero-title {
        font-size: 45px;
    }

    .home-redesign .hero-food {
        min-height: 250px;
        margin-top: 18px;
    }

    .home-redesign .stats-home-row > div .stat-box::after {
        display: none;
    }

    .home-redesign .feature-strip .col-md-3::after {
        display: none;
    }
}

@media (max-width: 575.98px) {
    .home-redesign .hero-taybac {
        padding: 30px 22px;
        border-radius: 22px;
    }

    .home-redesign .hero-title {
        font-size: 37px;
        letter-spacing: -.7px;
    }

    .home-redesign .hero-subtitle {
        font-size: 16px;
    }

    .home-redesign .hero-food {
        display: none;
    }

    .home-redesign .category-scroll-item {
        flex-basis: 190px;
    }

    .home-redesign .product-image-wrap {
        height: 220px;
    }
}


    /* =========================================================
       🔥 BÁN CHẠY + ĐÃ BÁN
    ========================================================= */
    .sold-count-tb {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #7a5a48;
        font-size: 13px;
        font-weight: 700;
    }

    .best-seller-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 4;
        padding: 7px 10px;
        border-radius: 999px;
        background: linear-gradient(135deg,#a83b2d,#d97706);
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        box-shadow: 0 6px 16px rgba(168,59,45,.22);
    }

    .best-seller-card {
        border: 1px solid #ecd4b5 !important;
        background:
            linear-gradient(#fff,#fff) padding-box,
            linear-gradient(135deg,#f2c15c,#a83b2d) border-box;
    }

</style>


{{-- =====================================================
    HERO
===================================================== --}}
<div class="home-redesign">

<section class="mb-5">

    <div class="hero-taybac">

        <div
            class="row align-items-center position-relative"
            style="z-index:2;"
        >

            <div class="col-lg-7">

                <div class="hero-label mb-3">
                    🌿 Hương vị núi rừng Tây Bắc
                </div>


                <h1 class="display-4 hero-title mb-3">

                    Mang tinh hoa
                    <span style="color:#f2c15c;">
                        Tây Bắc
                    </span>
                    đến từng bữa ăn

                </h1>


                <p class="lead hero-subtitle mb-4">

                    Khám phá thịt gác bếp, lạp xưởng,
                    mắc khén, hạt dổi, mật ong,
                    trà Shan Tuyết và nhiều đặc sản
                    đậm đà hương vị núi rừng.

                </p>




            </div>


            <div class="col-lg-5">

                <div class="hero-food">

                    <div class="food-card">

                        <div class="food-icon">
                            🥩
                        </div>


                        <h4 class="fw-bold mt-3 mb-1">
                            Đặc sản Tây Bắc
                        </h4>


                        <small style="color:rgba(255,255,255,.72);">
                            Tinh hoa ẩm thực núi rừng
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =====================================================
    THỐNG KÊ
===================================================== --}}
<section class="mb-5">

    <div class="row g-3 stats-home-row">

        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🥩
                </div>

                <h4 class="fw-bold mb-1">
                    {{ number_format($totalProducts) }}+
                </h4>

                <div class="text-muted">
                    Đặc sản đang bán
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🧺
                </div>

                <h4 class="fw-bold mb-1">
                    {{ $totalCategories }}
                </h4>

                <div class="text-muted">
                    Nhóm đặc sản
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🚚
                </div>

                <h4 class="fw-bold mb-1">
                    Toàn quốc
                </h4>

                <div class="text-muted">
                    Giao hàng tận nơi
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🌿
                </div>

                <h4 class="fw-bold mb-1">
                    Đậm vị
                </h4>

                <div class="text-muted">
                    Hương vị Tây Bắc
                </div>

            </div>

        </div>

    </div>

</section>


{{-- =====================================================
    DANH MỤC
===================================================== --}}

@if($categories->count() > 0)

<section class="mb-5">

    <div
        class="section-heading-home 
            d-flex
            justify-content-between
            align-items-end
            flex-wrap
            gap-3
            mb-4
        "
    >

        <div>

            <div class="section-kicker mb-1">
                Danh mục đặc sản
            </div>

            <h2 class="fw-bold mb-0">
                Khám phá hương vị Tây Bắc
            </h2>

            <div class="text-muted mt-1">
                Lướt ngang để xem toàn bộ danh mục
            </div>

        </div>


        @auth

            @if(Auth::user()->role !== 'admin')

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-outline-taybac"
                >
                    Xem tất cả →
                </a>

            @endif

        @endauth

    </div>


    <div class="category-scroll-wrapper">

        {{-- NÚT TRÁI --}}
        <button
            type="button"
            class="category-scroll-btn left"
            onclick="scrollCategories(-1)"
            aria-label="Danh mục trước"
        >
            ‹
        </button>


        {{-- DANH SÁCH DANH MỤC --}}
        <div
            class="category-scroll"
            id="categoryScroll"
        >

            @foreach($categories as $category)

                @php

                    $categoryName =
                        mb_strtolower($category->name);

                    $categoryIcon = '🌿';


                    if (
                        str_contains($categoryName, 'trâu')
                        ||
                        str_contains($categoryName, 'thịt')
                        ||
                        str_contains($categoryName, 'gác bếp')
                    ) {
                        $categoryIcon = '🥩';
                    }

                    elseif (
                        str_contains($categoryName, 'lạp xưởng')
                    ) {
                        $categoryIcon = '🌭';
                    }

                    elseif (
                        str_contains($categoryName, 'gia vị')
                        ||
                        str_contains($categoryName, 'mắc khén')
                        ||
                        str_contains($categoryName, 'hạt dổi')
                        ||
                        str_contains($categoryName, 'chẩm chéo')
                    ) {
                        $categoryIcon = '🌶️';
                    }

                    elseif (
                        str_contains($categoryName, 'trà')
                        ||
                        str_contains($categoryName, 'thảo mộc')
                    ) {
                        $categoryIcon = '🍵';
                    }

                    elseif (
                        str_contains($categoryName, 'mật ong')
                    ) {
                        $categoryIcon = '🍯';
                    }

                    elseif (
                        str_contains($categoryName, 'gạo')
                        ||
                        str_contains($categoryName, 'nếp')
                    ) {
                        $categoryIcon = '🍚';
                    }

                    elseif (
                        str_contains($categoryName, 'quà')
                    ) {
                        $categoryIcon = '🎁';
                    }

                    elseif (
                        str_contains($categoryName, 'khô')
                    ) {
                        $categoryIcon = '🧺';
                    }

                @endphp


                <div class="category-scroll-item">

                    @if(
                        Auth::check()
                        &&
                        Auth::user()->role === 'admin'
                    )

                        <a
                            href="{{
                                route(
                                    'admin.categories.show',
                                    $category
                                )
                            }}"
                            class="category-box"
                        >

                    @else

                        <a
                            href="{{
                                route(
                                    'categories.show',
                                    $category
                                )
                            }}"
                            class="category-box"
                        >

                    @endif


                            <div class="category-icon">
                                {{ $categoryIcon }}
                            </div>


                            <h6 class="fw-bold mb-1">
                                {{ $category->name }}
                            </h6>


                            <small class="text-muted">
                                {{ $category->products_count }}
                                sản phẩm
                            </small>

                        </a>

                </div>

            @endforeach

        </div>


        {{-- NÚT PHẢI --}}
        <button
            type="button"
            class="category-scroll-btn right"
            onclick="scrollCategories(1)"
            aria-label="Danh mục tiếp theo"
        >
            ›
        </button>

    </div>

</section>

@endif


{{-- =====================================================
    🔥 SẢN PHẨM BÁN CHẠY
    Chỉ tính từ các đơn đã giao thành công
===================================================== --}}

@if(isset($bestSellingProducts) && $bestSellingProducts->count() > 0)

<section class="mb-5">

    <div
        class="
            section-heading-home
            d-flex
            justify-content-between
            align-items-end
            flex-wrap
            gap-3
            mb-4
        "
    >
        <div>
            <div class="section-kicker mb-1">
                🔥 Được khách hàng yêu thích
            </div>

            <h2 class="fw-bold mb-1">
                Bán chạy nhất
            </h2>

            <div class="text-muted">
                Xếp hạng theo số lượng thực tế từ các đơn đã giao thành công
            </div>
        </div>

        <a
            href="{{ route('products.index') }}"
            class="btn btn-outline-taybac"
        >
            Xem tất cả →
        </a>
    </div>

    <div
        class="
            row
            row-cols-1
            row-cols-sm-2
            row-cols-lg-4
            g-4
        "
    >
        @foreach($bestSellingProducts as $index => $product)

            <div class="col">
                <div class="product-card-tb best-seller-card">

                    <div class="product-image-wrap">
                        <span class="best-seller-badge">
                            {{ $index === 0 ? '🏆 TOP 1' : '🔥 TOP ' . ($index + 1) }}
                        </span>

                        @if($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-image"
                                onerror="
                                    this.style.display='none';
                                    this.nextElementSibling.style.display='flex';
                                "
                            >
                            <div
                                class="align-items-center justify-content-center text-muted"
                                style="display:none;height:100%;font-size:54px;"
                            >
                                🧺
                            </div>
                        @else
                            <div
                                class="d-flex align-items-center justify-content-center text-muted"
                                style="height:100%;font-size:54px;"
                            >
                                🧺
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-4">
                        <div class="small text-muted mb-2">
                            {{ $product->category->name ?? 'Đặc sản Tây Bắc' }}
                        </div>

                        <h5 class="fw-bold product-title-tb mb-2">
                            {{ $product->name }}
                        </h5>

                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <div class="price-text">
                                {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                            </div>

                            <span class="sold-count-tb">
                                🔥 Đã bán
                                {{ rtrim(rtrim(number_format((float) $product->sold_quantity, 2, '.', ''), '0'), '.') }} {{ $product->unit }}
                            </span>
                        </div>

                        <a
                            href="{{ route('products.show', $product) }}"
                            class="btn btn-outline-taybac w-100"
                        >
                            👁 Xem chi tiết
                        </a>
                    </div>

                </div>
            </div>

        @endforeach
    </div>

</section>

@endif

{{-- =====================================================
    ⭐ SẢN PHẨM NỔI BẬT
===================================================== --}}

@if($featuredProducts->count() > 0)

<section class="mb-5">

    {{-- TIÊU ĐỀ --}}
    <div
        class="section-heading-home 
            d-flex
            justify-content-between
            align-items-end
            flex-wrap
            gap-3
            mb-4
        "
    >

        <div>

            <div class="section-kicker mb-1">
                ⭐ Được cửa hàng đề xuất
            </div>

            <h2 class="fw-bold mb-1">
                Sản phẩm nổi bật
            </h2>

            <div class="text-muted">
                Những đặc sản nổi bật được Tinh Hoa Tây Bắc lựa chọn
            </div>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-taybac"
            >
                Xem tất cả →
            </a>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <a
                    href="{{ route('admin.products.create') }}"
                    class="btn btn-taybac"
                >
                    ➕ Thêm sản phẩm
                </a>
            @endif

        </div>

    </div>


    {{-- DANH SÁCH SẢN PHẨM NỔI BẬT --}}
    <div
        class="
            row
            row-cols-1
            row-cols-sm-2
            row-cols-lg-4
            g-4
        "
    >

        @foreach($featuredProducts as $product)

            <div class="col">

                <div class="product-card-tb">

                    {{-- =================================================
                        ẢNH SẢN PHẨM
                    ================================================= --}}
                    <div class="product-image-wrap">

                        {{-- BADGE NỔI BẬT --}}
                        <span
                            class="badge stock-badge"
                            style="
                                background:#f2c15c;
                                color:#3b2114;
                                border:1px solid #dda83e;
                            "
                        >
                            ⭐ Nổi bật
                        </span>


                        {{-- ẢNH --}}
                        @if(
                            $product->image
                            &&
                            Storage::disk('public')->exists(
                                $product->image
                            )
                        )

                            <img
                                src="{{
                                    Storage::disk('public')
                                        ->url($product->image)
                                }}"
                                alt="{{ $product->name }}"
                                class="product-image"
                            >

                        @else

                            <div
                                class="
                                    h-100
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                "
                                style="font-size:68px;"
                            >
                                🧺
                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                        NỘI DUNG
                    ================================================= --}}
                    <div
                        class="
                            card-body
                            p-4
                            d-flex
                            flex-column
                        "
                    >

                        {{-- DANH MỤC --}}
                        <div class="mb-2">

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-light
                                    text-dark
                                    border
                                "
                            >
                                {{
                                    $product->category->name
                                    ?? 'Chưa phân loại'
                                }}
                            </span>

                        </div>


                        {{-- TÊN SẢN PHẨM --}}
                        <h5
                            class="
                                fw-bold
                                mb-2
                                product-title-tb
                            "
                        >
                            {{ $product->name }}
                        </h5>


                        {{-- MÔ TẢ --}}
                        <p
                            class="
                                text-muted
                                small
                                product-description-tb
                            "
                        >
                            {{
                                \Illuminate\Support\Str::limit(
                                    $product->description
                                    ?? 'Đặc sản Tây Bắc đậm đà hương vị núi rừng.',
                                    80
                                )
                            }}
                        </p>


                        {{-- GIÁ + TỒN KHO --}}
                        <div class="mb-3 product-price-stock-tb">

                            <div class="price-text">

                                @if($product->isOnSale())
                                    <span class="text-muted text-decoration-line-through small me-2">
                                        {{ number_format($product->price, 0, ',', '.') }} đ
                                    </span>
                                    <span>
                                        {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                                    </span>
                                    <span class="badge bg-danger ms-1">
                                        -{{ $product->getDiscountPercent() }}%
                                    </span>
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }} đ
                                @endif

                                @if($product->unit)
                                    <small
                                        class="text-muted fw-normal"
                                        style="font-size:13px;"
                                    >
                                        / {{ $product->unit }}
                                    </small>
                                @endif

                            </div>


                            @if($product->quantity > 0)

                                <small class="text-success fw-semibold">

                                    Còn:
                                    {{
                                        rtrim(
                                            rtrim(
                                                number_format(
                                                    (float) $product->quantity,
                                                    2,
                                                    '.',
                                                    ''
                                                ),
                                                '0'
                                            ),
                                            '.'
                                        )
                                    }}

                                    {{ $product->unit ?? 'sản phẩm' }}

                                </small>

                            @else

                                <small class="text-danger fw-semibold">
                                    Hết hàng
                                </small>

                            @endif

                        </div>


                        {{-- =================================================
                            ADMIN
                        ================================================= --}}
                        @if(
                            Auth::check()
                            &&
                            Auth::user()->role === 'admin'
                        )

                            <div class="d-grid gap-2 product-actions-tb">

                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="btn btn-outline-taybac"
                                >
                                    👁 Xem sản phẩm
                                </a>


                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-outline-warning fw-bold"
                                >
                                    ✏️ Sửa sản phẩm
                                </a>


                                {{-- BỎ GHIM NGAY TẠI TRANG CHỦ --}}
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
                                        class="btn btn-warning w-100 fw-bold"
                                    >
                                        ★ Bỏ ghim
                                    </button>

                                </form>

                            </div>


                        {{-- =================================================
                            CUSTOMER
                        ================================================= --}}
                        @elseif(Auth::check())

                            <div class="d-grid gap-2 product-actions-tb">

                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="btn btn-outline-taybac"
                                >
                                    Xem chi tiết
                                </a>


                                @if($product->quantity > 0)

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
                                            class="btn btn-taybac w-100"
                                        >
                                            🛒 Thêm vào giỏ
                                        </button>

                                    </form>

                                @else

                                    <button
                                        class="btn btn-secondary w-100"
                                        disabled
                                    >
                                        Hết hàng
                                    </button>

                                @endif

                            </div>


                        {{-- =================================================
                            KHÁCH CHƯA ĐĂNG NHẬP
                        ================================================= --}}
                        @else

                            <div class="d-grid gap-2 product-actions-tb">

                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="btn btn-outline-taybac"
                                >
                                    Xem chi tiết
                                </a>

                                <a
                                    href="{{ route('login') }}"
                                    class="btn btn-taybac"
                                >
                                    🔐 Đăng nhập để mua
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</section>

@endif

{{-- =====================================================
    BANNER ƯU ĐÃI
===================================================== --}}
<section class="mb-5">

    <div class="promo-card p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="badge promo-badge mb-3">
                    🔥 ƯU ĐÃI ĐẶC SẢN
                </span>


                <h2 class="fw-bold mb-3">
                    Mang hương vị Tây Bắc về nhà với giá tốt
                </h2>


                <p
                    class="mb-0"
                    style="color:rgba(255,255,255,.76);"
                >
                    Sử dụng voucher tại bước thanh toán
                    để nhận thêm ưu đãi cho đơn hàng.
                </p>

            </div>


            <div
                class="
                    col-lg-4
                    text-lg-end
                    mt-4
                    mt-lg-0
                "
            >

                @if(
                    Auth::check()
                    &&
                    Auth::user()->role !== 'admin'
                )

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-warning btn-lg fw-bold"
                    >
                        Khám phá ngay →
                    </a>

                @elseif(!Auth::check())

                    <a
                        href="{{ route('register') }}"
                        class="btn btn-warning btn-lg fw-bold"
                    >
                        Bắt đầu mua sắm →
                    </a>

                @endif

            </div>

        </div>

    </div>

</section>


{{-- =====================================================
    SẢN PHẨM MỚI
===================================================== --}}
<section class="mb-5">

    <div
        class="section-heading-home 
            d-flex
            justify-content-between
            align-items-end
            mb-4
        "
    >

        <div>

            <div class="section-kicker mb-1">
                Đặc sản mới
            </div>


            <h2 class="fw-bold mb-0">
                Hương vị mới dành cho bạn
            </h2>

        </div>


        @auth

            @if(Auth::user()->role === 'admin')

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-taybac"
                >
                    Quản lý sản phẩm →
                </a>

            @else

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-taybac"
                >
                    Xem tất cả →
                </a>

            @endif

        @endauth

    </div>


    <div
        class="
            row
            row-cols-1
            row-cols-sm-2
            row-cols-lg-4
            g-4
        "
    >

        @forelse($products as $product)

            <div class="col">

                <div class="product-card-tb">


                    {{-- ẢNH --}}
                    <div class="product-image-wrap">

                        @if($product->quantity > 0)

                            <span class="badge bg-success stock-badge">
                                Còn hàng
                            </span>

                        @else

                            <span class="badge bg-danger stock-badge">
                                Hết hàng
                            </span>

                        @endif


                        @if(
                            $product->image
                            &&
                            Storage::disk('public')->exists(
                                $product->image
                            )
                        )

                            <img
                                src="{{
                                    Storage::disk('public')
                                        ->url($product->image)
                                }}"
                                alt="{{ $product->name }}"
                                class="product-image"
                            >

                        @else

                            <div
                                class="
                                    h-100
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                "
                                style="font-size:68px;"
                            >
                                🧺
                            </div>

                        @endif

                    </div>


                    <div
                        class="
                            card-body
                            p-4
                            d-flex
                            flex-column
                        "
                    >

                        <div class="mb-2">

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-light
                                    text-dark
                                    border
                                "
                            >
                                {{
                                    $product->category->name
                                    ?? 'Chưa phân loại'
                                }}
                            </span>

                        </div>


                        <h5 class="fw-bold mb-2 product-title-tb">
                            {{ $product->name }}
                        </h5>


                        <p class="text-muted small product-description-tb">

                            {{
                                \Illuminate\Support\Str::limit(
                                    $product->description
                                    ??
                                    'Đặc sản Tây Bắc đậm đà hương vị núi rừng.',
                                    80
                                )
                            }}

                        </p>


                        <div class="mb-3 product-price-stock-tb">

                            <div class="price-text">

                                @if($product->isOnSale())
                                    <span class="text-muted text-decoration-line-through small me-2">
                                        {{ number_format($product->price, 0, ',', '.') }} đ
                                    </span>
                                    <span>
                                        {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                                    </span>
                                    <span class="badge bg-danger ms-1">
                                        -{{ $product->getDiscountPercent() }}%
                                    </span>
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }} đ
                                @endif

                            </div>


                            <small class="text-muted">
                                Còn:
                                {{ $product->quantity }}
                                sản phẩm
                            </small>

                        </div>


                        {{-- PHÂN QUYỀN --}}
                        @if(
                            Auth::check()
                            &&
                            Auth::user()->role === 'admin'
                        )

                            <a
                                href="{{
                                    route(
                                        'products.show',
                                        $product
                                    )
                                }}"
                                class="
                                    btn
                                    btn-outline-taybac
                                    mt-auto
                                "
                            >
                                👁 Xem chi tiết
                            </a>

                            <a
                                href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-outline-warning mt-2 fw-bold"
                            >
                                ✏️ Sửa sản phẩm
                            </a>


                        @elseif(Auth::check())

                            <div class="d-grid gap-2 product-actions-tb">

                                <a
                                    href="{{
                                        route(
                                            'products.show',
                                            $product
                                        )
                                    }}"
                                    class="btn btn-outline-taybac"
                                >
                                    Xem chi tiết
                                </a>


                                @if($product->quantity > 0)

                                    <form
                                        action="{{
                                            route(
                                                'cart.add',
                                                $product->id
                                            )
                                        }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-taybac w-100"
                                        >
                                            🛒 Thêm vào giỏ
                                        </button>

                                    </form>

                                @endif

                            </div>


                        @else

                            <a
                                href="{{ route('login') }}"
                                class="btn btn-taybac mt-auto"
                            >
                                Đăng nhập để mua
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="text-center py-5">

                    <div style="font-size:68px;">
                        🧺
                    </div>

                    <h5 class="text-muted mt-3">
                        Hiện chưa có đặc sản nào.
                    </h5>

                </div>

            </div>

        @endforelse

    </div>


    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</section>


{{-- =====================================================
    LỢI ÍCH
===================================================== --}}
<section class="mb-4">

    <div class="feature-strip p-4">

        <div class="row g-4 text-center">

            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    🌿
                </div>

                <h6 class="fw-bold">
                    Hương vị đặc trưng
                </h6>

                <small class="text-muted">
                    Đậm chất ẩm thực vùng cao Tây Bắc
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    🚚
                </div>

                <h6 class="fw-bold">
                    Giao hàng linh hoạt
                </h6>

                <small class="text-muted">
                    Tiết kiệm, nhanh và hỏa tốc
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    💳
                </div>

                <h6 class="fw-bold">
                    Thanh toán tiện lợi
                </h6>

                <small class="text-muted">
                    COD hoặc chuyển khoản QR
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    📦
                </div>

                <h6 class="fw-bold">
                    Theo dõi đơn hàng
                </h6>

                <small class="text-muted">
                    Cập nhật trạng thái trực tiếp
                </small>

            </div>

        </div>

    </div>

</section>


</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('categoryScroll');

    if (!container) {
        return;
    }

    window.scrollCategories = function (direction) {
        const firstItem = container.querySelector('.category-scroll-item');

        let distance = 720;

        if (firstItem) {
            const itemWidth = firstItem.getBoundingClientRect().width;
            const gap = 18;
            distance = (itemWidth + gap) * 3;
        }

        container.scrollBy({
            left: direction * distance,
            behavior: 'smooth'
        });
    };

    // Cho phép Shift + con lăn chuột để lướt ngang.
    container.addEventListener('wheel', function (event) {
        if (event.shiftKey) {
            event.preventDefault();

            container.scrollBy({
                left: event.deltaY,
                behavior: 'smooth'
            });
        }
    }, { passive: false });
});
</script>

@endsection