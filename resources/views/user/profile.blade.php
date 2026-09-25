@extends('layouts.app')

@section('title', 'Hồ sơ người dùng')

@section('content')
<style>
    .profile-page {
        max-width: 1180px;
        margin: 0 auto;
    }

    .profile-card {
        border: 1px solid var(--tb-border, #ead8bf);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(95, 52, 29, .08);
        overflow: hidden;
    }

    .profile-title {
        color: var(--tb-brown-dark, #2c1810);
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--tb-green, #48633b);
        background: #edf7ed;
    }

    .profile-avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid var(--tb-green, #48633b);
        background: #edf7ed;
        color: var(--tb-green, #48633b);
        font-size: 3rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .profile-section-title {
        font-weight: 800;
        color: var(--tb-brown, #5f341d);
        margin-bottom: 18px;
    }

    .profile-label {
        font-weight: 700;
        color: #59483d;
        margin-bottom: 7px;
    }

    .profile-input {
        border: 1px solid var(--tb-border, #ead8bf);
        border-radius: 12px;
        min-height: 46px;
    }

    .profile-input:focus {
        border-color: var(--tb-orange, #d97706);
        box-shadow: 0 0 0 .2rem rgba(217, 119, 6, .12);
    }

    .profile-btn {
        border: 0;
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .profile-btn-primary {
        background: linear-gradient(90deg, #5f341d, #48633b);
        color: #fff;
    }

    .profile-btn-primary:hover {
        color: #fff;
        opacity: .92;
    }

    .profile-info-box {
        background: var(--tb-cream, #fffaf0);
        border: 1px solid var(--tb-border, #ead8bf);
        border-radius: 14px;
        padding: 14px 16px;
    }


    /* =========================================================
       PROFILE PREMIUM UI
       CHỈ NÂNG GIAO DIỆN - KHÔNG ĐỔI ROUTE / FORM / LOGIC
    ========================================================= */

    .profile-page {
        position: relative;
        isolation: isolate;
        padding: 34px 10px 76px;
    }

    .profile-page::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -30px;
        left: 50%;
        width: min(100vw, 1650px);
        height: 700px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.18), transparent 24%),
            radial-gradient(circle at 94% 12%, rgba(72,99,59,.13), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.98),rgba(255,255,255,0));
    }

    .profile-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        top: 150px;
        right: -45px;
        width: 210px;
        height: 210px;
        opacity: .10;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.34) 0 1px,
                transparent 1px 13px
            );
    }

    .profile-hero {
        position: relative;
        overflow: hidden;
        min-height: 170px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 32px 35px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 14%, rgba(242,193,92,.22), transparent 29%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.28), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 53%,#48633b 100%);
        box-shadow:
            0 23px 58px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
    }

    .profile-hero::before {
        content: "";
        position: absolute;
        right: -28px;
        bottom: -56px;
        width: 315px;
        height: 180px;
        opacity: .10;
        clip-path: polygon(0 100%,18% 56%,36% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .profile-hero-copy,
    .profile-role-pill {
        position: relative;
        z-index: 2;
    }

    .profile-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        margin-bottom: 9px;
        border: 1px solid rgba(242,193,92,.30);
        border-radius: 999px;
        color: #f6d98c;
        background: rgba(255,255,255,.055);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .profile-hero .profile-title {
        color: #fff;
        font-size: clamp(30px,3vw,42px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .profile-hero p {
        color: rgba(255,255,255,.76);
        line-height: 1.65;
    }

    .profile-role-pill {
        display: inline-flex;
        align-items: center;
        padding: 9px 15px;
        border: 1px solid rgba(255,255,255,.20);
        border-radius: 999px;
        color: #fff;
        background: rgba(255,255,255,.08);
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
        backdrop-filter: blur(10px);
    }

    .profile-page .profile-card {
        position: relative;
        border-radius: 24px;
        border-color: #e5d0b3;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 18px 46px rgba(95,52,29,.085),
            inset 0 1px 0 rgba(255,255,255,.94);
        transition:
            transform .20s ease,
            box-shadow .20s ease,
            border-color .20s ease;
    }

    .profile-page .profile-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 9%;
        right: 9%;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,transparent,#f2c15c,#d97706,#48633b,transparent);
        opacity: .55;
    }

    .profile-page .profile-card:hover {
        border-color: #dec092;
        box-shadow: 0 22px 52px rgba(95,52,29,.11);
    }

    .profile-page .profile-section-title {
        position: relative;
        padding-bottom: 13px;
        color: #3a281f;
        letter-spacing: -.2px;
    }

    .profile-page .profile-section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 70px;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,#d97706,#48633b);
    }

    .profile-page .profile-avatar,
    .profile-page .profile-avatar-placeholder {
        width: 164px;
        height: 164px;
        border: 6px solid #fff;
        outline: 3px solid rgba(72,99,59,.82);
        box-shadow:
            0 16px 34px rgba(95,52,29,.14),
            0 0 0 7px rgba(242,193,92,.10);
    }

    .profile-page .profile-avatar {
        margin: 0 auto;
        display: block;
    }

    .profile-page .profile-avatar-placeholder {
        background:
            radial-gradient(circle at 35% 25%,rgba(255,255,255,.8),transparent 30%),
            linear-gradient(135deg,#edf7ed,#dcebd7);
        color: #48633b;
    }

    .profile-page .profile-label {
        color: #5a4030;
        font-size: 13px;
        letter-spacing: .01em;
    }

    .profile-page .profile-input {
        min-height: 48px;
        border-radius: 13px;
        border-color: #dfcbae;
        background: #fffdf9;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.92);
    }

    .profile-page .profile-input:focus {
        background: #fff;
        border-color: #d2a35e;
        box-shadow: 0 0 0 .2rem rgba(217,119,6,.09);
    }

    .profile-page input[type="file"].profile-input {
        padding-top: 10px;
    }

    .profile-page .profile-info-box {
        min-height: 48px;
        display: flex;
        align-items: center;
        border-radius: 13px;
        border-color: #e5d1b5;
        background:
            linear-gradient(135deg,#fffaf0,#fff5e5);
    }

    .profile-page .profile-btn {
        min-height: 45px;
        border-radius: 12px;
        font-weight: 800;
        transition:
            transform .17s ease,
            box-shadow .17s ease,
            filter .17s ease;
    }

    .profile-page .profile-btn:hover {
        transform: translateY(-1px);
    }

    .profile-page .profile-btn-primary {
        background: linear-gradient(135deg,#5f341d,#48633b);
        box-shadow: 0 8px 18px rgba(72,99,59,.15);
    }

    .profile-page .profile-btn-primary:hover {
        opacity: 1;
        box-shadow: 0 11px 23px rgba(72,99,59,.21);
    }

    .profile-page .alert {
        border-radius: 15px;
        box-shadow: 0 8px 22px rgba(95,52,29,.06);
    }

    @media (max-width: 991.98px) {
        .profile-page {
            padding-top: 23px;
        }

        .profile-page::after {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .profile-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .profile-page .profile-card {
            border-radius: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .profile-page *,
        .profile-page *::before,
        .profile-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="profile-page">
    <section class="profile-hero mb-4">
        <div class="profile-hero-copy">
            <div class="profile-kicker">🌿 TINH HOA TÂY BẮC</div>

            <h2 class="fw-bold profile-title mb-2">
                👤 Hồ sơ cá nhân
            </h2>

            <p class="mb-0">
                Quản lý thông tin, ảnh đại diện và bảo mật tài khoản của bạn.
            </p>
        </div>

        <span class="profile-role-pill">
            ● {{ ucfirst($user->role) }}
        </span>
    </section>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show auto-dismiss-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-1">Vui lòng kiểm tra lại:</div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- ẢNH ĐẠI DIỆN --}}
        <div class="col-lg-4">
            <div class="profile-card h-100">
                <div class="card-body p-4 text-center">
                    <h5 class="profile-section-title">
                        🖼️ Ảnh đại diện
                    </h5>

                    @if($user->avatar)
                        <img
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="Ảnh đại diện {{ $user->name }}"
                            class="profile-avatar"
                        >
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ mb_strtoupper(mb_substr(trim($user->name), 0, 1)) }}
                        </div>
                    @endif

                    <div class="mt-4">
                        <div class="fw-bold fs-5">{{ $user->name }}</div>
                        <div class="text-muted small">{{ $user->email }}</div>
                    </div>

                    <form
                        action="{{ route('profile.avatar.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-4 text-start"
                    >
                        @csrf

                        <label class="profile-label">
                            Chọn ảnh mới
                        </label>

                        <input
                            type="file"
                            name="avatar"
                            class="form-control profile-input"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            required
                        >

                        <div class="form-text">
                            JPG, PNG hoặc WEBP. Tối đa 2MB.
                        </div>

                        <button
                            type="submit"
                            class="btn profile-btn profile-btn-primary w-100 mt-3"
                        >
                            📷 Cập nhật ảnh
                        </button>
                    </form>

                    @if($user->avatar)
                        <form
                            action="{{ route('profile.avatar.delete') }}"
                            method="POST"
                            class="mt-2"
                            onsubmit="return confirm('Bạn có chắc muốn xóa ảnh đại diện?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-outline-danger profile-btn w-100"
                            >
                                🗑️ Xóa ảnh đại diện
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            {{-- THÔNG TIN CÁ NHÂN --}}
            <div class="profile-card mb-4">
                <div class="card-body p-4">
                    <h5 class="profile-section-title">
                        👤 Thông tin cá nhân
                    </h5>

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="profile-label">
                                    Họ và tên
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control profile-input"
                                    value="{{ old('name', $user->name) }}"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="col-md-5">
                                <label class="profile-label">
                                    Vai trò
                                </label>

                                <div class="profile-info-box">
                                    <span class="fw-bold text-success">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="profile-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control profile-input"
                                    value="{{ $user->email }}"
                                    disabled
                                >

                                <div class="form-text">
                                    Email đăng nhập được giữ nguyên để không ảnh hưởng xác thực OTP.
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="profile-info-box d-flex justify-content-between align-items-center">
                                    <span>Trạng thái tài khoản</span>

                                    <span class="fw-bold text-success">
                                        ● Đang hoạt động
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn profile-btn profile-btn-primary"
                                >
                                    💾 Cập nhật thông tin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ĐỔI MẬT KHẨU --}}
            <div class="profile-card">
                <div class="card-body p-4">
                    <h5 class="profile-section-title">
                        🔐 Đổi mật khẩu
                    </h5>

                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="profile-label">
                                    Mật khẩu hiện tại
                                </label>

                                <input
                                    type="password"
                                    name="current_password"
                                    class="form-control profile-input"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="profile-label">
                                    Mật khẩu mới
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control profile-input"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="profile-label">
                                    Xác nhận mật khẩu mới
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control profile-input"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <div class="form-text mb-3">
                                    Mật khẩu mới phải có ít nhất 8 ký tự và khác mật khẩu hiện tại.
                                </div>

                                <button
                                    type="submit"
                                    class="btn profile-btn profile-btn-primary"
                                >
                                    🔒 Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
