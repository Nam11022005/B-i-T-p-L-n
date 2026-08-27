@extends('admin.layouts.app')
@section('title', 'Thêm mới danh mục')
@section('content')
<div class="row">
<div class="col-md-6 offset-md-3">
<div class="card shadow-sm border-0">
<div class="card-header bg-success text-white d-flex align-items-center gap-2">
<h4 class="mb-0">➕ Thêm Danh mục Mới</h4>
</div>
<div class="card-body">
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
<strong class="d-block mb-2">⚠️ Lỗi xảy ra:</strong>
<ul class="mb-0 ps-3">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST">
@csrf
<!-- Tên danh mục -->
<div class="mb-3">
<label for="name" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
<input type="text"
class="form-control @error('name') is-invalid @enderror"
id="name"
name="name"
value="{{ old('name') }}"
placeholder="Ví dụ: Điện thoại, Laptop..."
required
autofocus>
@error('name')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>

<!-- Các nút thao tác -->
<div class="d-flex justify-content-between gap-2">
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
← Quay lại
</a>
<button type="submit" class="btn btn-success">
💾 Lưu danh mục
</button>
</div>
</form>
</div>
</div>
</div>
</div>
@endsection