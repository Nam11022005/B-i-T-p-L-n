@extends('admin.layouts.app')
@section('title', 'Chi tiết Sản phẩm')
@section('content')
<div class="card shadow-sm border-0">
<div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
<h2 class="mb-0">📦 Chi tiết Sản phẩm: {{ $product->name }}</h2>
<a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">← Quay lại danh sách</a>
</div>
<div class="card-body">
<div class="row">
<div class="col-md-6">
@if($product->image && Storage::disk('public')->exists($product->image))
<div class="mb-4 text-center">
<img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-4 shadow-sm border" style="max-height: 400px; object-fit: cover;">
</div>
@else
<div class="mb-4 text-center">
<div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm text-white fw-bold fs-2" style="height: 300px; background: linear-gradient(135deg, #c7d2fe, #93c5fd, #bfdbfe); color: #1f2937;">
{{ strtoupper(substr($product->name, 0, 2)) }}
</div>
</div>
@endif
</div>

<div class="col-md-6">
<div class="row mb-3">
<div class="col-12 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">ID Sản phẩm</small>
<strong class="fs-5">#{{ $product->id }}</strong>
</div>
</div>
<div class="col-12 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Tên sản phẩm</small>
<strong class="fs-5">{{ $product->name }}</strong>
</div>
</div>
<div class="col-12 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Danh mục</small>
<span class="badge bg-info text-dark fs-6">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
</div>
</div>
<div class="col-md-6 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Số lượng</small>
<strong class="fs-5 {{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->quantity }} cái</strong>
</div>
</div>
<div class="col-md-6 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Giá tiền</small>
<strong class="fs-5 text-primary">{{ number_format($product->price, 0, ',', '.') }} đ</strong>
</div>
</div>
<div class="col-12 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Mô tả</small>
<p class="mb-0">{{ $product->description ?? 'Không có mô tả' }}</p>
</div>
</div>
<div class="col-md-6 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Ngày tạo</small>
<small>{{ $product->created_at ? $product->created_at->format('d/m/Y H:i') : 'N/A' }}</small>
</div>
</div>
<div class="col-md-6 mb-3">
<div class="bg-light p-3 rounded-3 border">
<small class="text-muted d-block mb-1">Cập nhật lần cuối</small>
<small>{{ $product->updated_at ? $product->updated_at->format('d/m/Y H:i') : 'N/A' }}</small>
</div>
</div>
</div>
</div>
</div>

<hr>

<div class="mt-4 d-flex gap-2 flex-wrap">
<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">✏️ Sửa sản phẩm</a>
<form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">🗑️ Xóa sản phẩm</button>
</form>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">← Quay lại</a>
</div>
</div>
</div>
@endsection