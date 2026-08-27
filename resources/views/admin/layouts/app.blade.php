<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Phương Nam Shop')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@stack('styles')
<style>
    body {
        background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        color: #1f2937;
        font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
        background: linear-gradient(90deg, #111827, #1f2937 35%, #312e81) !important;
        box-shadow: 0 12px 25px rgba(17, 24, 39, 0.15);
    }

    .navbar-brand {
        letter-spacing: 0.4px;
        font-weight: 700;
    }

    .nav-link {
        font-weight: 500;
    }

    .nav-link.active,
    .nav-link:hover {
        color: #c7d2fe !important;
    }

    main {
        padding-top: 2rem;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
    }

    .alert {
        border: none;
        border-radius: 0.9rem;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #4338ca);
    }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
<div class="container">
<a class="navbar-brand fw-bold" href="{{ url('/') }}">Phương Nam Shop</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav me-auto">
<li class="nav-item">
<a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
</li>
@auth
<li class="nav-item">
<a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm</a>
</li>
@if(Auth::user()->role === 'admin')
<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Sản phẩm (Admin)</a>
</li>
<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Danh mục (Admin)</a>
</li>
@endif
@endauth
</ul>
<ul class="navbar-nav ms-auto">
@guest
<li class="nav-item">
<a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
</li>
<li class="nav-item">
<a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
</li>
@else
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
data-bs-toggle="dropdown" aria-expanded="false">
Xin chào, {{ Auth::user()->name }}
</a>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
<li>
<a class="dropdown-item" href="{{ route('admin.profile') }}">Hồ sơ Admin</a>
</li>
<li>
<a class="dropdown-item text-danger" href="{{ route('logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
Đăng xuất
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
</li>
</ul>
</li>
@endguest
</ul>
</div>
</div>
</nav>
<main class="container py-4">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ session('error') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>