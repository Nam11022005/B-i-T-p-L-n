<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tinh Hoa Tây Bắc | Quản trị')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    @stack('styles')

    <style>
        /* =====================================================
           TINH HOA TÂY BẮC - ADMIN THEME
        ===================================================== */

        :root {
            --tb-brown: #5f341d;
            --tb-brown-dark: #2c1810;
            --tb-brown-light: #7a4728;

            --tb-green: #48633b;
            --tb-green-dark: #33492a;

            --tb-red: #a83b2d;
            --tb-red-dark: #8b3025;

            --tb-gold: #f2c15c;
            --tb-gold-dark: #dda83e;

            --tb-cream: #fffaf0;
            --tb-soft: #f8efe2;
            --tb-border: #ead8bf;

            --tb-text: #2f241e;
            --tb-muted: #7b6a5e;
        }


        /* =====================================================
           BODY
        ===================================================== */

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;

            background:
                linear-gradient(
                    180deg,
                    #fffaf0 0%,
                    #f8efe2 100%
                );

            color: var(--tb-text);

            font-family:
                "Segoe UI",
                Arial,
                sans-serif;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .admin-navbar {
            background:
                linear-gradient(
                    135deg,
                    #2c1810 0%,
                    #5f341d 55%,
                    #48633b 100%
                ) !important;

            min-height: 70px;

            box-shadow:
                0 10px 30px
                rgba(44, 24, 16, 0.22);

            border-bottom:
                1px solid
                rgba(255, 255, 255, 0.08);
        }


        /* =====================================================
           BRAND
        ===================================================== */

        .admin-brand {
            color: #ffffff !important;

            font-size: 21px;

            font-weight: 800;

            letter-spacing: 0.3px;

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 8px;

            white-space: nowrap;

            transition: 0.2s ease;
        }

        .admin-brand:hover {
            color: var(--tb-gold) !important;
        }

        .brand-icon {
            width: 38px;
            height: 38px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.12);

            font-size: 21px;
        }

        .brand-name {
            line-height: 1.1;
        }

        .brand-admin {
            display: block;

            margin-top: 2px;

            color:
                rgba(255, 255, 255, 0.62);

            font-size: 10px;

            font-weight: 600;

            letter-spacing: 1.5px;

            text-transform: uppercase;
        }


        /* =====================================================
           NAVIGATION
        ===================================================== */

        .admin-navbar .navbar-nav {
            gap: 3px;
        }

        .admin-navbar .nav-link {
            color:
                rgba(255, 255, 255, 0.82) !important;

            font-weight: 600;

            font-size: 14px;

            border-radius: 10px;

            padding:
                9px 11px !important;

            transition:
                all 0.2s ease;

            white-space: nowrap;
        }

        .admin-navbar .nav-link:hover {
            color: #ffffff !important;

            background:
                rgba(255, 255, 255, 0.1);
        }

        .admin-navbar .nav-link.active {
            color:
                var(--tb-gold) !important;

            background:
                rgba(255, 255, 255, 0.1);
        }


        /* =====================================================
           ADMIN ACCOUNT
        ===================================================== */

        .admin-account {
            border-left:
                1px solid
                rgba(255, 255, 255, 0.15);

            margin-left: 8px;

            padding-left: 12px;
        }

        .admin-account .nav-link {
            color:
                #ffffff !important;
        }


        /* =====================================================
           DROPDOWN
        ===================================================== */

        .dropdown-menu {
            min-width: 230px;

            border:
                1px solid
                #eee0ce;

            border-radius: 14px;

            padding: 8px;

            box-shadow:
                0 16px 40px
                rgba(44, 24, 16, 0.16);
        }

        .dropdown-header-admin {
            padding:
                10px 12px 12px;

            border-bottom:
                1px solid
                #f0e4d5;

            margin-bottom: 5px;
        }

        .dropdown-header-admin strong {
            color:
                var(--tb-brown-dark);

            display: block;
        }

        .dropdown-header-admin small {
            color:
                var(--tb-muted);
        }

        .dropdown-item {
            padding:
                10px 12px;

            border-radius: 9px;

            font-weight: 500;

            color:
                var(--tb-text);

            transition:
                all 0.15s ease;
        }

        .dropdown-item:hover {
            background:
                var(--tb-soft);

            color:
                var(--tb-brown-dark);
        }

        .dropdown-item.text-danger:hover {
            background:
                #fff0ed;

            color:
                var(--tb-red) !important;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .admin-main {
            min-height:
                calc(100vh - 70px);

            padding-top: 30px;

            padding-bottom: 60px;
        }


        /* =====================================================
           CARDS
        ===================================================== */

        .card {
            border:
                1px solid
                var(--tb-border);

            border-radius: 18px;

            background: #ffffff;

            overflow: hidden;

            box-shadow:
                0 10px 28px
                rgba(95, 52, 29, 0.07);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow:
                0 14px 34px
                rgba(95, 52, 29, 0.11);
        }

        .card-header {
            background:
                linear-gradient(
                    135deg,
                    #fffaf0,
                    #f8efe2
                );

            border-bottom:
                1px solid
                var(--tb-border);

            color:
                var(--tb-brown-dark);

            font-weight: 700;
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table {
            margin-bottom: 0;

            color:
                var(--tb-text);

            vertical-align: middle;
        }

        .table thead th {
            background:
                linear-gradient(
                    135deg,
                    #3b2114,
                    #5f341d
                ) !important;

            color: #ffffff !important;

            border: none !important;

            padding:
                14px 12px;

            font-weight: 700;

            white-space: nowrap;
        }

        .table tbody td {
            padding:
                14px 12px;

            border-color:
                #f0e4d5;
        }

        .table tbody tr {
            transition:
                background 0.15s ease;
        }

        .table tbody tr:hover {
            background:
                #fff9ef;
        }


        /* =====================================================
           BUTTONS
        ===================================================== */

        .btn {
            border-radius: 10px;

            font-weight: 600;

            transition:
                all 0.2s ease;
        }

        .btn:hover {
            transform:
                translateY(-1px);
        }


        /* PRIMARY */

        .btn-primary {
            background:
                linear-gradient(
                    135deg,
                    var(--tb-red),
                    var(--tb-brown)
                );

            border: none;

            color: #ffffff;

            box-shadow:
                0 7px 16px
                rgba(168, 59, 45, 0.18);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background:
                linear-gradient(
                    135deg,
                    var(--tb-red-dark),
                    var(--tb-brown-dark)
                );

            color: #ffffff;
        }


        /* SUCCESS */

        .btn-success {
            background:
                linear-gradient(
                    135deg,
                    var(--tb-green),
                    var(--tb-green-dark)
                );

            border: none;

            color: #ffffff;
        }

        .btn-success:hover,
        .btn-success:focus {
            background:
                linear-gradient(
                    135deg,
                    #3c5631,
                    #293d23
                );

            color: #ffffff;
        }


        /* WARNING */

        .btn-warning {
            background:
                var(--tb-gold);

            border-color:
                var(--tb-gold);

            color:
                var(--tb-brown-dark);

            font-weight: 700;
        }

        .btn-warning:hover {
            background:
                var(--tb-gold-dark);

            border-color:
                var(--tb-gold-dark);

            color:
                var(--tb-brown-dark);
        }


        /* DANGER */

        .btn-danger {
            background:
                var(--tb-red);

            border-color:
                var(--tb-red);
        }

        .btn-danger:hover {
            background:
                var(--tb-red-dark);

            border-color:
                var(--tb-red-dark);
        }


        /* OUTLINE PRIMARY */

        .btn-outline-primary {
            color:
                var(--tb-red);

            border-color:
                var(--tb-red);
        }

        .btn-outline-primary:hover {
            color: #ffffff;

            background:
                var(--tb-red);

            border-color:
                var(--tb-red);
        }


        /* =====================================================
           FORMS
        ===================================================== */

        .form-label {
            color:
                var(--tb-brown-dark);

            font-weight: 600;
        }

        .form-control,
        .form-select {
            min-height: 44px;

            border:
                1px solid
                #e5d4bd;

            border-radius: 11px;

            background:
                #ffffff;

            color:
                var(--tb-text);

            box-shadow: none;
        }

        textarea.form-control {
            min-height: auto;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:
                var(--tb-red);

            box-shadow:
                0 0 0 3px
                rgba(168, 59, 45, 0.08);
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .alert {
            border: none;

            border-radius: 14px;

            box-shadow:
                0 8px 22px
                rgba(95, 52, 29, 0.08);
        }

        .alert-success {
            background:
                #edf6e9;

            color:
                #35512b;
        }

        .alert-danger {
            background:
                #fff0ed;

            color:
                #8b3025;
        }


        /* =====================================================
           BADGE
        ===================================================== */

        .badge.bg-success {
            background:
                var(--tb-green) !important;
        }

        .badge.bg-danger {
            background:
                var(--tb-red) !important;
        }

        .badge.bg-warning {
            background:
                var(--tb-gold) !important;

            color:
                var(--tb-brown-dark) !important;
        }


        /* =====================================================
           PAGE TITLES
        ===================================================== */

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color:
                var(--tb-text);
        }


        /* =====================================================
           PAGINATION
        ===================================================== */

        .pagination {
            gap: 4px;
        }

        .page-link {
            color:
                var(--tb-brown);

            border:
                1px solid
                var(--tb-border);

            border-radius:
                8px !important;
        }

        .page-link:hover {
            color:
                var(--tb-red);

            background:
                var(--tb-soft);

            border-color:
                var(--tb-border);
        }

        .page-item.active .page-link {
            background:
                var(--tb-brown);

            border-color:
                var(--tb-brown);

            color: #ffffff;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1199px) {

            .admin-navbar .nav-link {
                font-size: 13px;

                padding-left:
                    8px !important;

                padding-right:
                    8px !important;
            }
        }


        @media (max-width: 991px) {

            .admin-navbar {
                padding:
                    10px 0;
            }

            .navbar-collapse {
                padding-top:
                    15px;
            }

            .admin-navbar .navbar-nav {
                gap: 4px;
            }

            .admin-navbar .nav-link {
                padding:
                    10px 12px !important;
            }

            .admin-account {
                border-left: none;

                border-top:
                    1px solid
                    rgba(255, 255, 255, 0.12);

                margin-left: 0;

                margin-top: 8px;

                padding-left: 0;

                padding-top: 8px;
            }

            .admin-main {
                padding-top: 20px;
            }
        }

    </style>

</head>


<body>


@include('layouts.partials.admin-navbar')


{{-- =========================================================
    MAIN CONTENT
========================================================= --}}

<main class="admin-main">

    <div class="container-fluid px-lg-5">


        {{-- SUCCESS --}}
        @if(session('success'))

            <div
                class="
                    alert
                    alert-success
                    alert-dismissible
                    fade
                    show
                "
                role="alert"
            >

                ✅ {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        @endif


        {{-- ERROR --}}
        @if(session('error'))

            <div
                class="
                    alert
                    alert-danger
                    alert-dismissible
                    fade
                    show
                "
                role="alert"
            >

                ❌ {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        @endif


        {{-- VALIDATION ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    ❌ Có lỗi xảy ra:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- CONTENT --}}
        @yield('content')

    </div>

</main>
@include('layouts.partials.footer')

{{-- =========================================================
    BOOTSTRAP
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

@stack('scripts')


</body>
</html>