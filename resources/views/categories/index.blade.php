@extends('layouts.app')

@section('title', 'Danh mục đặc sản | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .category-hero {
        border-radius: 26px;
        padding: 38px;
        color: white;
        overflow: hidden;
        position: relative;

        background:
            radial-gradient(
                circle at 85% 20%,
                rgba(242, 193, 92, .18),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #2c1810,
                #5f341d 55%,
                #48633b
            );

        box-shadow:
            0 15px 40px rgba(95, 52, 29, .18);
    }

    .category-hero::after {
        content: "";
        position: absolute;

        width: 300px;
        height: 300px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, .05);

        right: -100px;
        top: -120px;
    }

    .category-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        height: 100%;

        background: white;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .06);

        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .category-card:hover {
        transform: translateY(-6px);

        box-shadow:
            0 18px 40px rgba(95, 52, 29, .14);
    }

    .category-icon-box {
        height: 150px;

        display: flex;
        align-items: center;
        justify-content: center;

        background:
            linear-gradient(
                135deg,
                #eef2ff,
                #dbeafe
            );

        font-size: 70px;
    }

    .category-count {
        display: inline-block;

        padding:
            7px 12px;

        border-radius:
            20px;

        background:
            #f8efe2;

        color:
            #5f341d;

        font-weight:
            700;
    }

    .category-btn {
        border-radius:
            11px;

        font-weight:
            700;
    }

    .info-card {
        border: none;

        border-radius:
            18px;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .05);
    }

    .info-icon {
        width: 50px;
        height: 50px;

        border-radius:
            15px;

        display: flex;
        align-items: center;
        justify-content: center;

        background:
            #f8efe2;

        font-size:
            24px;
    }

    /* Theme Tinh Hoa Tây Bắc */
    .category-hero .btn-light {
        color: #3b2114;
        border: none;
        background: #f2c15c;
        box-shadow: 0 8px 20px rgba(44,24,16,.16);
    }
    .category-hero .btn-light:hover { color:#2c1810; background:#ffd77d; }
    .category-card { border:1px solid #ead8bf; }
    .category-count { background:#f8efe2; color:#5f341d; }
    .category-btn.btn-primary {
        border:none;
        background:linear-gradient(135deg,#a83b2d,#5f341d);
    }
    .category-btn.btn-primary:hover {
        background:linear-gradient(135deg,#8b3025,#3b2114);
    }
    .category-btn.btn-outline-primary { color:#5f341d; border-color:#5f341d; }
    .category-btn.btn-outline-primary:hover {
        color:#fff; background:#5f341d; border-color:#5f341d;
    }
    .section-kicker { color:#48633b !important; letter-spacing:.5px; }
    .category-total-badge { background:#5f341d !important; }

</style>


<div class="container py-4">


    {{-- ==========================================
        HERO
    ========================================== --}}
    <section class="category-hero mb-5">

        <div
            class="row align-items-center position-relative"
            style="z-index: 2;"
        >

            <div class="col-lg-8">

                <div
                    class="fw-bold small mb-2"
                    style="
                        color:
                        rgba(255,255,255,.7);
                        letter-spacing:1px;
                    "
                >
                    🌿 TINH HOA TÂY BẮC
                </div>


                <h1 class="fw-bold display-5 mb-3">

                    🧺 Danh mục đặc sản

                </h1>


                <p
                    class="lead mb-0"
                    style="
                        color:
                        rgba(255,255,255,.75);
                        max-width:700px;
                    "
                >
                    Khám phá thịt gác bếp, lạp xưởng, mắc khén,
                    hạt dổi, trà Shan Tuyết, mật ong và nhiều
                    đặc sản đậm đà hương vị núi rừng Tây Bắc.
                </p>

            </div>


            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">


                {{-- ADMIN --}}
                @if(
                    Auth::check()
                    &&
                    Auth::user()->role === 'admin'
                )

                    <a
                        href="{{
                            route(
                                'admin.categories.index'
                            )
                        }}"
                        class="
                            btn
                            btn-warning
                            btn-lg
                            fw-bold
                        "
                    >
                        ⚙️ Quản lý danh mục
                    </a>


                {{-- CUSTOMER --}}
                @else

                    <a
                        href="{{
                            route(
                                'products.index'
                            )
                        }}"
                        class="
                            btn
                            btn-light
                            btn-lg
                            fw-bold
                        "
                    >
                        🥩 Xem tất cả đặc sản
                    </a>

                @endif

            </div>

        </div>

    </section>



    {{-- ==========================================
        THỐNG KÊ
    ========================================== --}}
    <section class="mb-5">

        <div class="row g-3">

            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🧺
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Tổng danh mục
                                </div>


                                <h3 class="fw-bold mb-0">

                                    {{
                                        method_exists(
                                            $categories,
                                            'total'
                                        )
                                        ? $categories->total()
                                        : $categories->count()
                                    }}

                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🌿
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Đặc sản Tây Bắc
                                </div>


                                <h5 class="fw-bold mb-0">
                                    Đậm vị núi rừng
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🚚
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Giao hàng
                                </div>


                                <h5 class="fw-bold mb-0">
                                    Toàn quốc, tận nơi
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ==========================================
        TIÊU ĐỀ DANH SÁCH
    ========================================== --}}
    <div
        class="
            d-flex
            justify-content-between
            align-items-end
            flex-wrap
            gap-2
            mb-4
        "
    >

        <div>

            <div
                class="
                    section-kicker
                    fw-bold
                    small
                    mb-1
                "
            >
                KHÁM PHÁ ĐẶC SẢN
            </div>


            <h2 class="fw-bold mb-0">

                Chọn hương vị bạn yêu thích

            </h2>

        </div>


        <span
            class="
                badge
                category-total-badge
                fs-6
            "
        >

            {{
                method_exists(
                    $categories,
                    'total'
                )
                ? $categories->total()
                : $categories->count()
            }}

            danh mục

        </span>

    </div>



    {{-- ==========================================
        DANH SÁCH DANH MỤC
    ========================================== --}}
    @if($categories->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div style="font-size:70px;">
                    📭
                </div>


                <h4 class="fw-bold mt-3">

                    Chưa có danh mục đặc sản

                </h4>


                <p class="text-muted">

                    Cửa hàng hiện chưa có
                    danh mục nào để hiển thị.

                </p>


                @if(
                    Auth::check()
                    &&
                    Auth::user()->role === 'admin'
                )

                    <a
                        href="{{
                            route(
                                'admin.categories.create'
                            )
                        }}"
                        class="btn btn-primary"
                    >
                        ➕ Thêm danh mục
                    </a>

                @endif

            </div>

        </div>


    @else


        <div
            class="
                row
                row-cols-1
                row-cols-sm-2
                row-cols-lg-3
                row-cols-xl-4
                g-4
            "
        >

            @foreach($categories as $category)


                @php

                    $name =
                        mb_strtolower(
                            $category->name
                        );


                    $icon = '🌿';

                    if (str_contains($name, 'trâu') || str_contains($name, 'thịt') || str_contains($name, 'gác bếp')) {
                        $icon = '🥩';
                    }
                    elseif (str_contains($name, 'lạp xưởng')) {
                        $icon = '🌭';
                    }
                    elseif (str_contains($name, 'mắc khén') || str_contains($name, 'hạt dổi') || str_contains($name, 'chẩm chéo') || str_contains($name, 'gia vị')) {
                        $icon = '🌶️';
                    }
                    elseif (str_contains($name, 'trà') || str_contains($name, 'thảo mộc')) {
                        $icon = '🍵';
                    }
                    elseif (str_contains($name, 'mật ong')) {
                        $icon = '🍯';
                    }
                    elseif (str_contains($name, 'gạo') || str_contains($name, 'nếp')) {
                        $icon = '🍚';
                    }
                    elseif (str_contains($name, 'quà') || str_contains($name, 'biếu')) {
                        $icon = '🎁';
                    }
                    elseif (str_contains($name, 'khô') || str_contains($name, 'táo mèo')) {
                        $icon = '🧺';
                    }


                    $productCount =
                        $category
                            ->products()
                            ->count();

                @endphp



                <div class="col">

                    <div class="card category-card">


                        {{-- ICON --}}
                        <div class="category-icon-box">

                            {{ $icon }}

                        </div>



                        {{-- BODY --}}
                        <div
                            class="
                                card-body
                                p-4
                                d-flex
                                flex-column
                            "
                        >

                            <div class="mb-2">

                                <span class="category-count">

                                    {{ $productCount }}
                                    sản phẩm

                                </span>

                            </div>


                            <h4 class="fw-bold mb-2">

                                {{ $category->name }}

                            </h4>


                            <p
                                class="
                                    text-muted
                                    small
                                    flex-grow-1
                                "
                            >

                                Khám phá các sản phẩm
                                thuộc danh mục
                                {{ $category->name }}
                                tại Tinh Hoa Tây Bắc.

                            </p>



                            {{-- ==================================
                                ADMIN
                            ================================== --}}
                            @if(
                                Auth::check()
                                &&
                                Auth::user()->role === 'admin'
                            )

                                <a
                                    href="{{
                                        route(
                                            'admin.categories.show',
                                            $category->id
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-outline-primary
                                        category-btn
                                        w-100
                                    "
                                >
                                    ⚙️ Xem & quản lý
                                </a>


                            {{-- ==================================
                                CUSTOMER
                            ================================== --}}
                            @else

                                <a
                                    href="{{
                                        route(
                                            'categories.show',
                                            $category->id
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-primary
                                        category-btn
                                        w-100
                                    "
                                >
                                    🌿 Xem đặc sản
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


    @endif



    {{-- ==========================================
        PHÂN TRANG
    ========================================== --}}
    @if(
        method_exists(
            $categories,
            'hasPages'
        )
        &&
        $categories->hasPages()
    )

        <div
            class="
                d-flex
                justify-content-center
                mt-5
            "
        >

            {{ $categories->links() }}

        </div>

    @endif


</div>

@endsection