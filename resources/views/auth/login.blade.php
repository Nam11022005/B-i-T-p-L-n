@extends('layouts.app')

@section('title', 'Đăng nhập | Tinh Hoa Tây Bắc')

@section('hide-store-header', '1')

@section('content')

<style>
    /* =========================================================
       AUTH SHARED DESIGN
    ========================================================= */

    .tb-auth-page {
        --auth-brown: #633820;
        --auth-brown-dark: #2d1a11;
        --auth-green: #35562f;
        --auth-red: #b43e2e;
        --auth-gold: #e5ad42;
        --auth-cream: #fff8e9;
        --auth-border: #e7d4b7;
        --auth-text: #33261f;
        --auth-muted: #76685e;

        position: relative;
        isolation: isolate;

        width: 100%;

        padding:
            42px 0
            76px;
    }


    .tb-auth-page::before {
        content: "";

        position: absolute;
        z-index: -2;

        inset:
            -30px -40px 0;

        pointer-events: none;

        background:
            radial-gradient(
                circle at 7% 13%,
                rgba(229,173,66,.19),
                transparent 25%
            ),
            radial-gradient(
                circle at 92% 9%,
                rgba(53,86,47,.13),
                transparent 28%
            ),
            radial-gradient(
                circle at 50% 46%,
                rgba(180,62,46,.05),
                transparent 30%
            ),
            linear-gradient(
                180deg,
                #fff9ed 0%,
                #fdfbf7 52%,
                #faf9f7 100%
            );
    }


    /* =========================================================
       RETURN HOME
    ========================================================= */

    .tb-auth-return {
        width:
            min(
                1100px,
                100%
            );

        margin:
            0 auto
            16px;
    }


    .tb-auth-home-link {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        min-height: 42px;

        padding:
            9px 17px;

        border:
            1px solid
            #bdaa88;

        color:
            var(--auth-green);

        background:
            #fffaf0;

        font-size:
            13px;

        font-weight:
            800;

        text-decoration: none;

        transition:
            background .18s ease,
            border-color .18s ease,
            color .18s ease,
            transform .18s ease;
    }


    .tb-auth-home-link:hover {
        color: #fff;

        border-color:
            var(--auth-green);

        background:
            var(--auth-green);

        transform:
            translateY(-1px);
    }


    .tb-auth-home-link:focus-visible {
        outline:
            3px solid
            var(--auth-gold);

        outline-offset:
            3px;
    }


    /* =========================================================
       SHELL
    ========================================================= */

    .tb-auth-shell {
        position: relative;

        width:
            min(
                1100px,
                100%
            );

        margin:
            0 auto;

        display: grid;

        grid-template-columns:
            minmax(0, .92fr)
            minmax(0, 1.08fr);

        overflow: hidden;

        border:
            1px solid
            rgba(222,195,158,.88);

        border-radius:
            30px;

        background:
            #fff;

        box-shadow:
            0 32px 80px
            rgba(73,44,27,.14);
    }


    .tb-auth-shell::before {
        content: "";

        position: absolute;
        z-index: 10;

        top: 0;
        left: 8%;
        right: 8%;

        height:
            3px;

        border-radius:
            999px;

        background:
            linear-gradient(
                90deg,
                transparent,
                var(--auth-gold),
                var(--auth-red),
                var(--auth-green),
                transparent
            );

        pointer-events: none;
    }


    /* =========================================================
       BRAND PANEL
    ========================================================= */

    .tb-auth-brand {
        position: relative;

        overflow: hidden;

        min-height:
            620px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        padding:
            52px 46px;

        color:
            #fff;

        background:
            radial-gradient(
                circle at 82% 14%,
                rgba(229,173,66,.27),
                transparent 28%
            ),
            radial-gradient(
                circle at 12% 112%,
                rgba(180,62,46,.32),
                transparent 35%
            ),
            linear-gradient(
                145deg,
                #26140d 0%,
                #56301d 49%,
                #35562f 100%
            );
    }


    .tb-auth-brand::before {
        content: "";

        position: absolute;

        right:
            -70px;

        bottom:
            -55px;

        width:
            420px;

        height:
            250px;

        opacity:
            .13;

        clip-path:
            polygon(
                0 100%,
                18% 58%,
                34% 73%,
                53% 23%,
                70% 58%,
                85% 34%,
                100% 65%,
                100% 100%
            );

        background:
            linear-gradient(
                135deg,
                #fff,
                #f0bf5c
            );
    }


    .tb-auth-brand::after {
        content:
            "✦";

        position: absolute;

        top:
            30px;

        right:
            38px;

        color:
            #ffe291;

        font-size:
            90px;

        opacity:
            .055;

        transform:
            rotate(18deg);
    }


    .tb-auth-brand-top,
    .tb-auth-benefits {
        position: relative;
        z-index: 2;
    }


    .tb-auth-logo {
        width:
            58px;

        height:
            58px;

        display: grid;
        place-items: center;

        margin-bottom:
            24px;

        border:
            1px solid
            #d1a64d;

        border-radius:
            18px;

        background:
            linear-gradient(
                145deg,
                #fff6d5,
                #e9bd61
            );

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.55),
            0 12px 26px
            rgba(0,0,0,.14);
    }


    .tb-auth-logo .tb-brand-mark {
        width:
            38px;

        height:
            38px;
    }


    .tb-auth-kicker {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-bottom:
            18px;

        padding:
            8px 12px;

        border:
            1px solid
            rgba(229,173,66,.34);

        border-radius:
            999px;

        color:
            #f5d789;

        background:
            rgba(255,255,255,.06);

        font-size:
            12px;

        font-weight:
            900;

        letter-spacing:
            .08em;

        text-transform:
            uppercase;
    }


    .tb-auth-brand h1 {
        max-width:
            450px;

        margin:
            0;

        color:
            #fff;

        font-size:
            clamp(
                38px,
                4vw,
                56px
            );

        line-height:
            1.05;

        font-weight:
            950;

        letter-spacing:
            -1.2px;
    }


    .tb-auth-brand-copy {
        max-width:
            465px;

        margin:
            19px 0 0;

        color:
            rgba(255,255,255,.77);

        font-size:
            15px;

        line-height:
            1.75;
    }


    .tb-auth-benefits {
        display: grid;

        gap:
            11px;

        margin-top:
            34px;
    }


    .tb-auth-benefit {
        display: flex;
        align-items: center;

        gap:
            11px;

        padding:
            11px 13px;

        border:
            1px solid
            rgba(255,255,255,.09);

        border-radius:
            14px;

        color:
            rgba(255,255,255,.84);

        background:
            rgba(255,255,255,.045);

        font-size:
            14px;

        font-weight:
            700;
    }


    .tb-auth-benefit-icon {
        width:
            36px;

        height:
            36px;

        flex:
            0 0 36px;

        display: grid;
        place-items: center;

        border-radius:
            11px;

        background:
            rgba(255,255,255,.09);

        font-size:
            17px;
    }


    /* =========================================================
       FORM PANEL
    ========================================================= */

    .tb-auth-form-panel {
        position: relative;

        display: flex;
        flex-direction: column;
        justify-content: center;

        padding:
            54px 60px;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(229,173,66,.10),
                transparent 26%
            ),
            radial-gradient(
                circle at 0% 100%,
                rgba(53,86,47,.045),
                transparent 25%
            ),
            #fff;
    }


    .tb-auth-form-panel::after {
        content: "";

        position: absolute;

        top:
            25px;

        right:
            27px;

        width:
            90px;

        height:
            90px;

        border:
            1px solid
            rgba(99,56,32,.06);

        border-left:
            0;

        border-bottom:
            0;

        border-radius:
            0 24px 0 0;

        pointer-events:
            none;
    }


    .tb-auth-form-head {
        position: relative;
        z-index: 2;

        margin-bottom:
            26px;
    }


    .tb-auth-form-icon {
        width:
            42px;

        height:
            42px;

        display: grid;
        place-items: center;

        margin-bottom:
            15px;

        border:
            1px solid
            #e8d1ad;

        border-radius:
            13px;

        color:
            #7e4729;

        background:
            linear-gradient(
                135deg,
                #fff8e8,
                #f6e0b7
            );

        box-shadow:
            0 7px 15px
            rgba(99,56,32,.07);

        font-size:
            18px;
    }


    .tb-auth-form-head h2 {
        margin:
            0;

        color:
            #30231c;

        font-size:
            34px;

        line-height:
            1.15;

        font-weight:
            950;

        letter-spacing:
            -.7px;
    }


    .tb-auth-form-head p {
        margin:
            9px 0 0;

        color:
            var(--auth-muted);

        font-size:
            14px;

        line-height:
            1.65;
    }


    .tb-auth-trust {
        display: flex;
        flex-wrap: wrap;

        gap:
            8px;

        margin-bottom:
            24px;
    }


    .tb-auth-trust span {
        display: inline-flex;
        align-items: center;

        min-height:
            34px;

        padding:
            6px 11px;

        border:
            1px solid
            #e6dacb;

        border-radius:
            999px;

        color:
            #655349;

        background:
            #fffdf9;

        font-size:
            12px;

        font-weight:
            750;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .tb-auth-field {
        margin-bottom:
            18px;
    }


    .tb-auth-field-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap:
            15px;

        margin-bottom:
            8px;
    }


    .tb-auth-label {
        margin:
            0;

        color:
            #4c3529;

        font-size:
            14px;

        font-weight:
            850;
    }


    .tb-auth-link {
        color:
            var(--auth-red);

        font-size:
            13px;

        font-weight:
            800;

        text-decoration:
            none;
    }


    .tb-auth-link:hover {
        color:
            var(--auth-brown);

        text-decoration:
            underline;
    }


    .tb-auth-input-wrap {
        position:
            relative;
    }


    .tb-auth-input-icon {
        position:
            absolute;

        z-index:
            2;

        top:
            50%;

        left:
            17px;

        transform:
            translateY(-50%);

        pointer-events:
            none;

        font-size:
            16px;

        opacity:
            .68;
    }


    .tb-auth-input {
        width:
            100%;

        min-height:
            54px;

        padding:
            10px 48px;

        border:
            1px solid
            #dfcbae;

        border-radius:
            15px;

        outline:
            0;

        color:
            #34261f;

        background:
            linear-gradient(
                180deg,
                #fffefb,
                #fffaf3
            );

        font-size:
            14px;

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.95);

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }


    .tb-auth-input::placeholder {
        color:
            #a69990;
    }


    .tb-auth-input:hover {
        border-color:
            #d8b98e;
    }


    .tb-auth-input:focus {
        border-color:
            #cf9f5d;

        background:
            #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13);
    }


    .tb-auth-input.is-invalid {
        border-color:
            #c85a4b;
    }


    .tb-auth-password {
        padding-right:
            54px;
    }


    .tb-auth-toggle {
        position:
            absolute;

        z-index:
            3;

        top:
            50%;

        right:
            9px;

        transform:
            translateY(-50%);

        width:
            38px;

        height:
            38px;

        display: grid;
        place-items: center;

        padding:
            0;

        border:
            0;

        border-radius:
            10px;

        color:
            #705a4c;

        background:
            transparent;

        cursor:
            pointer;

        font-size:
            16px;
    }


    .tb-auth-toggle:hover,
    .tb-auth-toggle:focus {
        color:
            #4b2d1d;

        background:
            #f7eee2;

        outline:
            none;
    }


    .tb-auth-error {
        margin-top:
            7px;

        color:
            var(--auth-red);

        font-size:
            13px;

        font-weight:
            700;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .tb-auth-submit {
        position:
            relative;

        overflow:
            hidden;

        width:
            100%;

        min-height:
            56px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap:
            8px;

        margin-top:
            8px;

        border:
            0;

        border-radius:
            16px;

        color:
            #fff;

        background:
            linear-gradient(
                135deg,
                #b43e2e 0%,
                #633820 50%,
                #35562f 100%
            );

        box-shadow:
            0 13px 28px
            rgba(99,56,32,.21);

        font-size:
            15px;

        font-weight:
            900;

        cursor:
            pointer;

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }


    .tb-auth-submit:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 17px 32px
            rgba(99,56,32,.25);
    }


    /* =========================================================
       BOTTOM
    ========================================================= */

    .tb-auth-separator {
        display: flex;
        align-items: center;

        gap:
            13px;

        margin:
            25px 0 18px;

        color:
            #9b8a7f;

        font-size:
            11px;

        font-weight:
            800;
    }


    .tb-auth-separator::before,
    .tb-auth-separator::after {
        content:
            "";

        flex:
            1;

        height:
            1px;

        background:
            #ead8bf;
    }


    .tb-auth-alt-box {
        padding:
            14px 16px;

        border:
            1px solid
            #ead0a7;

        border-radius:
            14px;

        color:
            #6d584c;

        background:
            linear-gradient(
                135deg,
                #fffaf1,
                #fff4e2
            );

        text-align:
            center;

        font-size:
            14px;
    }


    .tb-auth-security {
        display: flex;
        align-items: flex-start;

        gap:
            10px;

        margin-top:
            17px;

        padding:
            13px 14px;

        border:
            1px solid
            #dce7d7;

        border-radius:
            13px;

        color:
            #52634c;

        background:
            #f5faf2;

        font-size:
            13px;

        line-height:
            1.55;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-auth-page {
            padding:
                30px 0
                60px;
        }


        .tb-auth-return,
        .tb-auth-shell {
            max-width:
                680px;
        }


        .tb-auth-shell {
            grid-template-columns:
                1fr;
        }


        .tb-auth-brand {
            min-height:
                360px;

            padding:
                38px 34px;
        }


        .tb-auth-benefits {
            grid-template-columns:
                repeat(
                    3,
                    1fr
                );
        }


        .tb-auth-benefit {
            align-items:
                flex-start;

            flex-direction:
                column;
        }


        .tb-auth-form-panel {
            padding:
                44px 38px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-auth-page {
            padding:
                20px 0
                50px;
        }


        .tb-auth-return {
            margin-bottom:
                12px;
        }


        .tb-auth-home-link {
            min-height:
                39px;

            padding:
                8px 14px;

            font-size:
                12px;
        }


        .tb-auth-shell {
            border-radius:
                22px;
        }


        .tb-auth-brand {
            min-height:
                315px;

            padding:
                30px 23px;
        }


        .tb-auth-brand h1 {
            font-size:
                36px;
        }


        .tb-auth-brand-copy {
            font-size:
                14px;
        }


        .tb-auth-benefits {
            grid-template-columns:
                1fr;

            margin-top:
                28px;
        }


        .tb-auth-form-panel {
            padding:
                34px 22px;
        }


        .tb-auth-form-head h2 {
            font-size:
                29px;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-auth-page *,
        .tb-auth-page *::before,
        .tb-auth-page *::after {
            transition:
                none !important;
        }

    }
</style>


<div class="tb-auth-page">

    <nav
        class="tb-auth-return"
        aria-label="Quay lại trang chủ"
    >
        <a
            href="{{ url('/') }}"
            class="tb-auth-home-link"
        >
            <span aria-hidden="true">
                ←
            </span>

            Quay lại trang chủ
        </a>
    </nav>


    <div class="tb-auth-shell">

        {{-- =====================================================
            LEFT
        ====================================================== --}}
        <aside class="tb-auth-brand">

            <div class="tb-auth-brand-top">

                <div class="tb-auth-logo">
                    @include(
                        'layouts.partials.brand-mark',
                        [
                            'variant' => 'header'
                        ]
                    )
                </div>


                <div class="tb-auth-kicker">
                    Tinh Hoa Tây Bắc
                </div>


                <h1>
                    Đậm vị núi rừng,
                    trọn tình Tây Bắc.
                </h1>


                <p class="tb-auth-brand-copy">

                    Đăng nhập để mua sắm nhanh hơn,
                    lưu địa chỉ giao hàng,
                    sử dụng voucher
                    và theo dõi toàn bộ hành trình đơn hàng
                    ngay trên Tinh Hoa Tây Bắc.

                </p>

            </div>


            <div class="tb-auth-benefits">

                <div class="tb-auth-benefit">

                    <span class="tb-auth-benefit-icon">
                        🛍
                    </span>

                    <span>
                        Khám phá đặc sản Tây Bắc chọn lọc
                    </span>

                </div>


                <div class="tb-auth-benefit">

                    <span class="tb-auth-benefit-icon">
                        📦
                    </span>

                    <span>
                        Theo dõi trạng thái đơn hàng thuận tiện
                    </span>

                </div>


                <div class="tb-auth-benefit">

                    <span class="tb-auth-benefit-icon">
                        🎟️
                    </span>

                    <span>
                        Sử dụng voucher và ưu đãi dễ dàng
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            RIGHT
        ====================================================== --}}
        <section class="tb-auth-form-panel">

            <div class="tb-auth-form-head">

                <div class="tb-auth-form-icon">
                    🔐
                </div>


                <h2>
                    Chào mừng trở lại
                </h2>


                <p>
                    Đăng nhập vào tài khoản của bạn
                    để tiếp tục mua sắm.
                </p>

            </div>


            <div class="tb-auth-trust">

                <span>
                    ✓ Đặc sản chọn lọc
                </span>

                <span>
                    🔒 Bảo mật tài khoản
                </span>

            </div>


            <form
                method="POST"
                action="{{ route('login') }}"
            >

                @csrf


                {{-- EMAIL --}}
                <div class="tb-auth-field">

                    <div class="tb-auth-field-head">

                        <label
                            for="email"
                            class="tb-auth-label"
                        >
                            Email
                        </label>

                    </div>


                    <div class="tb-auth-input-wrap">

                        <span class="tb-auth-input-icon">
                            ✉
                        </span>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="
                                tb-auth-input
                                @error('email')
                                    is-invalid
                                @enderror
                            "
                            placeholder="example@gmail.com"
                            autocomplete="email"
                            required
                            autofocus
                        >

                    </div>


                    @error('email')

                        <div class="tb-auth-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div class="tb-auth-field">

                    <div class="tb-auth-field-head">

                        <label
                            for="password"
                            class="tb-auth-label"
                        >
                            Mật khẩu
                        </label>


                        <a
                            href="{{ route('password.request') }}"
                            class="tb-auth-link"
                        >
                            Quên mật khẩu?
                        </a>

                    </div>


                    <div class="tb-auth-input-wrap">

                        <span class="tb-auth-input-icon">
                            🔒
                        </span>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="
                                tb-auth-input
                                tb-auth-password
                                @error('password')
                                    is-invalid
                                @enderror
                            "
                            placeholder="Nhập mật khẩu"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="tb-auth-toggle"
                            id="toggleLoginPassword"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    @error('password')

                        <div class="tb-auth-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="tb-auth-submit"
                >
                    <span>
                        🔐
                    </span>

                    <span>
                        Đăng nhập
                    </span>
                </button>

            </form>


            <div class="tb-auth-separator">
                HOẶC
            </div>


            <div class="tb-auth-alt-box">

                Chưa có tài khoản?

                <a
                    href="{{ route('register') }}"
                    class="tb-auth-link ms-1"
                >
                    Đăng ký ngay
                </a>

            </div>


            <div class="tb-auth-security">

                <span>
                    🛡️
                </span>

                <span>

                    Thông tin đăng nhập của bạn
                    được sử dụng để bảo vệ tài khoản
                    và các đơn hàng trên hệ thống.

                </span>

            </div>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const passwordInput =
            document.getElementById(
                'password'
            );


        const toggleButton =
            document.getElementById(
                'toggleLoginPassword'
            );


        if (
            !passwordInput
            ||
            !toggleButton
        ) {
            return;
        }


        toggleButton.addEventListener(
            'click',
            function () {

                const hidden =
                    passwordInput.type
                    ===
                    'password';


                passwordInput.type =
                    hidden
                        ? 'text'
                        : 'password';


                toggleButton.textContent =
                    hidden
                        ? '🙈'
                        : '👁';


                toggleButton.setAttribute(
                    'aria-label',
                    hidden
                        ? 'Ẩn mật khẩu'
                        : 'Hiện mật khẩu'
                );


                toggleButton.setAttribute(
                    'title',
                    hidden
                        ? 'Ẩn mật khẩu'
                        : 'Hiện mật khẩu'
                );

            }
        );

    }
);
</script>

@endsection