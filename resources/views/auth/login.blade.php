<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập | Tinh Hoa Tây Bắc</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --tb-brown: #5f341d;
            --tb-brown-dark: #2c1810;
            --tb-red: #a83b2d;
            --tb-orange: #d97706;
            --tb-gold: #f2c15c;
            --tb-green: #48633b;
            --tb-cream: #fffaf0;
            --tb-soft: #f8efe2;
            --tb-border: #ead8bf;
            --tb-text: #2f241e;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;

            font-family:
                "Segoe UI",
                Tahoma,
                Geneva,
                Verdana,
                sans-serif;

            color: var(--tb-text);

            background:
                radial-gradient(
                    circle at 10% 15%,
                    rgba(242, 193, 92, 0.20),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    rgba(72, 99, 59, 0.16),
                    transparent 27%
                ),
                linear-gradient(
                    135deg,
                    #fffaf0 0%,
                    #f8efe2 50%,
                    #f2e6d6 100%
                );
        }

        /* =========================
           TRANG ĐĂNG NHẬP
        ========================== */

        .login-page {
            position: relative;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px 20px;

            overflow: hidden;
        }

        .login-page::before {
            content: "";

            position: absolute;

            width: 350px;
            height: 350px;

            top: -180px;
            left: -150px;

            border-radius: 50%;

            background: rgba(95, 52, 29, 0.06);
        }

        .login-page::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            right: -140px;
            bottom: -160px;

            border-radius: 50%;

            background: rgba(72, 99, 59, 0.08);
        }

        /* =========================
           KHUNG CHÍNH
        ========================== */

        .login-container {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 1080px;
            min-height: 620px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            overflow: hidden;

            border:
                1px solid rgba(95, 52, 29, 0.10);

            border-radius: 30px;

            background: #fff;

            box-shadow:
                0 30px 80px rgba(44, 24, 16, 0.17);
        }

        /* =========================
           BÊN TRÁI
        ========================== */

        .login-left {
            position: relative;

            padding: 60px 55px;

            display: flex;
            align-items: center;

            overflow: hidden;

            color: #fff;

            background:
                linear-gradient(
                    145deg,
                    #2c1810 0%,
                    #5f341d 53%,
                    #48633b 100%
                );
        }

        .login-left::before {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            top: -130px;
            right: -130px;

            border-radius: 50%;

            background:
                rgba(242, 193, 92, 0.12);
        }

        .login-left::after {
            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            left: -100px;
            bottom: -100px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.05);
        }

        .left-content {
            position: relative;
            z-index: 2;

            width: 100%;
        }

        .logo-box {
            width: 82px;
            height: 82px;

            margin-bottom: 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid rgba(255, 255, 255, 0.22);

            border-radius: 23px;

            background:
                rgba(255, 255, 255, 0.10);

            box-shadow:
                inset 0 1px 0
                rgba(255, 255, 255, 0.12);

            font-size: 40px;
        }

        .brand-small {
            margin-bottom: 10px;

            color: var(--tb-gold);

            font-size: 14px;
            font-weight: 900;

            letter-spacing: 2.2px;

            text-transform: uppercase;
        }

        .left-title {
            margin: 0 0 18px;

            font-size: 40px;
            font-weight: 900;

            line-height: 1.18;
        }

        .left-description {
            max-width: 420px;

            margin-bottom: 32px;

            color:
                rgba(255, 255, 255, 0.80);

            font-size: 15px;
            line-height: 1.8;
        }

        .benefits {
            display: flex;
            flex-direction: column;

            gap: 14px;
        }

        .benefit-item {
            display: flex;
            align-items: center;

            gap: 12px;

            color:
                rgba(255, 255, 255, 0.92);

            font-size: 14px;
        }

        .benefit-check {
            width: 29px;
            height: 29px;

            flex: 0 0 29px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: var(--tb-brown-dark);

            background: var(--tb-gold);

            font-size: 13px;
            font-weight: 900;
        }

        /* =========================
           BÊN PHẢI
        ========================== */

        .login-right {
            padding: 55px;

            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #fffdfa 100%
                );
        }

        .login-form-wrapper {
            width: 100%;
        }

        .mobile-brand {
            display: none;

            margin-bottom: 10px;

            color: var(--tb-green);

            font-size: 14px;
            font-weight: 900;

            letter-spacing: 1px;
        }

        .login-heading {
            margin-bottom: 31px;
        }

        .login-heading h1 {
            margin: 0 0 8px;

            color: var(--tb-brown-dark);

            font-size: 36px;
            font-weight: 900;
        }

        .login-heading p {
            margin: 0;

            color: #776960;

            font-size: 15px;
        }

        /* =========================
           ALERT
        ========================== */

        .login-alert {
            margin-bottom: 22px;

            padding: 14px 16px;

            border-radius: 12px;

            font-size: 14px;

            line-height: 1.6;
        }

        .login-alert-danger {
            border: 1px solid #efc1ba;

            color: #8d3026;

            background: #fff3f1;
        }

        .login-alert-success {
            border: 1px solid #b8d9c1;

            color: #285d38;

            background: #eff9f1;
        }

        .login-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        /* =========================
           LABEL
        ========================== */

        .login-label {
            margin-bottom: 8px;

            display: block;

            color: var(--tb-brown-dark);

            font-size: 14px;
            font-weight: 750;
        }

        /* =========================
           INPUT
        ========================== */

        .input-wrapper {
            position: relative;

            margin-bottom: 21px;
        }

        .input-icon {
            position: absolute;

            z-index: 2;

            left: 16px;
            top: 50%;

            transform: translateY(-50%);

            color: #877368;

            font-size: 17px;

            pointer-events: none;
        }

        .login-input {
            width: 100%;
            height: 54px;

            padding:
                0 47px
                0 47px;

            border:
                1px solid #ddc9b4;

            border-radius: 13px;

            outline: none;

            color: var(--tb-text);

            background: #fffdf9;

            font-size: 15px;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .login-input:hover {
            border-color: #c9a987;
        }

        .login-input:focus {
            border-color:
                var(--tb-orange);

            background: #fff;

            box-shadow:
                0 0 0 4px
                rgba(217, 119, 6, 0.10);
        }

        .login-input::placeholder {
            color: #b3a69d;
        }

        /* =========================
           HIỆN MẬT KHẨU
        ========================== */

        .toggle-password {
            position: absolute;

            z-index: 3;

            right: 15px;
            top: 50%;

            transform: translateY(-50%);

            width: 33px;
            height: 33px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            border-radius: 8px;

            color: #7b6b61;

            background: transparent;

            cursor: pointer;

            transition: .2s;
        }

        .toggle-password:hover {
            color: var(--tb-brown);

            background: var(--tb-soft);
        }

        /* =========================
           OPTIONS
        ========================== */

        .login-options {
            margin-top: -3px;
            margin-bottom: 25px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            font-size: 13px;
        }

        .remember-box {
            margin: 0;

            display: flex;
            align-items: center;

            gap: 7px;

            color: #685a51;

            cursor: pointer;
        }

        .remember-box input {
            width: 15px;
            height: 15px;

            accent-color:
                var(--tb-brown);
        }

        .forgot-password {
            color: var(--tb-red);

            font-weight: 700;

            text-decoration: none;

            transition: .2s;
        }

        .forgot-password:hover {
            color: var(--tb-brown);

            text-decoration: underline;
        }

        /* =========================
           BUTTON
        ========================== */

        .btn-login {
            position: relative;

            width: 100%;
            height: 54px;

            overflow: hidden;

            border: none;
            border-radius: 13px;

            color: #fff;

            background:
                linear-gradient(
                    90deg,
                    #5f341d 0%,
                    #8a3f29 55%,
                    #a83b2d 100%
                );

            font-size: 16px;
            font-weight: 800;

            box-shadow:
                0 11px 25px
                rgba(95, 52, 29, 0.21);

            cursor: pointer;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .btn-login::before {
            content: "";

            position: absolute;

            top: 0;
            left: -120%;

            width: 100%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.18),
                    transparent
                );

            transition: .5s;
        }

        .btn-login:hover {
            transform: translateY(-2px);

            box-shadow:
                0 15px 30px
                rgba(95, 52, 29, 0.28);
        }

        .btn-login:hover::before {
            left: 120%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* =========================
           DIVIDER
        ========================== */

        .divider {
            margin: 28px 0 22px;

            display: flex;
            align-items: center;

            gap: 12px;

            color: #a0938a;

            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";

            flex: 1;

            height: 1px;

            background: #eadfd4;
        }

        /* =========================
           REGISTER
        ========================== */

        .register-text {
            margin: 0;

            text-align: center;

            color: #665950;

            font-size: 14px;
        }

        .register-text a {
            color: var(--tb-red);

            font-weight: 800;

            text-decoration: none;
        }

        .register-text a:hover {
            color: var(--tb-brown);

            text-decoration: underline;
        }

        /* =========================
           HOME
        ========================== */

        .back-home {
            margin-top: 20px;

            text-align: center;
        }

        .back-home a {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            color: var(--tb-green);

            font-size: 13px;
            font-weight: 700;

            text-decoration: none;

            transition: .2s;
        }

        .back-home a:hover {
            color: var(--tb-brown);

            transform: translateX(-2px);
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 900px) {

            .login-container {
                max-width: 580px;
                min-height: auto;

                grid-template-columns: 1fr;
            }

            .login-left {
                display: none;
            }

            .login-right {
                padding: 48px 40px;
            }

            .mobile-brand {
                display: block;
            }
        }

        @media (max-width: 520px) {

            .login-page {
                padding: 16px 12px;
            }

            .login-container {
                border-radius: 21px;
            }

            .login-right {
                padding: 35px 22px;
            }

            .login-heading {
                margin-bottom: 26px;
            }

            .login-heading h1 {
                font-size: 30px;
            }

            .login-heading p {
                font-size: 14px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;

                gap: 10px;
            }
        }
    </style>
</head>

<body>

<div class="login-page">

    <div class="login-container">


        {{-- =====================================
             BÊN TRÁI - GIỚI THIỆU
        ====================================== --}}

        <section class="login-left">

            <div class="left-content">

                <div class="logo-box">
                    🌿
                </div>

                <div class="brand-small">
                    Tinh Hoa Tây Bắc
                </div>

                <h2 class="left-title">
                    Hương vị núi rừng
                    <br>
                    trong từng sản phẩm
                </h2>

                <p class="left-description">
                    Khám phá những đặc sản mang đậm hương vị
                    núi rừng Tây Bắc và trải nghiệm mua sắm
                    thuận tiện, nhanh chóng ngay tại nhà.
                </p>


                <div class="benefits">

                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Đặc sản Tây Bắc được chọn lọc
                        </span>

                    </div>


                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Giao hàng toàn quốc
                        </span>

                    </div>


                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Thanh toán tiện lợi và an toàn
                        </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================
             BÊN PHẢI - FORM LOGIN
        ====================================== --}}

        <section class="login-right">

            <div class="login-form-wrapper">


                {{-- HEADER --}}
                <div class="login-heading">

                    <div class="mobile-brand">
                        🌿 TINH HOA TÂY BẮC
                    </div>

                    <h1>
                        Đăng nhập
                    </h1>

                    <p>
                        Chào mừng bạn quay lại Tinh Hoa Tây Bắc
                    </p>

                </div>


                {{-- =====================================
                     HIỂN THỊ LỖI
                ====================================== --}}

                @if ($errors->any())

                    <div
                        class="
                            login-alert
                            login-alert-danger
                        "
                    >

                        <strong>
                            ⚠ Không thể đăng nhập
                        </strong>

                        <ul class="mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- =====================================
                     THÔNG BÁO THÀNH CÔNG
                ====================================== --}}

                @if (session('success'))

                    <div
                        class="
                            login-alert
                            login-alert-success
                        "
                    >
                        ✓ {{ session('success') }}
                    </div>

                @endif


                {{-- =====================================
                     FORM LOGIN
                     GIỮ NGUYÊN ROUTE CỦA BẠN
                ====================================== --}}

                <form
                    method="POST"
                    action="{{ route('login') }}"
                >

                    @csrf


                    {{-- =====================
                         EMAIL
                    ====================== --}}

                    <label
                        for="email"
                        class="login-label"
                    >
                        Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            ✉
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="login-input"
                            placeholder="Nhập địa chỉ email"
                            autocomplete="email"
                            required
                            autofocus
                        >

                    </div>


                    {{-- =====================
                         MẬT KHẨU
                    ====================== --}}

                    <label
                        for="password"
                        class="login-label"
                    >
                        Mật khẩu
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔒
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="login-input"
                            placeholder="Nhập mật khẩu"
                            autocomplete="current-password"
                            required
                        >


                        {{-- HIỆN / ẨN MẬT KHẨU --}}
                        <button
                            type="button"
                            id="togglePassword"
                            class="toggle-password"
                            title="Hiện mật khẩu"
                            aria-label="Hiện hoặc ẩn mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    {{-- =====================
                         GHI NHỚ + QUÊN MK
                    ====================== --}}

                    <div class="login-options">

                        <label class="remember-box">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <span>
                                Ghi nhớ đăng nhập
                            </span>

                        </label>


                        {{--
                            Hiện chưa nối chức năng
                            quên mật khẩu nên để #.
                        --}}

                        <a
                            href="{{ route('password.request') }}"
    class="forgot-password"
                        >
                            Quên mật khẩu?
                        </a>

                    </div>


                    {{-- =====================
                         BUTTON LOGIN
                    ====================== --}}

                    <button
                        type="submit"
                        class="btn-login"
                    >
                        Đăng nhập
                    </button>


                    {{-- =====================
                         PHÂN CÁCH
                    ====================== --}}

                    <div class="divider">
                        hoặc
                    </div>


                    {{-- =====================
                         ĐĂNG KÝ
                    ====================== --}}

                    <p class="register-text">

                        Chưa có tài khoản?

                        <a href="{{ route('register') }}">
                            Đăng ký ngay
                        </a>

                    </p>


                    {{-- =====================
                         TRANG CHỦ
                    ====================== --}}

                    <div class="back-home">

                        <a href="{{ url('/') }}">
                            ← Quay lại trang chủ
                        </a>

                    </div>

                </form>

            </div>

        </section>

    </div>

</div>


{{-- =====================================
     JAVASCRIPT HIỆN / ẨN MẬT KHẨU
====================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordInput =
            document.getElementById('password');


        if (!togglePassword || !passwordInput) {
            return;
        }


        togglePassword.addEventListener(
            'click',
            function () {

                const isPassword =
                    passwordInput.type === 'password';


                passwordInput.type =
                    isPassword
                        ? 'text'
                        : 'password';


                this.textContent =
                    isPassword
                        ? '🙈'
                        : '👁';


                this.title =
                    isPassword
                        ? 'Ẩn mật khẩu'
                        : 'Hiện mật khẩu';

            }
        );

    });
</script>

</body>
</html>