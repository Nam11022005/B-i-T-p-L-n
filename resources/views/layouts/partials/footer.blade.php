{{-- =========================================================
    FOOTER - TINH HOA TAY BAC
    resources/views/layouts/partials/footer.blade.php
========================================================= --}}

<style>
    /* =========================================================
       ROOT
    ========================================================= */

    .tb-footer {
        --ft-green: #35562f;
        --ft-green-dark: #274522;
        --ft-brown: #633820;
        --ft-brown-dark: #2d1a11;
        --ft-red: #b43e2e;
        --ft-gold: #e5ad42;

        position: relative;
        overflow: hidden;

        margin-top: 36px;

        color: rgba(255, 255, 255, .8);

        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(229, 173, 66, .17),
                transparent 27%
            ),
            radial-gradient(
                circle at 7% 92%,
                rgba(180, 62, 46, .17),
                transparent 30%
            ),
            linear-gradient(
                125deg,
                #28150d 0%,
                #4f2a18 48%,
                #30472b 100%
            );

        border-top:
            1px solid
            rgba(255, 255, 255, .08);
    }


    .tb-footer *,
    .tb-footer *::before,
    .tb-footer *::after {
        box-sizing: border-box;
    }


    .tb-footer a {
        text-decoration: none;
    }


    .tb-footer::before {
        content: "";

        position: absolute;
        inset: 0;

        opacity: .055;

        pointer-events: none;

        background-image:
            repeating-linear-gradient(
                135deg,
                rgba(255, 255, 255, .22) 0,
                rgba(255, 255, 255, .22) 1px,
                transparent 1px,
                transparent 25px
            );
    }


    .tb-footer-container {
        position: relative;
        z-index: 2;

        width:
            min(
                1480px,
                calc(100% - 38px)
            );

        margin: 0 auto;

        padding-top: 30px;
    }


    /* =========================================================
       SERVICE BAR
    ========================================================= */

    .tb-footer-services {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        overflow: hidden;

        margin:
            0 0 36px;

        border:
            1px solid
            #e5d1b3;

        border-radius: 18px;

        background:
            #fffaf0;

        box-shadow:
            0 14px 34px
            rgba(24, 15, 10, .16);
    }


    .tb-footer-service {
        min-height: 108px;

        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            20px 22px;

        color:
            #38291f;

        background:
            rgba(
                255,
                250,
                240,
                .98
            );
    }


    .tb-footer-service:not(:last-child) {
        border-right:
            1px solid
            #e8d7c1;
    }


    .tb-footer-service-icon {
        width: 50px;
        height: 50px;

        flex:
            0 0 50px;

        display: grid;
        place-items: center;

        border:
            1px solid
            #e2c696;

        border-radius: 14px;

        background:
            linear-gradient(
                145deg,
                #fff3cf,
                #edd39d
            );

        box-shadow:
            inset 0 1px 0
            rgba(255, 255, 255, .8);

        font-size: 22px;
    }


    .tb-footer-service strong {
        display: block;

        margin-bottom: 4px;

        color:
            #38271d;

        font-size: 15px;

        line-height: 1.3;

        font-weight: 900;
    }


    .tb-footer-service span {
        display: block;

        color:
            #786a60;

        font-size: 13px;

        line-height: 1.55;
    }


    /* =========================================================
       MAIN GRID
    ========================================================= */

    .tb-footer-main {
        display: grid;

        grid-template-columns:
            minmax(250px, 1.45fr)
            minmax(175px, 1fr)
            minmax(190px, 1fr);

        gap: 28px;

        padding:
            28px 0 38px;

        align-items: start;
    }


    /* =========================================================
       BRAND
    ========================================================= */

    .tb-footer-brand {
        max-width: 430px;
    }


    .tb-footer-logo {
        display: inline-flex;
        align-items: center;

        gap: 11px;

        margin-bottom: 16px;

        color: #fff;

        font-size: 22px;

        font-weight: 950;

        letter-spacing:
            -.03em;
    }


    .tb-footer-logo:hover {
        color:
            #ffd779;
    }


    .tb-footer-logo-icon {
        width: 47px;
        height: 47px;

        flex:
            0 0 47px;

        display: grid;
        place-items: center;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 14px;

        background:
            rgba(255, 255, 255, .07);

        font-size: 22px;
    }


    .tb-footer-description {
        max-width: 400px;

        margin: 0;

        color:
            rgba(255, 255, 255, .68);

        font-size: 13px;

        line-height: 1.8;
    }


    /* =========================================================
       CONTACT
    ========================================================= */

    .tb-footer-contact-list {
        display: grid;

        gap: 12px;

        margin-top: 21px;
    }


    .tb-footer-contact-item {
        display: grid;

        grid-template-columns:
            36px
            minmax(0, 1fr);

        gap: 10px;

        align-items: center;
    }


    .tb-footer-contact-icon {
        width: 36px;
        height: 36px;

        display: grid;
        place-items: center;

        border-radius: 10px;

        color:
            #ffd273;

        background:
            rgba(255, 255, 255, .07);

        font-size: 15px;
    }


    .tb-footer-contact-content strong {
        display: block;

        margin-bottom: 2px;

        color:
            rgba(255, 255, 255, .95);

        font-size: 13px;

        font-weight: 850;
    }


    .tb-footer-contact-content a,
    .tb-footer-contact-content span {
        color:
            rgba(255, 255, 255, .67);

        font-size: 13px;

        line-height: 1.5;
    }


    .tb-footer-contact-content a:hover {
        color:
            #ffd476;
    }


    /* =========================================================
       COLUMN TITLE
    ========================================================= */

    .tb-footer-title {
        position: relative;

        margin-bottom: 19px;

        padding-bottom: 11px;

        color: #fff;

        font-size: 15px;

        font-weight: 950;
    }


    .tb-footer-title::after {
        content: "";

        position: absolute;

        left: 0;
        bottom: 0;

        width: 34px;
        height: 2px;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                var(--ft-gold),
                var(--ft-red)
            );
    }


    /* =========================================================
       LINKS
    ========================================================= */

    .tb-footer-links {
        display: grid;

        gap: 11px;

        margin: 0;
        padding: 0;

        list-style: none;
    }


    .tb-footer-links a,
    .tb-footer-static-item {
        display: inline-flex;
        align-items: flex-start;

        gap: 6px;

        color:
            rgba(255, 255, 255, .68);

        font-size: 13px;

        line-height: 1.5;
    }


    .tb-footer-links a::before,
    .tb-footer-static-item::before {
        content: "›";

        flex:
            0 0 auto;

        color:
            var(--ft-gold);

        font-size: 16px;

        line-height: 1.2;
    }


    .tb-footer-links a {
        transition:
            color .16s ease,
            transform .16s ease;
    }


    .tb-footer-links a:hover {
        color: #fff;

        transform:
            translateX(3px);
    }


    /* =========================================================
       SOCIAL
    ========================================================= */

    .tb-footer-social-label {
        margin-top: 23px;
        margin-bottom: 10px;

        color:
            rgba(255, 255, 255, .9);

        font-size: 12px;

        font-weight: 850;
    }


    .tb-footer-social {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;
    }


    .tb-footer-social a {
        width: 38px;
        height: 38px;

        display: grid;
        place-items: center;

        border:
            1px solid
            rgba(255, 255, 255, .15);

        border-radius: 10px;

        color: #fff;

        background:
            rgba(255, 255, 255, .07);

        font-size: 14px;

        font-weight: 950;

        transition:
            transform .16s ease,
            background .16s ease,
            border-color .16s ease,
            color .16s ease;
    }


    .tb-footer-social a:hover {
        color:
            #352116;

        border-color:
            var(--ft-gold);

        background:
            var(--ft-gold);

        transform:
            translateY(-2px);
    }


    /* =========================================================
       SUPPORT BOX
    ========================================================= */

    .tb-footer-support {
        padding:
            18px;

        border:
            1px solid
            rgba(255, 255, 255, .13);

        border-radius: 15px;

        background:
            rgba(255, 255, 255, .06);

        box-shadow:
            inset 0 1px 0
            rgba(255, 255, 255, .03);
    }


    .tb-footer-support-title {
        color: #fff;

        font-size: 15px;

        font-weight: 950;
    }


    .tb-footer-support-text {
        margin-top: 7px;

        color:
            rgba(255, 255, 255, .65);

        font-size: 13px;

        line-height: 1.65;
    }


    .tb-footer-hotline {
        min-height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        margin-top: 14px;

        border-radius: 10px;

        color:
            #3a2518;

        background:
            linear-gradient(
                135deg,
                #ffd879,
                #e9ae42
            );

        font-size: 14px;

        font-weight: 950;

        box-shadow:
            0 8px 20px
            rgba(0, 0, 0, .13);
    }


    .tb-footer-hotline:hover {
        color:
            #3a2518;

        filter:
            brightness(1.04);
    }


    .tb-footer-payment {
        display: flex;
        flex-wrap: wrap;

        gap: 7px;

        margin-top: 14px;
    }


    .tb-footer-payment span {
        padding:
            6px 9px;

        border:
            1px solid
            rgba(255, 255, 255, .12);

        border-radius: 999px;

        color:
            rgba(255, 255, 255, .79);

        background:
            rgba(0, 0, 0, .09);

        font-size: 11px;

        font-weight: 800;
    }


    /* =========================================================
       BOTTOM
    ========================================================= */

    .tb-footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            21px 0 25px;

        border-top:
            1px solid
            rgba(255, 255, 255, .1);

        color:
            rgba(255, 255, 255, .55);

        font-size: 12px;
    }


    .tb-footer-bottom-links {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 12px;
    }


    .tb-footer-bottom-links a {
        color:
            rgba(255, 255, 255, .62);
    }


    .tb-footer-bottom-links a:hover {
        color: #fff;
    }


    /* =========================================================
       DESKTOP VỪA
    ========================================================= */

    @media (max-width: 1399.98px) {

        .tb-footer-main {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );

            gap:
                34px 38px;
        }


        .tb-footer-brand {
            max-width: none;
        }

    }


    /* =========================================================
       TABLET
    ========================================================= */

    @media (max-width: 1199.98px) {

        .tb-footer-services {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }


        .tb-footer-service:nth-child(2) {
            border-right: 0;
        }


        .tb-footer-service:nth-child(-n+2) {
            border-bottom:
                1px solid
                #e8d7c1;
        }


        .tb-footer-main {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap:
                35px 45px;
        }

    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 767.98px) {

        .tb-footer {
            margin-top:
                28px;
        }


        .tb-footer-container {
            width:
                min(
                    calc(100% - 24px),
                    1480px
                );

            padding-top:
                20px;
        }


        .tb-footer-services {
            grid-template-columns:
                1fr;

            margin-bottom:
                26px;

            border-radius:
                15px;
        }


        .tb-footer-service {
            min-height: 88px;

            padding:
                16px 17px;
        }


        .tb-footer-service:not(:last-child) {
            border-right: 0;

            border-bottom:
                1px solid
                #e8d7c1;
        }


        .tb-footer-main {
            grid-template-columns:
                1fr;

            gap:
                31px;

            padding:
                20px 0 30px;
        }


        .tb-footer-brand {
            max-width: none;
        }


        .tb-footer-bottom {
            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                9px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-footer-container {
            width:
                min(
                    calc(100% - 20px),
                    1480px
                );

            padding-top:
                16px;
        }


        .tb-footer-services {
            margin-bottom:
                22px;
        }


        .tb-footer-logo {
            font-size:
                20px;
        }


        .tb-footer-description,
        .tb-footer-links a,
        .tb-footer-static-item {
            font-size:
                13px;
        }


        .tb-footer-support {
            padding:
                16px;
        }

    }
</style>


<footer class="tb-footer">

    <div class="tb-footer-container">


        {{-- =====================================================
            MAIN FOOTER
        ====================================================== --}}

        <div class="tb-footer-main">


            {{-- =================================================
                BRAND
            ================================================== --}}

            <div class="tb-footer-brand">

                <a
                    href="{{ url('/') }}"
                    class="tb-footer-logo"
                >

                    <span class="tb-footer-logo-icon" aria-hidden="true">
                        @include('layouts.partials.brand-mark', ['variant' => 'footer'])
                    </span>

                    <span>
                        Tinh Hoa Tây Bắc
                    </span>

                </a>


                <p class="tb-footer-description">

                    Không gian mua sắm dành cho những
                    hương vị đặc trưng của vùng cao Tây Bắc:
                    thịt gác bếp, mắc khén, hạt dổi,
                    mật ong, trà Shan Tuyết
                    và nhiều đặc sản khác.

                </p>


                <div class="tb-footer-contact-list">

                    <div class="tb-footer-contact-item">

                        <div class="tb-footer-contact-icon">
                            ☎
                        </div>

                        <div class="tb-footer-contact-content">

                            <strong>
                                Hotline hỗ trợ
                            </strong>

                            <a href="tel:0385742505">
                                0385 742 505
                            </a>

                        </div>

                    </div>


                    <div class="tb-footer-contact-item">

                        <div class="tb-footer-contact-icon">
                            🕘
                        </div>

                        <div class="tb-footer-contact-content">

                            <strong>
                                Thời gian hỗ trợ
                            </strong>

                            <span>
                                08:00 - 21:00
                                · Thứ 2 - Chủ nhật
                            </span>

                        </div>

                    </div>

                </div>


                <div class="tb-footer-social-label">
                    Kết nối với Tinh Hoa Tây Bắc
                </div>


                <div class="tb-footer-social">

                    <a
                        href="https://www.facebook.com/Phuongnamm2005"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="Facebook"
                        aria-label="Facebook"
                    >
                        f
                    </a>


                    <a
                        href="https://www.tiktok.com/@mangnouhpod?lang=en"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="TikTok"
                        aria-label="TikTok"
                    >
                        ♪
                    </a>


                    <a
                        href="https://www.youtube.com/channel/UCvb46JAi4IfDdzzFWFtf6sg"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="YouTube"
                        aria-label="YouTube"
                    >
                        ▶
                    </a>


                    <a
                        href="https://zalo.me/0385742505"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="Zalo"
                        aria-label="Zalo"
                    >
                        Z
                    </a>

                </div>

            </div>


            {{-- =================================================
                CHĂM SÓC KHÁCH HÀNG
            ================================================== --}}

            <div>

                <div class="tb-footer-title">
                    Chăm sóc khách hàng
                </div>


                <ul class="tb-footer-links">

                    <li>
                        <a href="{{ route('products.index') }}">
                            Hướng dẫn chọn sản phẩm
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('products.promotions') }}">
                            Ưu đãi & khuyến mãi
                        </a>
                    </li>


                    <li>

                        @auth

                            @if(Auth::user()->role === 'admin')

                                <a href="{{ route('admin.orders.index') }}">
                                    Kiểm tra đơn hàng
                                </a>

                            @else

                                <a href="{{ route('orders.index') }}">
                                    Kiểm tra đơn hàng
                                </a>

                            @endif

                        @else

                            <a href="{{ route('login') }}">
                                Kiểm tra đơn hàng
                            </a>

                        @endauth

                    </li>


                    <li>
                        <a href="tel:0385742505">
                            Gọi hotline hỗ trợ
                        </a>
                    </li>


                    <li>
                        <a
                            href="https://zalo.me/0385742505"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Chat hỗ trợ qua Zalo
                        </a>
                    </li>

                </ul>

            </div>


           {{-- =================================================
    CHÍNH SÁCH & ĐIỀU KHOẢN
================================================== --}}

