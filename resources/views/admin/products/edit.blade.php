@extends('admin.layouts.app')

@section('title', 'Sửa Sản phẩm')
@section('content')
<div class="card">
<div class="card-header">
<h2 class="mb-0">Cập nhật Sản phẩm</h2>
</div>
<div class="card-body">
{{-- Báo lỗi tổng quan ở đầu trang --}}
@if ($errors->any())
<div class="alert alert-danger mb-4">
<strong class="d-block mb-1">Đã có lỗi xảy ra, vui lòng kiểm tra lại dữ liệu:</strong>
<ul class="mb-0 ps-3">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
{{-- Truyền trực tiếp biến $product vào route --}}
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<!-- Ảnh minh họa -->
<div class="mb-3">
<label for="image" class="form-label">Ảnh minh họa sản phẩm</label>
<input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
<div id="image-preview-box" class="mt-2">
@if($product->image && Storage::disk('public')->exists($product->image))
<img id="current-product-image" src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" style="max-height: 140px; border-radius: 12px;">
@else
<div id="current-product-image-fallback" class="d-flex align-items-center justify-content-center rounded-3 text-white fw-bold" style="width: 120px; height: 120px; background: linear-gradient(135deg, #c7d2fe, #93c5fd, #bfdbfe); color: #1f2937;">IMG</div>
@endif
</div>
@error('image')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('image');
        const previewBox = document.getElementById('image-preview-box');
        const currentImage = document.getElementById('current-product-image');
        const fallback = document.getElementById('current-product-image-fallback');

        if (!input) return;

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (!file) {
                if (currentImage) {
                    currentImage.style.display = 'block';
                }
                if (fallback) {
                    fallback.style.display = 'flex';
                }
                return;
            }

            if (currentImage) {
                currentImage.style.display = 'none';
            }
            if (fallback) {
                fallback.style.display = 'none';
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview ảnh mới';
                img.style.maxHeight = '140px';
                img.style.borderRadius = '12px';

                previewBox.innerHTML = '';
                previewBox.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
<!-- Tên sản phẩm -->
<div class="mb-3">
<label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
<input type="text"
id="name"
name="name"
class="form-control @error('name') is-invalid @enderror"

value="{{ old('name', $product->name) }}"
required>
@error('name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<!-- Danh mục -->
<div class="mb-3">
<label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
<select id="category_id"
name="category_id"
class="form-select @error('category_id') is-invalid @enderror"
required>
<option value="">-- Chọn danh mục --</option>
@foreach ($categories as $category)
{{-- Dùng @selected() giúp code gọn gàng, dễ đọc --}}
<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
{{ $category->name }}
</option>
@endforeach
</select>
@error('category_id')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<!-- Mô tả -->
<div class="mb-3">
<label for="description" class="form-label">Mô tả</label>
<textarea id="description"
name="description"
class="form-control @error('description') is-invalid @enderror"
rows="3">{{ old('description', $product->description) }}</textarea>

@error('description')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<!-- Số lượng -->
<div class="mb-3">
<label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
<input type="number"
id="quantity"
name="quantity"
class="form-control @error('quantity') is-invalid @enderror"
value="{{ old('quantity', $product->quantity) }}"
required
min="0">
@error('quantity')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<!-- Giá tiền -->
<div class="mb-3">
<label for="price" class="form-label">Giá tiền <span class="text-danger">*</span></label>
<input type="number"
step="0.01"
id="price"
name="price"
class="form-control @error('price') is-invalid @enderror"
value="{{ old('price', $product->price) }}"
required
min="0">
@error('price')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>
<!-- Thao tác -->
<div class="mt-4 d-flex gap-2 flex-wrap">
<button type="submit" class="btn btn-primary">💾 Cập nhật</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">← Quay lại</a>
</div>
</form>

<!-- Nút xóa -->
<div class="mt-3 pt-3 border-top">
<h6 class="fw-bold text-danger mb-2">Xóa sản phẩm này</h6>
<form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger">🗑️ Xóa sản phẩm</button>
</form>
</div>
</div>
</div>
@endsection