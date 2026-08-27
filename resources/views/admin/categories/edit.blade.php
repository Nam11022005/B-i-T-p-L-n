@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa danh mục')
@section('content')
<div class="row">
<div class="col-md-6 offset-md-3">
<div class="card">
<div class="card-header bg-warning text-dark">
<h4 class="mb-0">Chỉnh sửa Danh mục</h4>
</div>
<div class="card-body">
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
@csrf
@method('PUT')
<!-- Tên danh mục -->
<div class="mb-3">
<label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
<input type="text"
class="form-control @error('name') is-invalid @enderror"
id="name"
name="name"
value="{{ old('name', $category->name) }}"
placeholder="Nhập tên danh mục..."
required>
@error('name')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>
<!-- Các nút thao tác -->
<div class="d-flex justify-content-between gap-2 flex-wrap">
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Quay lại</a>
<button type="submit" class="btn btn-success">💾 Cập nhật</button>
</div>
</form>

<!-- Nút xóa -->
<div class="mt-3 pt-3 border-top">
<h6 class="fw-bold text-danger mb-2">Xóa danh mục này</h6>
<form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger">🗑️ Xóa danh mục</button>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection