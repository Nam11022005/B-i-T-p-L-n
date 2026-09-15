<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // ==========================================
    // KHU VỰC QUẢN LÝ DÀNH CHO ADMIN
    // ==========================================
    public function toggleFeatured(Product $product)
{
    $product->is_featured = !$product->is_featured;
    $product->save();

    return back()->with(
        'success',
        $product->is_featured
            ? '⭐ Đã ghim sản phẩm nổi bật.'
            : 'Đã bỏ ghim sản phẩm nổi bật.'
    );
}

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');

                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
            });
        }

        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        if ($request->stock === 'in_stock') {
            $query->where('quantity', '>', 0);
        } elseif ($request->stock === 'out_of_stock') {
            $query->where('quantity', '<=', 0);
        }

        if ($request->featured === 'featured') {
            $query->where('is_featured', true);
        } elseif ($request->featured === 'normal') {
            $query->where('is_featured', false);
        }

        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'stock_asc':
                $query->orderBy('quantity', 'asc');
                break;

            case 'stock_desc':
                $query->orderBy('quantity', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        $products = $query
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'admin.products.index',
            compact('products', 'categories')
        );
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            $this->productRules(),
            $this->productMessages()
        );

        $this->validateSaleRule($request);

        if ($request->hasFile('image')) {
            $validatedData['image'] =
                $request->file('image')->store(
                    'products',
                    'public'
                );
        }

        Product::create($validatedData);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Thêm sản phẩm thành công!'
            );
    }

    public function show(Product $product)
    {
        return view(
            'admin.products.show',
            compact('product')
        );
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'admin.products.edit',
            compact('product', 'categories')
        );
    }

    public function update(
        Request $request,
        Product $product
    ) {
        $validatedData = $request->validate(
            $this->productRules(),
            $this->productMessages()
        );

        $this->validateSaleRule($request);

        if ($request->hasFile('image')) {
            if (
                $product->image
                && Storage::disk('public')->exists(
                    $product->image
                )
            ) {
                Storage::disk('public')->delete(
                    $product->image
                );
            }

            $validatedData['image'] =
                $request->file('image')->store(
                    'products',
                    'public'
                );
        }

        $product->update($validatedData);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Cập nhật sản phẩm thành công!'
            );
    }

    public function destroy(Product $product)
    {
        if (
            $product->image
            && Storage::disk('public')->exists(
                $product->image
            )
        ) {
            Storage::disk('public')->delete(
                $product->image
            );
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Xóa sản phẩm thành công!'
            );
    }

    // ==========================================
    // VALIDATION SẢN PHẨM
    // ==========================================

    private function productRules(): array
    {
        return [
            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            // Có thể là 20 kg, 18.5 kg...
            'quantity' =>
                'required|numeric|min:0',

            'price' =>
                'required|numeric|min:0',

            'unit' =>
                'required|string|in:kg,g,gói,túi,hộp,chai,lọ,bó,sản phẩm',

            'min_quantity' =>
                'required|numeric|min:0.01',

            'quantity_step' =>
                'required|numeric|min:0.01',

            'category_id' =>
                'required|exists:categories,id',
'image' =>
    'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

'sale_price' =>
    'nullable|numeric|min:0|lt:price',

'sale_start' =>
    'nullable|date',

'sale_end' =>
    'nullable|date|after_or_equal:sale_start',

        ];
    }

    private function productMessages(): array
    {
        return [
            'name.required' =>
                'Vui lòng nhập tên sản phẩm.',

            'quantity.required' =>
                'Vui lòng nhập tồn kho.',

            'quantity.numeric' =>
                'Tồn kho phải là một số.',

            'price.required' =>
                'Vui lòng nhập giá bán.',

            'unit.required' =>
                'Vui lòng chọn đơn vị bán.',

            'unit.in' =>
                'Đơn vị bán không hợp lệ.',

            'min_quantity.required' =>
                'Vui lòng nhập số lượng mua tối thiểu.',

            'quantity_step.required' =>
                'Vui lòng nhập bước tăng số lượng.',

            'category_id.required' =>
                'Vui lòng chọn danh mục.',

            'category_id.exists' =>
                'Danh mục đã chọn không tồn tại.',
                'sale_price.numeric' =>
    'Giá khuyến mãi phải là một số.',

'sale_price.lt' =>
    'Giá khuyến mãi phải nhỏ hơn giá gốc.',

'sale_start.date' =>
    'Ngày bắt đầu khuyến mãi không hợp lệ.',

'sale_end.date' =>
    'Ngày kết thúc khuyến mãi không hợp lệ.',

'sale_end.after_or_equal' =>
    'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }

    /**
     * Kiểm tra quy cách bán.
     *
     * Ví dụ:
     * min = 0.25 kg, step = 0.25 kg.
     * Tồn kho phải ít nhất bằng mức mua tối thiểu
     * nếu sản phẩm còn hàng.
     */
    private function validateSaleRule(
        Request $request
    ): void {
        $quantity =
            (float) $request->quantity;

        $minQuantity =
            (float) $request->min_quantity;

        if (
            $quantity > 0
            && $quantity < $minQuantity
        ) {
            throw ValidationException::withMessages([
                'quantity' =>
                    'Tồn kho phải lớn hơn hoặc bằng mức mua tối thiểu.'
            ]);
        }
    }
    // ==========================================
// 🔥 ADMIN - THIẾT LẬP KHUYẾN MÃI
// ==========================================

public function setPromotion(
    Request $request,
    Product $product
) {
    $request->validate(
        [
            'sale_price' => 'required|numeric|min:0',
            'sale_start' => 'required|date',
            'sale_end' => 'required|date|after:sale_start',
        ],
        [
            'sale_price.required' =>
                'Vui lòng nhập giá khuyến mãi.',

            'sale_price.numeric' =>
                'Giá khuyến mãi phải là số.',

            'sale_start.required' =>
                'Vui lòng chọn thời gian bắt đầu.',

            'sale_end.required' =>
                'Vui lòng chọn thời gian kết thúc.',

            'sale_end.after' =>
                'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ]
    );

    if ((float) $request->sale_price >= (float) $product->price) {
        return back()->with(
            'error',
            'Giá khuyến mãi phải nhỏ hơn giá gốc.'
        );
    }

    $product->sale_price = $request->sale_price;
    $product->sale_start = $request->sale_start;
    $product->sale_end = $request->sale_end;

    $product->save();

    return redirect()
        ->route('admin.products.index')
        ->with(
            'success',
            '🔥 Đã đưa "' .
            $product->name .
            '" lên chương trình khuyến mãi!'
        );
}

// ==========================================
// 🔥 ADMIN - GỠ KHUYẾN MÃI
// ==========================================

public function removePromotion(Product $product)
{
    $product->update([
        'sale_price' => null,
        'sale_start' => null,
        'sale_end' => null,
    ]);

    return redirect()
        ->route('admin.products.index')
        ->with(
            'success',
            'Đã gỡ "' .
            $product->name .
            '" khỏi chương trình khuyến mãi.'
        );
}

    // ==========================================
    // 🔎 GỢI Ý TÌM KIẾM SẢN PHẨM
    // Dùng chung cho Customer và Admin đã đăng nhập
    // ==========================================
    public function searchSuggestions(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));

        if (mb_strlen($keyword) < 2) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->orderByRaw(
                'CASE WHEN name LIKE ? THEN 0 ELSE 1 END',
                [$keyword . '%']
            )
            ->latest('id')
            ->limit(6)
            ->get();

        return response()->json(
            $products->map(function (Product $product) {
                $imageUrl = null;

                if ($product->image) {
                    $imageUrl = str_starts_with($product->image, 'http')
                        ? $product->image
                        : asset(
                            'storage/' .
                            ltrim($product->image, '/')
                        );
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category?->name
                        ?? 'Chưa phân loại',
                    'price' => (float) $product->getCurrentPrice(),
                    'original_price' => (float) $product->price,
                    'on_sale' => $product->isOnSale(),
                    'in_stock' => (float) $product->quantity > 0,
                    'image' => $imageUrl,
                    'url' => route('products.show', $product),
                ];
            })
        );
    }


    // ==========================================
    // KHU VỰC DÀNH CHO USER
    // ==========================================

    public function userIndex(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'description',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        if ($request->stock === 'in_stock') {
            $query->where('quantity', '>', 0);
        } elseif ($request->stock === 'out_of_stock') {
            $query->where('quantity', '<=', 0);
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        $products = $query
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'products.index',
            compact('products', 'categories')
        );
    }

    public function show_normal(Product $product)
{
    return view(
        'products.show',
        compact('product')
    );
}


// ==========================================
// 🔥 SẢN PHẨM KHUYẾN MÃI
// ==========================================

public function promotions()
{
    $products = Product::with('category')
        ->onSale()
        ->latest()
        ->paginate(12);

    return view(
        'products.promotions',
        compact('products')
    );
}


}