<div>

    <div class="tb-footer-title">
        Chính sách & điều khoản
    </div>


    <ul class="tb-footer-links">

        <li>
            <a href="{{ route('policies.shipping') }}">
                Chính sách giao hàng
            </a>
        </li>


        <li>
            <a href="{{ route('policies.returns') }}">
                Chính sách đổi trả
            </a>
        </li>


        <li>
            <a href="{{ route('policies.privacy') }}">
                Chính sách bảo mật
            </a>
        </li>


        <li>
            <a href="{{ route('policies.terms') }}">
                Điều khoản dịch vụ
            </a>
        </li>


        <li>
            <a href="{{ route('policies.payment') }}">
                Chính sách thanh toán
            </a>
        </li>

    </ul>

</div>

            


        {{-- =====================================================
            BOTTOM
        ====================================================== --}}

        <div class="tb-footer-bottom">

            <div>

                © {{ now()->year }}
                Tinh Hoa Tây Bắc.
                All rights reserved.

            </div>


            <div class="tb-footer-bottom-links">

                <a href="{{ url('/') }}">
                    Trang chủ
                </a>


                <span>
                    ·
                </span>


                <a href="{{ route('products.index') }}">
                    Sản phẩm
                </a>


                <span>
                    ·
                </span>


                <a href="{{ route('products.promotions') }}">
                    Khuyến mãi
                </a>


                @auth

                    @if(Auth::user()->role !== 'admin')

                        <span>
                            ·
                        </span>

                        <a href="{{ route('dashboard') }}">
                            Tổng quan
                        </a>

                    @endif

                @endauth

            </div>

        </div>

    </div>

</footer>