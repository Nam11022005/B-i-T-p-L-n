@extends('layouts.app')

@section('title', 'Đặt mật khẩu mới | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       RESET PASSWORD - STEP 3
       TINH HOA TÂY BẮC
    ========================================================= */

    .tb-new-password-page {
        --np-brown: #633820;
        --np-green: #35562f;
        --np-red: #b43e2e;
        --np-gold: #e5ad42;
        --np-muted: #76685e;

        position: relative;
        isolation: isolate;
        width: 100%;
        padding: 42px 0 72px;
    }

    .tb-new-password-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        inset: -30px -40px 0;
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

    .tb-new-password-shell {
        position: relative;
        width: min(1100px, 100%);
        margin: 0 auto;

        display: grid;

        grid-template-columns:
            minmax(0, .92fr)
            minmax(0, 1.08fr);

        overflow: hidden;

        border:
            1px solid
            rgba(222,195,158,.88);

        border-radius: 30px;
        background: #fff;

        box-shadow:
            0 32px 80px
            rgba(73,44,27,.14);
    }

    .tb-new-password-shell::before {
        content: "";
        position: absolute;
        z-index: 10;

        top: 0;
        left: 8%;
        right: 8%;

        height: 3px;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                transparent,
                var(--np-gold),
                var(--np-red),
                var(--np-green),
                transparent
            );
    }

    /* =========================================================
       LEFT PANEL
    ========================================================= */

    .tb-new-password-brand {
        position: relative;
        overflow: hidden;

        min-height: 640px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        padding: 52px 46px;

        color: #fff;

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

    .tb-new-password-brand::before {
        content: "";
        position: absolute;

        right: -70px;
        bottom: -55px;

        width: 420px;
        height: 250px;

        opacity: .13;

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

    .tb-new-password-brand::after {
        content: "•";

        position: absolute;

        top: 28px;
        right: 36px;

        font-size: 92px;
        opacity: .055;

        transform: rotate(-10deg);
    }

    .tb-new-password-brand-top,
    .tb-new-password-steps {
        position: relative;
        z-index: 2;
    }

    .tb-new-password-logo {
        width: 58px;
        height: 58px;

        display: grid;
        place-items: center;

        margin-bottom: 24px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 18px;

        background:
            rgba(255,255,255,.08);

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.12),
            0 12px 26px
            rgba(0,0,0,.14);

        font-size: 25px;
    }

    .tb-new-password-kicker {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 18px;
        padding: 8px 12px;

        border:
            1px solid
            rgba(229,173,66,.34);

        border-radius: 999px;

        color: #f5d789;

        background:
            rgba(255,255,255,.06);

        font-size: 12px;
        font-weight: 900;

        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tb-new-password-brand h1 {
        max-width: 470px;
        margin: 0;

        color: #fff;

        font-size:
            clamp(
                38px,
                4vw,
                56px
            );

        line-height: 1.05;

        font-weight: 950;

        letter-spacing: -1.2px;
    }

    .tb-new-password-copy {
        max-width: 470px;

        margin: 19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size: 15px;

        line-height: 1.75;
    }

    /* =========================================================
       STEPS
    ========================================================= */

    .tb-new-password-steps {
        display: grid;
        gap: 10px;

        margin-top: 34px;
    }

    .tb-new-password-step {
        display: flex;
        align-items: center;

        gap: 11px;

        padding: 11px 13px;

        border:
            1px solid
            rgba(255,255,255,.08);

        border-radius: 14px;

        color:
            rgba(255,255,255,.72);

        background:
            rgba(255,255,255,.04);

        font-size: 14px;
        font-weight: 700;
    }

    .tb-new-password-step.done {
        color:
            rgba(255,255,255,.9);

        border-color:
            rgba(94,160,85,.20);

        background:
            rgba(53,86,47,.18);
    }

    .tb-new-password-step.active {
        color: #fff;

        border-color:
            rgba(229,173,66,.28);

        background:
            rgba(229,173,66,.11);
    }

    .tb-new-password-step-number {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        display: grid;
        place-items: center;

        border:
            1px solid
            rgba(255,255,255,.10);

        border-radius: 11px;

        color: #f3d37d;

        background:
            rgba(255,255,255,.08);

        font-weight: 950;
    }

    .tb-new-password-step.done
    .tb-new-password-step-number {
        color: #fff;
        background: #58784e;
    }

    .tb-new-password-step.active
    .tb-new-password-step-number {
        color: #432a18;

        background:
            linear-gradient(
                135deg,
                #f6d77f,
                #e5ad42
            );
    }

    /* =========================================================
       RIGHT PANEL
    ========================================================= */

    .tb-new-password-panel {
        position: relative;

        display: flex;
        flex-direction: column;
        justify-content: center;

        padding: 52px 62px;

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

    .tb-new-password-panel::after {
        content: "";

        position: absolute;

        top: 25px;
        right: 27px;

        width: 90px;
        height: 90px;

        border:
            1px solid
            rgba(99,56,32,.06);

        border-left: 0;
        border-bottom: 0;

        border-radius:
            0 24px 0 0;

        pointer-events: none;
    }

    .tb-new-password-icon {
        width: 82px;
        height: 82px;

        display: grid;
        place-items: center;

        margin-bottom: 22px;

        border:
            1px solid
            #e4c78f;

        border-radius: 25px;

        background:
            radial-gradient(
                circle at 30% 24%,
                rgba(255,255,255,.95),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #fff1c8,
                #efd28e
            );

        box-shadow:
            0 14px 30px
            rgba(99,56,32,.10),
            inset 0 1px 0
            rgba(255,255,255,.95);

        font-size: 37px;
    }

    .tb-new-password-head {
        margin-bottom: 24px;
    }

    .tb-new-password-head h2 {
        margin: 0;

        color: #30231c;

        font-size: 34px;

        line-height: 1.15;
        font-weight: 950;

        letter-spacing: -.7px;
    }

    .tb-new-password-head p {
        margin: 10px 0 0;

        max-width: 520px;

        color: var(--np-muted);

        font-size: 14px;

        line-height: 1.68;
    }

    /* =========================================================
       ALERT
    ========================================================= */

    .tb-new-password-alert {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 18px;
        padding: 13px 15px;

        border-radius: 13px;

        font-size: 13px;
        line-height: 1.55;
    }

    .tb-new-password-alert.success {
        border:
            1px solid
            #bed7b5;

        color: #405b37;

        background: #f2f8ef;
    }

    .tb-new-password-alert.error {
        border:
            1px solid
            #e2b7af;

        color: #8e3428;

        background: #fff4f1;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .tb-new-password-field {
        margin-bottom: 17px;
    }

    .tb-new-password-label {
        display: block;

        margin-bottom: 8px;

        color: #4c3529;

        font-size: 14px;
        font-weight: 850;
    }

    .tb-new-password-input-wrap {
        position: relative;
    }

    .tb-new-password-input-icon {
        position: absolute;
        z-index: 2;

        top: 50%;
        left: 17px;

        transform:
            translateY(-50%);

        pointer-events: none;

        font-size: 17px;
        opacity: .7;
    }

    .tb-new-password-input {
        width: 100%;
        min-height: 54px;

        padding:
            10px 54px
            10px 48px;

        border:
            1px solid
            #dfcbae;

        border-radius: 15px;

        outline: none;

        color: #34261f;

        background:
            linear-gradient(
                180deg,
                #fffefb,
                #fffaf3
            );

        font-size: 14px;

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.95);

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .tb-new-password-input::placeholder {
        color: #a69990;
    }

    .tb-new-password-input:hover {
        border-color: #d8b98e;
    }

    .tb-new-password-input:focus {
        border-color: #cf9f5d;
        background: #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13);
    }

    .tb-new-password-input.is-invalid {
        border-color: #c85a4b;
    }

    .tb-new-password-toggle {
        position: absolute;
        z-index: 3;

        top: 50%;
        right: 9px;

        transform:
            translateY(-50%);

        width: 38px;
        height: 38px;

        display: grid;
        place-items: center;

        padding: 0;

        border: 0;
        border-radius: 10px;

        color: #705a4c;

        background: transparent;

        cursor: pointer;

        font-size: 17px;
    }

    .tb-new-password-toggle:hover,
    .tb-new-password-toggle:focus {
        color: #4b2d1d;

        background: #f7eee2;

        outline: none;
    }

    .tb-new-password-error {
        margin-top: 7px;

        color: #b43e2e;

        font-size: 13px;
        font-weight: 700;
    }

    /* =========================================================
       PASSWORD STRENGTH
    ========================================================= */

    .tb-new-password-help {
        margin-top: 8px;

        color: #8b7c72;

        font-size: 12px;

        line-height: 1.5;
    }

    .tb-new-password-strength {
        display: grid;

        grid-template-columns:
            repeat(4,1fr);

        gap: 5px;

        margin-top: 9px;
    }

    .tb-new-password-strength span {
        height: 4px;

        border-radius: 999px;

        background: #eadfd3;

        transition: background .18s ease;
    }

    .tb-new-password-strength.level-1
    span:nth-child(1) {
        background: #b43e2e;
    }

    .tb-new-password-strength.level-2
    span:nth-child(-n+2) {
        background: #d58a30;
    }

    .tb-new-password-strength.level-3
    span:nth-child(-n+3) {
        background: #77914d;
    }

    .tb-new-password-strength.level-4
    span {
        background: #35562f;
    }

    .tb-new-password-match {
        display: none;

        margin-top: 7px;

        font-size: 12px;
        font-weight: 800;
    }

    .tb-new-password-match.show {
        display: block;
    }

    .tb-new-password-match.ok {
        color: #35562f;
    }

    .tb-new-password-match.error {
        color: #b43e2e;
    }

    /* =========================================================
       NOTE
    ========================================================= */

    .tb-new-password-note {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 20px;

        padding: 13px 14px;

        border:
            1px solid
            #dce7d7;

        border-radius: 13px;

        color: #506649;

        background: #f5faf2;

        font-size: 13px;

        line-height: 1.55;
    }

    /* =========================================================
       SUBMIT
    ========================================================= */

    .tb-new-password-submit {
        position: relative;
        overflow: hidden;

        width: 100%;
        min-height: 56px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        border: 0;
        border-radius: 16px;

        color: #fff;

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

        font-size: 15px;
        font-weight: 900;

        cursor: pointer;

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }

    .tb-new-password-submit::before {
        content: "";

        position: absolute;

        top: 0;
        left: -120%;

        width: 60%;
        height: 100%;

        transform:
            skewX(-20deg);

        background:
            linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.22),
                transparent
            );

        transition: left .45s ease;
    }

    .tb-new-password-submit:hover {
        transform: translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }

    .tb-new-password-submit:hover::before {
        left: 145%;
    }

    .tb-new-password-submit:disabled {
        opacity: .78;

        cursor: wait;

        transform: none;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-new-password-page {
            padding: 30px 0 60px;
        }

        .tb-new-password-shell {
            max-width: 680px;

            grid-template-columns: 1fr;
        }

        .tb-new-password-brand {
            min-height: auto;

            padding: 38px 34px;
        }

        .tb-new-password-brand h1 {
            max-width: 540px;

            font-size: 40px;
        }

        .tb-new-password-steps {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );

            margin-top: 28px;
        }

        .tb-new-password-step {
            align-items: flex-start;

            flex-direction: column;

            font-size: 13px;
        }

        .tb-new-password-panel {
            padding: 44px 38px;
        }
    }

    @media (max-width: 575.98px) {

        .tb-new-password-page {
            padding: 18px 0 42px;
        }

        .tb-new-password-shell {
            border-radius: 22px;
        }

        .tb-new-password-brand {
            padding: 29px 23px;
        }

        .tb-new-password-logo {
            width: 50px;
            height: 50px;

            margin-bottom: 18px;

            border-radius: 15px;
        }

        .tb-new-password-brand h1 {
            font-size: 34px;
        }

        .tb-new-password-copy {
            font-size: 14px;
        }

        .tb-new-password-steps {
            grid-template-columns: 1fr;

            gap: 8px;

            margin-top: 24px;
        }

        .tb-new-password-step {
            flex-direction: row;

            align-items: center;
        }

        .tb-new-password-panel {
            padding: 32px 22px;
        }

        .tb-new-password-panel::after {
            display: none;
        }

        .tb-new-password-icon {
            width: 72px;
            height: 72px;

            border-radius: 21px;

            font-size: 32px;
        }

        .tb-new-password-head h2 {
            font-size: 29px;
        }

        .tb-new-password-input {
            min-height: 52px;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .tb-new-password-page *,
        .tb-new-password-page *::before,
        .tb-new-password-page *::after {
            transition: none !important;
        }
    }
</style>


<div class="tb-new-password-page">

    <div class="tb-new-password-shell">


        {{-- =====================================================
            LEFT
        ====================================================== --}}
        <aside class="tb-new-password-brand">

            <div class="tb-new-password-brand-top">

                <div class="tb-new-password-logo">
                    •
                </div>


                <div class="tb-new-password-kicker">
                    Bước 3 / 3
                </div>


                <h1>
                    Tạo mật khẩu mới
                    cho tài khoản.
                </h1>


                <p class="tb-new-password-copy">

                    Bạn đã xác nhận OTP thành công.
                    Chỉ còn một bước cuối:
                    thiết lập mật khẩu mới
                    và xác nhận lại chính xác.

                </p>

            </div>


            <div class="tb-new-password-steps">

                <div class="tb-new-password-step done">

                    <span class="tb-new-password-step-number">
                        •
                    </span>

                    <span>
                        Đã nhập email
                    </span>

                </div>


                <div class="tb-new-password-step done">

                    <span class="tb-new-password-step-number">
                        •
                    </span>

                    <span>
                        Đã xác nhận OTP
                    </span>

                </div>


                <div class="tb-new-password-step active">

                    <span class="tb-new-password-step-number">
                        3
                    </span>

                    <span>
                        Tạo mật khẩu mới
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            RIGHT
        ====================================================== --}}
        <section class="tb-new-password-panel">


            <div class="tb-new-password-icon">
                •
            </div>


            <div class="tb-new-password-head">

                <h2>
                    Đặt mật khẩu mới
                </h2>


                <p>
                    Nhập mật khẩu mới
                    cho tài khoản Tinh Hoa Tây Bắc
                    và xác nhận lại một lần nữa.
                </p>

            </div>


            @if(session('success'))

                <div class="tb-new-password-alert success">

                    <span>
                        •
                    </span>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if(session('error'))

                <div class="tb-new-password-alert error">

                    <span>
                        •
                    </span>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('password.reset') }}"
                id="newPasswordForm"
            >

                @csrf


                {{-- PASSWORD --}}
                <div class="tb-new-password-field">

                    <label
                        for="password"
                        class="tb-new-password-label"
                    >
                        Mật khẩu mới
                    </label>


                    <div class="tb-new-password-input-wrap">

                        <span class="tb-new-password-input-icon">
                            •
                        </span>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="
                                tb-new-password-input
                                @error('password')
                                    is-invalid
                                @enderror
                            "
                            placeholder="Nhập mật khẩu mới"
                            autocomplete="new-password"
                            required
                            autofocus
                        >


                        <button
                            type="button"
                            class="tb-new-password-toggle"
                            data-toggle-password="password"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    <div class="tb-new-password-help">
                        Nên sử dụng ít nhất 8 ký tự,
                        kết hợp chữ hoa, chữ thường,
                        số và ký tự đặc biệt.
                    </div>


                    <div
                        class="tb-new-password-strength"
                        id="newPasswordStrength"
                    >
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>


                    @error('password')

                        <div class="tb-new-password-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- CONFIRM --}}
                <div class="tb-new-password-field">

                    <label
                        for="password_confirmation"
                        class="tb-new-password-label"
                    >
                        Xác nhận mật khẩu
                    </label>


                    <div class="tb-new-password-input-wrap">

                        <span class="tb-new-password-input-icon">
                            •
                        </span>


                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="tb-new-password-input"
                            placeholder="Nhập lại mật khẩu mới"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="tb-new-password-toggle"
                            data-toggle-password="password_confirmation"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    <div
                        class="tb-new-password-match"
                        id="newPasswordMatch"
                    >
                    </div>

                </div>


                <div class="tb-new-password-note">

                    <span>
                        •
                    </span>

                    <span>
                        Hai ô mật khẩu phải giống nhau
                        trước khi hoàn tất thay đổi.
                        Sau khi cập nhật thành công,
                        hãy sử dụng mật khẩu mới
                        cho những lần đăng nhập tiếp theo.
                    </span>

                </div>


                <button
                    type="submit"
                    class="tb-new-password-submit"
                    id="newPasswordSubmit"
                >
                    <span>
                        •
                    </span>

                    <span>
                        Cập nhật mật khẩu
                    </span>
                </button>

            </form>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const password =
            document.getElementById(
                'password'
            );


        const confirmation =
            document.getElementById(
                'password_confirmation'
            );


        const strength =
            document.getElementById(
                'newPasswordStrength'
            );


        const match =
            document.getElementById(
                'newPasswordMatch'
            );


        const form =
            document.getElementById(
                'newPasswordForm'
            );


        const submitButton =
            document.getElementById(
                'newPasswordSubmit'
            );


        /* =============================================
           SHOW / HIDE PASSWORD
        ============================================= */

        document
            .querySelectorAll(
                '[data-toggle-password]'
            )
            .forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const input =
                                document.getElementById(
                                    button.dataset
                                        .togglePassword
                                );


                            if (!input) {
                                return;
                            }


                            const isHidden =
                                input.type
                                ===
                                'password';


                            input.type =
                                isHidden
                                ? 'text'
                                : 'password';


                            button.textContent =
                                isHidden
                                ? '🙈'
                                : '👁';


                            button.setAttribute(
                                'aria-label',
                                isHidden
                                ? 'Ẩn mật khẩu'
                                : 'Hiện mật khẩu'
                            );


                            button.setAttribute(
                                'title',
                                isHidden
                                ? 'Ẩn mật khẩu'
                                : 'Hiện mật khẩu'
                            );

                        }
                    );

                }
            );


        /* =============================================
           STRENGTH
        ============================================= */

        function updateStrength() {

            if (
                !password
                ||
                !strength
            ) {
                return;
            }


            const value =
                password.value;


            let score = 0;


            if (value.length >= 8) {
                score++;
            }


            if (
                /[A-Z]/.test(value)
                &&
                /[a-z]/.test(value)
            ) {
                score++;
            }


            if (/\d/.test(value)) {
                score++;
            }


            if (
                /[^A-Za-z0-9]/.test(value)
            ) {
                score++;
            }


            strength.className =
                'tb-new-password-strength';


            if (score > 0) {

                strength.classList.add(
                    'level-' + score
                );

            }

        }


        /* =============================================
           CONFIRM MATCH
        ============================================= */

        function updateMatch() {

            if (
                !password
                ||
                !confirmation
                ||
                !match
            ) {
                return true;
            }


            if (
                confirmation.value === ''
            ) {

                match.className =
                    'tb-new-password-match';


                match.textContent =
                    '';


                return false;

            }


            if (
                password.value
                ===
                confirmation.value
            ) {

                match.className =
                    'tb-new-password-match show ok';


                match.textContent =
                    '• Hai mật khẩu trùng khớp.';


                return true;

            }


            match.className =
                'tb-new-password-match show error';


            match.textContent =
                '• Hai mật khẩu chưa trùng nhau.';


            return false;

        }


        if (password) {

            password.addEventListener(
                'input',
                function () {

                    updateStrength();
                    updateMatch();

                }
            );

        }


        if (confirmation) {

            confirmation.addEventListener(
                'input',
                updateMatch
            );

        }


        /* =============================================
           SUBMIT
        ============================================= */

        if (
            form
            &&
            submitButton
        ) {

            form.addEventListener(
                'submit',
                function (event) {

                    if (
                        password
                        &&
                        confirmation
                        &&
                        password.value
                        !==
                        confirmation.value
                    ) {

                        event.preventDefault();

                        confirmation.focus();

                        updateMatch();

                        return;

                    }


                    submitButton.disabled =
                        true;


                    submitButton.innerHTML =
                        '<span>•</span>'
                        +
                        '<span>Đang cập nhật...</span>';

                }
            );

        }

    }
);
</script>

@endsection