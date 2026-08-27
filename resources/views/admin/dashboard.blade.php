@extends('admin.layouts.app')
@section('title', 'Trang Quản Trị Dashboard')
@section('content')
<div class="card shadow-sm border-0">
<div class="card-body p-4">
<!-- Thanh Breadcrumb (Đường dẫn điều hướng) -->
<nav aria-label="breadcrumb" class="mb-3">
<ol class="breadcrumb mb-0">
<li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Trang chủ</a></li>
<li class="breadcrumb-item"><a href="#" class="text-decoration-none">Quản trị viên</a></li>
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
</ol>
</nav>
<h1 class="fw-bold text-primary mb-3">Admin Dashboard</h1>
<p class="text-muted">Chào mừng bạn đến với khu vực quản trị hệ thống dành cho Quản trị viên.</p>
<hr>
<div class="row g-3 mt-3">
<div class="col-md-4">
<div class="p-4 bg-light rounded shadow-sm">
<h5 class="fw-bold"><i class="bi bi-box-seam me-2"></i>Quản lý Sản phẩm</h5>
<p class="text-muted small">Thêm mới, chỉnh sửa, xem chi tiết hoặc xóa các sản phẩm trong hệ thống.</p>
<a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">Quản lý Sản phẩm</a>
</div>
</div>
<div class="col-md-4">
<div class="p-4 bg-light rounded shadow-sm">
<h5 class="fw-bold"><i class="bi bi-tags me-2"></i>Quản lý Danh mục</h5>
<p class="text-muted small">Thêm mới, chỉnh sửa hoặc xóa các danh mục sản phẩm.</p>
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Quản lý Danh mục</a>
</div>
</div>
<div class="col-md-4">
<div class="p-4 bg-light rounded shadow-sm">
<h5 class="fw-bold"><i class="bi bi-bag-check me-2"></i>Quản lý Đơn hàng</h5>
<p class="text-muted small">Xem tất cả đơn hàng, trạng thái và tổng doanh thu từ gian hàng.</p>
<a href="{{ route('admin.orders.index') }}" class="btn btn-success btn-sm">Xem đơn hàng</a>
</div>
</div>
</div>

<div class="row g-3 mt-3">
<div class="col-md-4">
<div class="p-4 bg-primary text-white rounded shadow-sm">
<div class="small text-white-50">Tổng sản phẩm</div>
<div class="fs-3 fw-bold">{{ \App\Models\Product::count() }}</div>
</div>
</div>
<div class="col-md-4">
<div class="p-4 bg-success text-white rounded shadow-sm">
<div class="small text-white-50">Tổng đơn hàng</div>
<div class="fs-3 fw-bold">{{ \App\Models\Order::count() }}</div>
</div>
</div>
<div class="col-md-4">
<div class="p-4 bg-warning text-dark rounded shadow-sm">
<div class="small text-dark-50">Doanh thu</div>
<div class="fs-3 fw-bold">{{ number_format(\App\Models\Order::sum('total_price'), 0, ',', '.') }} đ</div>
</div>
</div>
</div>
</div>
</div>
@endsection