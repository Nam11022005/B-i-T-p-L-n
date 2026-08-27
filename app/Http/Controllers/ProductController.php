<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
// ==========================================
// KHU VỰC QUẢN LÝ DÀNH CHO ADMIN (Resource Methods)
// ==========================================
public function index()
{
$products = Product::with('category')->latest()->paginate(10);
return view('admin.products.index', compact('products'));
}
public function create()
{
$categories = Category::all();
return view('admin.products.create', compact('categories'));
}
public function store(Request $request)
{
$validatedData = $request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
'quantity' => 'required|integer|min:0',

'price' => 'required|numeric|min:0',
'category_id' => 'required|exists:categories,id',
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
]);
if ($request->hasFile('image')) {
$imagePath = $request->file('image')->store('products', 'public');
$validatedData['image'] = $imagePath;
}
Product::create($validatedData);
return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
}
public function show(Product $product)
{
return view('admin.products.show', compact('product'));
}
public function edit(Product $product)
{
$categories = Category::all();
return view('admin.products.edit', compact('product', 'categories'));
}
public function update(Request $request, Product $product)
{
$validatedData = $request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
'quantity' => 'required|integer|min:0',


'price' => 'required|numeric|min:0',
'category_id' => 'required|exists:categories,id',
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
]);
if ($request->hasFile('image')) {
if ($product->image && Storage::disk('public')->exists($product->image)) {
Storage::disk('public')->delete($product->image);
}
$imagePath = $request->file('image')->store('products', 'public');
$validatedData['image'] = $imagePath;
}
$product->update($validatedData);
return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}
public function destroy(Product $product)
{
if ($product->image && Storage::disk('public')->exists($product->image)) {
Storage::disk('public')->delete($product->image);
}
$product->delete();
return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
}
// ==========================================
// KHU VỰC DÀNH CHO NGƯỜI DÙNG THƯỜNG (User Methods)
// ==========================================
public function userIndex()


{
$products = Product::with('category')->paginate(6);
return view('products.index', compact('products'));
}
public function show_normal(Product $product)
{
return view('products.show', compact('product'));
}
}