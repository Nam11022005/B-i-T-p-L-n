<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng ký | Tinh Hoa Tây Bắc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
           PAGE
        ========================= */

        .register-page {
            position: relative;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px 20px;

            overflow: hidden;
        }

        .register-page::before {
            content: "";

            position: absolute;

            width: 350px;
            height: 350px;

            top: -180px;
            left: -150px;

            border-radius: 50%;

            background: rgba(95, 52, 29, 0.06);
        }

        .register-page::after {
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
           CONTAINER
        ========================= */

        .register-container {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 1100px;
            min-height: 680px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            overflow: hidden;

            border: 1px solid rgba(95, 52, 29, 0.10);
            border-radius: 30px;

            background: #fff;

            box-shadow:
                0 30px 80px rgba(44, 24, 16, 0.17);
        }

        /* =========================
           LEFT
        ========================= */

        .register-left {
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

        .register-left::before {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            top: -130px;
            right: -130px;

            border-radius: 50%;

            background: rgba(242, 193, 92, 0.12);
        }

        .register-left::after {
            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            left: -100px;
            bottom: -100px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.05);
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

            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 23px;

            background: rgba(255, 255, 255, 0.10);

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

            font-size: 39px;
            font-weight: 900;

            line-height: 1.2;
        }

        .left-description {
            max-width: 420px;

            margin-bottom: 32px;

            color: rgba(255, 255, 255, 0.80);

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

            color: rgba(255, 255, 255, 0.92);

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
           RIGHT
        ========================= */

        .register-right {
            padding: 48px 55px;

            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #fffdfa 100%
                );
        }

        .register-form-wrapper {
            width: 100%;
        }

        .mobile-brand {
            display: none;

            margin-bottom: 8px;

            color: var(--tb-green);

            font-size: 14px;
            font-weight: 900;

            letter-spacing: 1px;
        }

        .register-heading {
            margin-bottom: 25px;
        }

        .register-heading h1 {
            margin: 0 0 7px;

            color: var(--tb-brown-dark);

            font-size: 35px;
            font-weight: 900;
        }

        .register-heading p {
            margin: 0;

            color: #776960;

            font-size: 14px;
        }

        /* =========================
           ALERT
        ========================= */

        .register-alert {
            margin-bottom: 20px;

            padding: 13px 16px;

            border: 1px solid #efc1ba;
            border-radius: 12px;

            color: #8d3026;

            background: #fff3f1;

            font-size: 14px;
            line-height: 1.6;
        }

        .register-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        /* =========================
           LABEL
        ========================= */

        .register-label {
            margin-bottom: 7px;

            display: block;

            color: var(--tb-brown-dark);

            font-size: 14px;
            font-weight: 700;
        }

        /* =========================
           INPUT
        ========================= */

        .input-wrapper {
            position: relative;

            margin-bottom: 17px;
        }

        .input-icon {
            position: absolute;

            z-index: 2;

            left: 16px;
            top: 50%;

            transform: translateY(-50%);

            color: #877368;

            font-size: 16px;

            pointer-events: none;
        }

        .register-input {
            width: 100%;
            height: 51px;

            padding:
                0 47px
                0 47px;

            border: 1px solid #ddc9b4;
            border-radius: 13px;

            outline: none;

            color: var(--tb-text);

            background: #fffdf9;

            font-size: 14px;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .register-input:hover {
            border-color: #c9a987;
        }

        .register-input:focus {
            border-color: var(--tb-orange);

            background: #fff;

            box-shadow:
                0 0 0 4px
                rgba(217, 119, 6, 0.10);
        }

        .register-input::placeholder {
            color: #b3a69d;
        }

        /* =========================
           PASSWORD BUTTON
        ========================= */

        .toggle-password {
            position: absolute;

            z-index: 3;

            right: 14px;
            top: 50%;

            transform: translateY(-50%);

            width: 34px;
            height: 34px;

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
           PASSWORD NOTE
        ========================= */

        .password-note {
            margin-top: -7px;
            margin-bottom: 17px;

            color: #91837a;

            font-size: 12px;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-register {
            position: relative;

            width: 100%;
            height: 53px;

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

        .btn-register::before {
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

        .btn-register:hover {
            transform: translateY(-2px);

            box-shadow:
                0 15px 30px
                rgba(95, 52, 29, 0.28);
        }

        .btn-register:hover::before {
            left: 120%;
        }

        /* =========================
           DIVIDER
        ========================= */

        .divider {
            margin: 23px 0 18px;

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
           LOGIN LINK
        ========================= */

        .login-text {
            margin: 0;

            text-align: center;

            color: #665950;

            font-size: 14px;
        }

        .login-text a {
            color: var(--tb-red);

            font-weight: 800;

            text-decoration: none;
        }

        .login-text a:hover {
            color: var(--tb-brown);

            text-decoration: underline;
        }

        /* =========================
           HOME
        ========================= */

        .back-home {
            margin-top: 17px;

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
        ========================= */

        @media (max-width: 900px) {

            .register-container {
                max-width: 580px;

                grid-template-columns: 1fr;

                min-height: auto;
            }

            .register-left {
                display: none;
            }

            .register-right {
                padding: 45px 40px;
            }

            .mobile-brand {
                display: block;
            }
        }

        @media (max-width: 520px) {

            .register-page {
                padding: 15px 12px;
            }

            .register-container {
                border-radius: 21px;
            }

            .register-right {
                padding: 32px 22px;
            }

            .register-heading h1 {
                font-size: 29px;
            }

            .register-heading p {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<div class="register-page">

    <div class="register-container">

        {{-- =====================================
             BÊN TRÁI
        ====================================== --}}

        <section class="register-left">

            <div class="left-content">

                <div class="logo-box">
                    🌿
                </div>

                <div class="brand-small">
                    Tinh Hoa Tây Bắc
                </div>

                <h2 class="left-title">
                    Khám phá hương vị
                    <br>
                    núi rừng Tây Bắc
                </h2>

                <p class="left-description">
                    Tạo tài khoản Tinh Hoa Tây Bắc để dễ dàng
                    mua sắm những đặc sản được chọn lọc,
                    quản lý đơn hàng và nhận nhiều chương trình
                    ưu đãi hấp dẫn.
                </p>

                <div class="benefits">

                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Mua sắm đặc sản Tây Bắc dễ dàng
                        </span>

                    </div>

                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Theo dõi và quản lý đơn hàng
                        </span>

                    </div>

                    <div class="benefit-item">

                        <span class="benefit-check">
                            ✓
                        </span>

                        <span>
                            Nhận khuyến mãi dành cho thành viên
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

                </div>

            </div>

        </section>


        {{-- =====================================
             BÊN PHẢI - FORM ĐĂNG KÝ
        ====================================== --}}

        <section class="register-right">

            <div class="register-form-wrapper">

                <div class="register-heading">

                    <div class="mobile-brand">
                        🌿 TINH HOA TÂY BẮC
                    </div>

                    <h1>
                        Tạo tài khoản
                    </h1>

                    <p>
                        Đăng ký để bắt đầu mua sắm tại Tinh Hoa Tây Bắc
                    </p>

                </div>


                {{-- =====================================
                     LỖI VALIDATION
                ====================================== --}}

                @if ($errors->any())

                    <div class="register-alert">

                        <strong>
                            ⚠ Vui lòng kiểm tra lại thông tin
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
                     FORM
                     GIỮ NGUYÊN ROUTE ĐĂNG KÝ
                ====================================== --}}

                <form
                    method="POST"
                    action="{{ route('register') }}"
                >

                    @csrf


                    {{-- =====================
                         HỌ TÊN
                    ====================== --}}

                    <label
                        for="name"
                        class="register-label"
                    >
                        Họ và tên
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            👤
                        </span>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="register-input"
                            placeholder="Nhập họ và tên"
                            autocomplete="name"
                            required
                            autofocus
                        >

                    </div>


                    {{-- =====================
                         EMAIL
                    ====================== --}}

                    <label
                        for="email"
                        class="register-label"
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
                            class="register-input"
                            placeholder="Nhập địa chỉ email"
                            autocomplete="email"
                            required
                        >

                    </div>


                    {{-- =====================
                         MẬT KHẨU
                    ====================== --}}

                    <label
                        for="password"
                        class="register-label"
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
                            class="register-input"
                            placeholder="Nhập mật khẩu"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('password', this)"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    {{-- =====================
                         XÁC NHẬN MẬT KHẨU
                    ====================== --}}

                    <label
                        for="password_confirmation"
                        class="register-label"
                    >
                        Xác nhận mật khẩu
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔐
                        </span>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="register-input"
                            placeholder="Nhập lại mật khẩu"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="
                                togglePassword(
                                    'password_confirmation',
                                    this
                                )
                            "
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    {{-- =====================
                         BUTTON ĐĂNG KÝ
                    ====================== --}}

                    <button
                        type="submit"
                        class="btn-register"
                    >
                        Tạo tài khoản
                    </button>


                    <div class="divider">
                        hoặc
                    </div>


                    {{-- =====================
                         LOGIN
                    ====================== --}}

                    <p class="login-text">

                        Đã có tài khoản?

                        <a href="{{ route('login') }}">
                            Đăng nhập ngay
                        </a>

                    </p>


                    {{-- =====================
                         HOME
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
     HIỆN / ẨN MẬT KHẨU
====================================== --}}

<script>

    function togglePassword(inputId, button) {

        const input =
            document.getElementById(inputId);

        if (!input) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            button.textContent = '🙈';

            button.title = 'Ẩn mật khẩu';

        } else {

            input.type = 'password';

            button.textContent = '👁';

            button.title = 'Hiện mật khẩu';

        }

    }

</script>

</body>
</html>