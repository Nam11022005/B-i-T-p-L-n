@extends('admin.layouts.app')
@section('title', 'Thêm Sản phẩm')

@section('content')
<div class="card shadow-sm border-0">
<div class="card-header bg-success text-white d-flex align-items-center gap-2">
<h2 class="mb-0">➕ Thêm Sản phẩm Mới</h2>
</div>
<div class="card-body">
{{-- Thông báo lỗi chung ở đầu trang --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4">
<strong class="d-block mb-2">⚠️ Lỗi xảy ra:</strong>
<ul class="mb-0 ps-3">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">
<div class="col-md-8">
<!-- Tên sản phẩm -->
<div class="mb-3">
<label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
<input type="text"
id="name"
name="name"
class="form-control @error('name') is-invalid @enderror"
value="{{ old('name') }}"
placeholder="Ví dụ: iPhone 15 Pro Max..."
required
autofocus>
@error('name')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>

<!-- Danh mục -->
<div class="mb-3">
<label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
<select id="category_id"
name="category_id"
class="form-select @error('category_id') is-invalid @enderror"
required>
<option value="">-- Chọn danh mục --</option>
@foreach ($categories as $category)
<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
{{ $category->name }}
</option>
@endforeach
</select>
@error('category_id')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>

<!-- Mô tả -->
<div class="mb-3">
<label for="description" class="form-label fw-bold">Mô tả</label>
<textarea id="description"
name="description"
class="form-control @error('description') is-invalid @enderror"
rows="4"
placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
@error('description')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>

<div class="row">
<div class="col-md-6">
<!-- Số lượng -->
<div class="mb-3">
<label for="quantity" class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
<input type="number"
id="quantity"
name="quantity"
class="form-control @error('quantity') is-invalid @enderror"
value="{{ old('quantity', 0) }}"
required
min="0">
@error('quantity')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>
</div>

<div class="col-md-6">
<!-- Giá tiền -->
<div class="mb-3">
<label for="price" class="form-label fw-bold">Giá tiền (VNĐ) <span class="text-danger">*</span></label>
<input type="number"
step="1000"
id="price"
name="price"
class="form-control @error('price') is-invalid @enderror"
value="{{ old('price') }}"
placeholder="0"
required
min="0">
@error('price')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>
</div>
</div>
</div>

<div class="col-md-4">
<!-- Ảnh minh họa -->
<div class="mb-3">
<label for="image" class="form-label fw-bold">Ảnh minh họa</label>
<div class="border rounded-3 p-3 text-center bg-light" id="image-drop-area" style="cursor: pointer; min-height: 200px; display: flex; align-items: center; justify-content: center;">
<div id="image-placeholder">
<div class="fs-4 mb-2">🖼️</div>
<p class="text-muted mb-0">Click hoặc kéo ảnh vào đây</p>
<small class="text-muted d-block">PNG, JPG, GIF (Max 2MB)</small>
</div>
</div>
<input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror d-none" accept="image/*">
<div id="image-preview" class="mt-2"></div>
@error('image')
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
</div>
</div>
</div>

<!-- Các nút thao tác -->
<div class="mt-4 d-flex justify-content-between gap-2">
<a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
← Quay lại
</a>
<button type="submit" class="btn btn-success">
💾 Thêm sản phẩm
</button>
</div>

</form>
</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const dropArea = document.getElementById('image-drop-area');
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');

    // Click to select
    dropArea.addEventListener('click', () => imageInput.click());

    // Drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.style.backgroundColor = '#e7f3ff';
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.style.backgroundColor = '#f5f5f5';
        });
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length) {
            imageInput.files = files;
            handleImageSelection();
        }
    });

    imageInput.addEventListener('change', handleImageSelection);

    function handleImageSelection() {
        const file = imageInput.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                placeholder.style.display = 'none';
                preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">`;
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endpush

@endsection