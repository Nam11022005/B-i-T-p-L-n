@extends('admin.layouts.app')
@section('title', 'Danh sách Sản phẩm')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
<div>
<h2 class="mb-1 fw-bold">📦 Danh sách Sản phẩm</h2>
<p class="text-muted mb-0">Quản lý tất cả sản phẩm trong cửa hàng</p>
</div>
<a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg">
➕ Thêm Sản phẩm
</a>
</div>

{{-- Hiển thị thông báo thành công sau khi Thêm / Sửa / Xóa --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>✓ Thành công!</strong> {{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>✗ Lỗi!</strong> {{ session('error') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm border-0 mb-4">
<div class="card-body p-0">
<div class="table-responsive">
<table class="table align-middle mb-0">
<thead class="table-dark">
<tr>
<th style="width: 60px;">ID</th>
<th>Sản phẩm</th>
<th>Danh mục</th>
<th>Mô tả</th>
<th style="width: 80px;">Số lượng</th>
<th style="width: 100px;">Giá</th>
<th style="width: 200px;" class="text-center">Hành động</th>
</tr>
</thead>
<tbody>
@forelse ($products as $product)
<tr>
<td><strong>#{{ $product->id }}</strong></td>
<td>
<div class="d-flex align-items-center gap-2">
@if($product->image && Storage::disk('public')->exists($product->image))
<img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" style="width: 52px; height: 52px; object-fit: cover; border-radius: 8px;">
@else
<div class="d-flex align-items-center justify-content-center text-center" style="width: 52px; height: 52px; border-radius: 8px; background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1f2937; font-size: 11px; font-weight: 700;">IMG</div>
@endif
<div>
<strong class="d-block">{{ $product->name }}</strong>
<small class="text-muted">ID: {{ $product->id }}</small>
</div>
</div>
</td>
<td>
<span class="badge bg-info text-dark">
{{ $product->category->name ?? 'Chưa phân loại' }}
</span>
</td>
<td>
<small class="text-muted">{{ Str::limit($product->description, 50, '...') }}</small>
</td>
<td>
<span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
{{ $product->quantity }} cái
</span>
</td>
<td class="fw-bold text-primary">{{ number_format($product->price, 0, ',', '.') }} đ</td>
<td class="text-center">
<div class="btn-group btn-group-sm" role="group">
<a href="{{ route('admin.products.show', $product) }}" class="btn btn-info text-white" title="Xem chi tiết">
👁️
</a>
<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning" title="Sửa">
✏️
</a>
<form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa sản phẩm này?');">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger btn-sm" title="Xóa">
🗑️
</button>
</form>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="7" class="text-center text-muted py-4">
📭 Chưa có sản phẩm nào trong hệ thống.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>

<!-- Phân trang -->
<div class="d-flex justify-content-center mt-4">
{{ $products->links() }}
</div>
@endsection