@extends('layouts.app')
@section('title', 'Danh sách Sản phẩm')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Sản phẩm</h2>
</div>
<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Tên Sản phẩm</th>
<th>Danh mục</th>
<th>Mô tả</th>
<th>Số lượng</th>
<th>Giá</th>
<th>Hành động</th>
</tr>
</thead>
<tbody>
@foreach ($products as $product)
<tr>
<td>{{ $product->id }}</td>
<td>
@if($product->image && Storage::disk('public')->exists($product->image))
<img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail me-2" style="width: 56px; height: 56px; object-fit: cover;">
@else
<div class="img-thumbnail me-2 d-flex align-items-center justify-content-center text-center" style="width: 56px; height: 56px; font-size: 10px; font-weight: 600; background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1f2937;">IMG</div>
@endif
{{ $product->name }}
</td>
<td>
<span class="badge bg-info text-dark">
{{ $product->category->name ?? 'Không có' }}
</span>
</td>
<td>{{ $product->description }}</td>
<td>{{ $product->quantity }}</td>
<td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
<td>
<a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}">Xem</a>
<form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
@csrf
<button class="btn btn-success btn-sm" type="submit" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
{{ $product->quantity > 0 ? 'Mua ngay' : 'Hết hàng' }}
</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="d-flex justify-content-center mt-3">
{{ $products->links() }}
</div>
@endsection