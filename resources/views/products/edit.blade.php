@extends('layouts.app')
@section('title', 'Sửa Sản phẩm')
@section('content')
<div class="container">
<h2>Chỉnh sửa sản phẩm</h2>

37

<form action="{{ route('products.update', $product->id) }}" method="POST">
@csrf
@method('PUT')
<div class="mb-3">
<label for="name" class="form-label">Tên sản phẩm</label>
<input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
</div>
<!-- BỔ SUNG ĐOẠN NÀY VÀO -->
<div class="mb-3">
<label for="category_id" class="form-label">Danh mục</label>
<select class="form-control" id="category_id" name="category_id" required>
@foreach($categories as $category)
<option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : ''
}}>
{{ $category->name }}
</option>
@endforeach
</select>
</div>
<div class="mb-3">
<label for="description" class="form-label">Mô tả</label>
<textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
</div>
<div class="mb-3">
<label for="quantity" class="form-label">Số lượng</label>
<input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
</div>
<div class="mb-3">

38
<label for="price" class="form-label">Giá</label>
<input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}"
required>
</div>
<button type="submit" class="btn btn-primary">Cập nhật</button>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
</div>
@endsection