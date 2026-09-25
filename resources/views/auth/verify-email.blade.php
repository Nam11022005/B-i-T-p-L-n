@extends('layouts.app')

@section('title', 'Xác thực email | Tinh Hoa Tây Bắc')

@section('content')


<style>
    :root {
        --auth-brown: #5f341d;
        --auth-brown-dark: #2c1810;
        --auth-red: #a83b2d;
        --auth-gold: #f2c15c;
        --auth-green: #48633b;
        --auth-cream: #fffaf0;
        --auth-border: #ead8bf;
        --auth-muted: #7b6a5e;
    }

    .auth-premium-page {
        position: relative;
        isolation: isolate;
        min-height: calc(100vh - 170px);
        display: grid;
        place-items: center;
        padding: 54px 12px 84px;
    }

    .auth-premium-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        inset: -40px 0 0;
        background:
            radial-gradient(circle at 8% 12%, rgba(242,193,92,.20), transparent 24%),
            radial-gradient(circle at 92% 10%, rgba(72,99,59,.15), transparent 28%),
            radial-gradient(circle at 52% 28%, rgba(168,59,45,.055), transparent 30%),
            linear-gradient(180deg,#fffaf0 0%,#fff 74%);
    }

    .auth-premium-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        right: 3%;
        top: 90px;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        opacity: .10;
        pointer-events: none;
        background:
            repeating-radial-gradient(circle at center, rgba(95,52,29,.35) 0 1px, transparent 1px 13px);
    }

    .auth-shell {
        width: min(100%, 1040px);
        display: grid;
        grid-template-columns: minmax(0, .92fr) minmax(0, 1.08fr);
        overflow: hidden;
        border: 1px solid rgba(218,190,152,.78);
        border-radius: 30px;
        background: #fff;
        box-shadow:
            0 30px 80px rgba(72,43,27,.14),
            0 4px 14px rgba(72,43,27,.05);
    }

    .auth-brand-panel {
        position: relative;
        overflow: hidden;
        min-height: 590px;
        padding: 46px 42px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: #fff;
        background:
            radial-gradient(circle at 82% 14%, rgba(242,193,92,.25), transparent 28%),
            radial-gradient(circle at 16% 110%, rgba(168,59,45,.30), transparent 34%),
            linear-gradient(145deg,#2c1810 0%,#5f341d 52%,#48633b 100%);
    }

    .auth-brand-panel::before {
        content: "";
        position: absolute;
        right: -40px;
        bottom: -60px;
        width: 350px;
        height: 220px;
        opacity: .11;
        clip-path: polygon(0 100%,17% 58%,34% 73%,53% 25%,69% 58%,85% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
    }

    .auth-brand-panel::after {
        content: "🌿";
        position: absolute;
        right: 34px;
        top: 20px;
        font-size: 105px;
        opacity: .055;
        transform: rotate(-14deg);
    }

    .auth-brand-content,
    .auth-brand-benefits {
        position: relative;
        z-index: 2;
    }

    .auth-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        margin-bottom: 16px;
        border: 1px solid rgba(242,193,92,.32);
        border-radius: 999px;
        color: #f7dc96;
        background: rgba(255,255,255,.055);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .auth-brand-panel h1 {
        max-width: 440px;
        color: #fff;
        font-size: clamp(34px,4vw,52px);
        line-height: 1.08;
        letter-spacing: -.9px;
        text-shadow: 0 2px 16px rgba(0,0,0,.18);
    }

    .auth-brand-panel p {
        max-width: 470px;
        color: rgba(255,255,255,.76);
        line-height: 1.72;
    }

    .auth-brand-benefits {
        display: grid;
        gap: 11px;
    }

    .auth-benefit {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255,255,255,.82);
        font-size: 14px;
        font-weight: 650;
    }

    .auth-benefit span {
        width: 31px;
        height: 31px;
        flex: 0 0 31px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: rgba(255,255,255,.09);
        border: 1px solid rgba(255,255,255,.10);
    }

    .auth-form-panel {
        padding: 46px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.09), transparent 25%),
            #fff;
    }

    .auth-form-head {
        margin-bottom: 27px;
    }

    .auth-form-head h2 {
        color: #31231c;
        font-size: 32px;
        font-weight: 900;
        letter-spacing: -.6px;
    }

    .auth-form-head p {
        color: var(--auth-muted);
        line-height: 1.65;
    }

    .auth-label {
        margin-bottom: 7px;
        color: #503729;
        font-size: 13px;
        font-weight: 850;
    }

    .auth-input-wrap {
        position: relative;
    }

    .auth-input-icon {
        position: absolute;
        z-index: 2;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        opacity: .62;
        pointer-events: none;
    }

    .auth-input {
        min-height: 50px;
        padding-left: 45px;
        border: 1px solid #dfcbae;
        border-radius: 14px;
        background: #fffdf9;
        color: #35271f;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .auth-input:focus {
        border-color: #d5aa69;
        background: #fff;
        box-shadow: 0 0 0 .22rem rgba(217,119,6,.09);
    }

    .auth-input.is-invalid {
        border-color: #c75a4c;
    }

    .auth-submit {
        position: relative;
        overflow: hidden;
        min-height: 52px;
        width: 100%;
        border: 0;
        border-radius: 14px;
        color: #fff;
        background: linear-gradient(135deg,#a83b2d,#5f341d 58%,#48633b);
        font-weight: 900;
        letter-spacing: .1px;
        box-shadow: 0 11px 24px rgba(95,52,29,.18);
        transition: transform .17s ease, box-shadow .17s ease;
    }

    .auth-submit::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 62%;
        height: 100%;
        transform: skewX(-20deg);
        background: linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);
        transition: left .45s ease;
    }

    .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(95,52,29,.23);
    }

    .auth-submit:hover::after {
        left: 145%;
    }

    .auth-link {
        color: var(--auth-red);
        font-weight: 800;
        text-decoration: none;
    }

    .auth-link:hover {
        color: var(--auth-brown);
        text-decoration: underline;
    }

    .auth-separator {
        display: flex;
        align-items: center;
        gap: 13px;
        margin: 23px 0;
        color: #9b8a7f;
        font-size: 12px;
        font-weight: 700;
    }

    .auth-separator::before,
    .auth-separator::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #ead8bf;
    }

    .auth-alt-box {
        padding: 14px 16px;
        border: 1px solid #ead8bf;
        border-radius: 13px;
        background: #fffaf1;
        color: #6f5a4d;
        text-align: center;
        font-size: 14px;
    }

    .auth-note {
        display: flex;
        gap: 9px;
        padding: 13px 15px;
        border: 1px solid #ead2a4;
        border-radius: 13px;
        background: linear-gradient(135deg,#fff9e8,#fff2d2);
        color: #6d5332;
        font-size: 13px;
        line-height: 1.55;
    }

    @media (max-width: 900px) {
        .auth-shell {
            grid-template-columns: 1fr;
            max-width: 640px;
        }

        .auth-brand-panel {
            min-height: 300px;
            padding: 34px 30px;
        }

        .auth-brand-benefits {
            grid-template-columns: 1fr 1fr;
        }

        .auth-form-panel {
            padding: 38px 34px;
        }
    }

    @media (max-width: 575.98px) {
        .auth-premium-page {
            padding: 28px 0 60px;
        }

        .auth-premium-page::after {
            display: none;
        }

        .auth-shell {
            border-radius: 22px;
        }

        .auth-brand-panel {
            min-height: 275px;
            padding: 28px 22px;
        }

        .auth-brand-panel h1 {
            font-size: 34px;
        }

        .auth-brand-benefits {
            grid-template-columns: 1fr;
        }

        .auth-form-panel {
            padding: 30px 22px;
        }

        .auth-form-head h2 {
            font-size: 28px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .auth-premium-page *,
        .auth-premium-page *::before,
        .auth-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }
</style>


<style>
    .otp-card {
        text-align: center;
    }

    .otp-mail-icon {
        width: 86px;
        height: 86px;
        display: grid;
        place-items: center;
        margin: 0 auto 20px;
        border: 1px solid #ead0a3;
        border-radius: 26px;
        background:
            radial-gradient(circle at 35% 25%,rgba(255,255,255,.9),transparent 30%),
            linear-gradient(135deg,#fff1cd,#f7dfae);
        font-size: 40px;
        box-shadow: 0 12px 26px rgba(95,52,29,.09);
    }

    .otp-email-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
        padding: 7px 12px;
        border: 1px solid #e6d0ad;
        border-radius: 999px;
        background: #fff8ea;
        color: #5f341d;
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .otp-input {
        height: 66px;
        padding: 0 18px !important;
        text-align: center;
        letter-spacing: .48em;
        text-indent: .48em;
        font-size: 28px;
        font-weight: 900;
        font-variant-numeric: tabular-nums;
        border-radius: 16px;
    }

    .otp-resend-btn {
        min-height: 45px;
        border: 1px solid #d9c19f;
        border-radius: 12px;
        background: #fff;
        color: #5f341d;
        font-weight: 850;
    }

    .otp-resend-btn:hover {
        background: #fff7e8;
        border-color: #cda873;
        color: #5f341d;
    }
</style>

<div class="auth-premium-page">
    <div class="auth-shell">
        <aside class="auth-brand-panel">
            <div class="auth-brand-content">
                <div class="auth-kicker">🔐 BẢO MẬT TÀI KHOẢN</div>
                <h1>Xác thực email để bảo vệ tài khoản của bạn.</h1>
                <p class="mt-3 mb-0">
                    Mã OTP gồm 6 chữ số đã được gửi tới email đăng ký.
                    Mã có thời hạn theo cấu hình xác thực hiện tại của hệ thống.
                </p>
            </div>

            <div class="auth-brand-benefits">
                <div class="auth-benefit"><span>✉️</span> Mã xác thực gửi qua email</div>
                <div class="auth-benefit"><span>🛡️</span> Bảo vệ thông tin tài khoản</div>
                <div class="auth-benefit"><span>✅</span> Xác thực trước khi sử dụng đầy đủ</div>
            </div>
        </aside>

        <section class="auth-form-panel otp-card">
            <div class="otp-mail-icon">✉️</div>

            <div class="auth-form-head mb-3">
                <h2 class="mb-2">Nhập mã xác thực</h2>
                <p class="mb-3">Chúng tôi đã gửi mã OTP đến:</p>

                <div class="otp-email-pill">
                    ✉️ {{ $user->email }}
                </div>
            </div>


            <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                <span class="badge rounded-pill text-bg-light border px-3 py-2">🔐 OTP 6 số</span>
                <span class="badge rounded-pill text-bg-light border px-3 py-2">✉️ Xác thực email</span>
            </div>
            <form method="POST" action="{{ route('verification.verify.code') }}">
                @csrf

                <div class="mb-3 text-start">
                    <label for="verification_code" class="auth-label">Mã OTP 6 số</label>
                    <input
                        id="verification_code"
                        type="text"
                        name="verification_code"
                        value="{{ old('verification_code') }}"
                        class="form-control auth-input otp-input @error('verification_code') is-invalid @enderror"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="••••••"
                        required
                        autofocus
                    >
                    @error('verification_code')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-submit mt-2">
                    ✅ Xác thực email
                </button>
            </form>

            <div class="auth-separator">CHƯA NHẬN ĐƯỢC MÃ?</div>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="otp-resend-btn w-100">
                    🔄 Gửi lại mã xác thực
                </button>
            </form>

            <div class="auth-note mt-3 text-start">
                <span>💡</span>
                <span>
                    Kiểm tra cả thư mục Spam/Junk nếu chưa thấy email. Khi yêu cầu mã mới,
                    hãy sử dụng mã mới nhất được gửi tới hộp thư.
                </span>
            </div>
        </section>
    </div>
</div>


<style>
    /* =========================================================
       AUTH LUXURY UPGRADE
       Chỉ nâng UI - không đổi route / form / field / logic.
    ========================================================= */

    .auth-premium-page {
        overflow: hidden;
        padding-top: 64px !important;
        padding-bottom: 96px !important;
    }

    /* Nền tổng thể có chiều sâu hơn */
    .auth-premium-page::before {
        background:
            radial-gradient(circle at 8% 12%, rgba(242,193,92,.24), transparent 25%),
            radial-gradient(circle at 92% 10%, rgba(72,99,59,.18), transparent 29%),
            radial-gradient(circle at 50% 32%, rgba(168,59,45,.06), transparent 31%),
            linear-gradient(180deg,#fff8e9 0%,#fffdf8 45%,#ffffff 100%) !important;
    }

    .auth-premium-page::after {
        width: 300px !important;
        height: 300px !important;
        top: 65px !important;
        right: -70px !important;
        opacity: .085 !important;
    }

    .auth-shell {
        position: relative;
        width: min(100%, 1120px) !important;
        border-radius: 34px !important;
        border: 1px solid rgba(221,193,154,.82) !important;
        box-shadow:
            0 38px 95px rgba(75,42,24,.16),
            0 8px 24px rgba(75,42,24,.06) !important;
        isolation: isolate;
    }

    /* viền ánh vàng mảnh ở mép trên */
    .auth-shell::before {
        content: "";
        position: absolute;
        z-index: 4;
        top: 0;
        left: 9%;
        right: 9%;
        height: 3px;
        border-radius: 999px;
        background:
            linear-gradient(90deg,transparent,#f2c15c 24%,#d97706 48%,#48633b 76%,transparent);
        opacity: .82;
        pointer-events: none;
    }

    /* PANEL TRÁI */
    .auth-brand-panel {
        min-height: 640px !important;
        padding: 54px 48px !important;
        background:
            radial-gradient(circle at 82% 14%, rgba(242,193,92,.28), transparent 29%),
            radial-gradient(circle at 12% 112%, rgba(168,59,45,.33), transparent 35%),
            linear-gradient(148deg,#25130c 0%,#552e1c 46%,#48633b 100%) !important;
    }

    .auth-brand-panel::before {
        width: 410px !important;
        height: 255px !important;
        right: -50px !important;
        bottom: -65px !important;
        opacity: .14 !important;
        filter: drop-shadow(0 12px 24px rgba(0,0,0,.12));
    }

    .auth-brand-panel::after {
        content: "✦";
        right: 44px !important;
        top: 28px !important;
        font-size: 86px !important;
        opacity: .055 !important;
        color: #f7d579;
        transform: rotate(18deg) !important;
    }

    .auth-brand-content::before {
        content: "TH";
        display: grid;
        place-items: center;
        width: 56px;
        height: 56px;
        margin-bottom: 24px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,.15);
        background:
            linear-gradient(135deg,rgba(255,255,255,.14),rgba(255,255,255,.05));
        color: #f5d47e;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: .05em;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.12),
            0 10px 24px rgba(0,0,0,.14);
        backdrop-filter: blur(10px);
    }

    .auth-kicker {
        margin-bottom: 18px !important;
        padding: 7px 12px !important;
        background: rgba(255,255,255,.07) !important;
        border-color: rgba(242,193,92,.34) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
    }

    .auth-brand-panel h1 {
        max-width: 470px !important;
        font-size: clamp(38px,4.4vw,58px) !important;
        line-height: 1.02 !important;
        letter-spacing: -1.25px !important;
    }

    .auth-brand-panel p {
        max-width: 490px !important;
        font-size: 15px;
        line-height: 1.78 !important;
    }

    .auth-brand-benefits {
        grid-template-columns: 1fr !important;
        gap: 12px !important;
        margin-top: 34px;
    }

    .auth-benefit {
        padding: 11px 13px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 14px;
        background: rgba(255,255,255,.045);
        backdrop-filter: blur(8px);
        transition:
            transform .18s ease,
            background .18s ease,
            border-color .18s ease;
    }

    .auth-benefit:hover {
        transform: translateX(4px);
        background: rgba(255,255,255,.08);
        border-color: rgba(242,193,92,.18);
    }

    .auth-benefit span {
        width: 35px !important;
        height: 35px !important;
        flex-basis: 35px !important;
        border-radius: 11px !important;
        background:
            linear-gradient(135deg,rgba(242,193,92,.16),rgba(255,255,255,.06)) !important;
    }

    /* FORM PANEL */
    .auth-form-panel {
        position: relative;
        padding: 58px 62px !important;
        background:
            radial-gradient(circle at 100% 0%,rgba(242,193,92,.11),transparent 26%),
            radial-gradient(circle at 0% 100%,rgba(72,99,59,.045),transparent 26%),
            #fff !important;
    }

    .auth-form-panel::before {
        content: "";
        position: absolute;
        top: 24px;
        right: 26px;
        width: 92px;
        height: 92px;
        border: 1px solid rgba(95,52,29,.055);
        border-left: 0;
        border-bottom: 0;
        border-radius: 0 24px 0 0;
        pointer-events: none;
    }

    .auth-form-head {
        margin-bottom: 31px !important;
    }

    .auth-form-head::before {
        content: "✦";
        display: inline-grid;
        place-items: center;
        width: 38px;
        height: 38px;
        margin-bottom: 14px;
        border: 1px solid #e8d2af;
        border-radius: 12px;
        background:
            linear-gradient(135deg,#fff8e8,#f7e4bd);
        color: #8a4c2c;
        font-size: 17px;
        box-shadow: 0 6px 14px rgba(95,52,29,.06);
    }

    .auth-form-head h2 {
        font-size: 35px !important;
        color: #2e2019 !important;
    }

    .auth-form-head p {
        font-size: 14.5px;
    }

    .auth-label {
        font-size: 12.5px !important;
        letter-spacing: .015em;
    }

    .auth-input {
        min-height: 54px !important;
        padding-left: 48px !important;
        border-radius: 15px !important;
        border-color: #e1cdb0 !important;
        background:
            linear-gradient(180deg,#fffefb,#fffaf3) !important;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.95),
            0 4px 12px rgba(95,52,29,.025) !important;
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease,
            transform .18s ease;
    }

    .auth-input:hover {
        border-color: #d9bb91 !important;
    }

    .auth-input:focus {
        border-color: #d3a25f !important;
        background: #fff !important;
        box-shadow:
            0 0 0 .22rem rgba(217,119,6,.10),
            0 8px 18px rgba(95,52,29,.05) !important;
        transform: translateY(-1px);
    }

    .auth-input-icon {
        left: 17px !important;
        opacity: .72 !important;
        filter: grayscale(.08);
    }

    .auth-submit {
        min-height: 56px !important;
        border-radius: 16px !important;
        background:
            linear-gradient(135deg,#a83b2d 0%,#6a3923 48%,#48633b 100%) !important;
        box-shadow:
            0 13px 28px rgba(95,52,29,.21) !important;
    }

    .auth-submit:hover {
        transform: translateY(-3px) !important;
        box-shadow:
            0 18px 34px rgba(95,52,29,.25) !important;
    }

    .auth-alt-box {
        border-radius: 14px !important;
        background:
            linear-gradient(135deg,#fffaf1,#fff5e5) !important;
        border-color: #e7d0ad !important;
    }

    .auth-note {
        border-radius: 14px !important;
        background:
            linear-gradient(135deg,#fff8df,#fff1ca) !important;
        border-color: #ebcf94 !important;
    }

    .auth-separator {
        margin: 26px 0 !important;
    }

    /* OTP riêng */
    .otp-mail-icon {
        width: 96px !important;
        height: 96px !important;
        border-radius: 30px !important;
        font-size: 45px !important;
        background:
            radial-gradient(circle at 30% 24%,rgba(255,255,255,.94),transparent 32%),
            linear-gradient(135deg,#fff1c9,#f3d999) !important;
        box-shadow:
            0 16px 34px rgba(95,52,29,.11),
            inset 0 1px 0 rgba(255,255,255,.95) !important;
    }

    .otp-email-pill {
        padding: 8px 14px !important;
        border-color: #e3c898 !important;
        background:
            linear-gradient(180deg,#fffaf0,#fff3dd) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .otp-input {
        height: 72px !important;
        border-radius: 18px !important;
        background:
            linear-gradient(180deg,#fffefb,#fff8ed) !important;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.95),
            0 8px 20px rgba(95,52,29,.05) !important;
    }

    .otp-resend-btn {
        min-height: 49px !important;
        border-radius: 14px !important;
        background:
            linear-gradient(180deg,#fff,#fffaf2) !important;
        transition:
            transform .16s ease,
            box-shadow .16s ease,
            background .16s ease;
    }

    .otp-resend-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(95,52,29,.07);
    }

    /* responsive */
    @media (max-width: 900px) {
        .auth-shell {
            max-width: 680px !important;
        }

        .auth-brand-panel {
            min-height: 360px !important;
            padding: 38px 34px !important;
        }

        .auth-form-panel {
            padding: 42px 36px !important;
        }

        .auth-brand-content::before {
            width: 50px;
            height: 50px;
            margin-bottom: 18px;
        }
    }

    @media (max-width: 575.98px) {
        .auth-premium-page {
            padding-top: 32px !important;
            padding-bottom: 64px !important;
        }

        .auth-shell {
            border-radius: 24px !important;
        }

        .auth-brand-panel {
            min-height: 325px !important;
            padding: 30px 24px !important;
        }

        .auth-brand-panel h1 {
            font-size: 36px !important;
        }

        .auth-form-panel {
            padding: 32px 22px !important;
        }

        .auth-form-head h2 {
            font-size: 30px !important;
        }

        .auth-input {
            min-height: 52px !important;
        }
    }
</style>


@endsection
