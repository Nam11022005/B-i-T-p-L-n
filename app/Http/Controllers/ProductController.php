<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - GHIM SẢN PHẨM
    |--------------------------------------------------------------------------
    */

    public function toggleFeatured(Product $product)
    {
        $product->is_featured =
            !$product->is_featured;

        $product->save();

        return back()->with(
            'success',
            $product->is_featured
                ? '⭐ Đã ghim sản phẩm nổi bật.'
                : 'Đã bỏ ghim sản phẩm nổi bật.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DANH SÁCH SẢN PHẨM
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {

            $search =
                trim($request->search);

            $query->where(
                function ($q) use ($search) {

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

                    if (is_numeric($search)) {

                        $q->orWhere(
                            'id',
                            (int) $search
                        );

                    }

                }
            );

        }

        if ($request->filled('category_id')) {

            $query->where(
                'category_id',
                $request->category_id
            );

        }

        if ($request->stock === 'in_stock') {

            $query->where(
                'quantity',
                '>',
                0
            );

        }
        elseif (
            $request->stock
            ===
            'out_of_stock'
        ) {

            $query->where(
                'quantity',
                '<=',
                0
            );

        }

        if (
            $request->featured
            ===
            'featured'
        ) {

            $query->where(
                'is_featured',
                true
            );

        }
        elseif (
            $request->featured
            ===
            'normal'
        ) {

            $query->where(
                'is_featured',
                false
            );

        }

        $currentPriceSql =
            $this->currentPriceSql();

        if ($request->filled('min_price')) {

            $query->whereRaw(
                $currentPriceSql . ' >= ?',
                [
                    now(),
                    now(),
                    (float) $request->min_price,
                ]
            );

        }

        if ($request->filled('max_price')) {

            $query->whereRaw(
                $currentPriceSql . ' <= ?',
                [
                    now(),
                    now(),
                    (float) $request->max_price,
                ]
            );

        }

        switch ($request->sort) {

            case 'price_asc':

                $query->orderByRaw(
                    $currentPriceSql . ' ASC',
                    [
                        now(),
                        now(),
                    ]
                );

                break;


            case 'price_desc':

                $query->orderByRaw(
                    $currentPriceSql . ' DESC',
                    [
                        now(),
                        now(),
                    ]
                );

                break;


            case 'name_asc':

                $query->orderBy(
                    'name'
                );

                break;


            case 'name_desc':

                $query->orderByDesc(
                    'name'
                );

                break;


            case 'stock_asc':

                $query->orderBy(
                    'quantity'
                );

                break;


            case 'stock_desc':

                $query->orderByDesc(
                    'quantity'
                );

                break;


            default:

                $query->latest();

                break;
        }

        $products =
            $query
                ->paginate(10)
                ->withQueryString();

        $categories =
            Category::orderBy('name')
                ->get();

        return view(
            'admin.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories =
            Category::orderBy('name')
                ->get();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validatedData =
            $request->validate(
                $this->productRules(),
                $this->productMessages()
            );

        $this->validateSaleRule(
            $request
        );

        $this->validateGalleryLimit(
            $request
        );

        unset(
            $validatedData['gallery_images'],
            $validatedData['remove_gallery_images']
        );

        /*
         * Ảnh đại diện
         */
        if ($request->hasFile('image')) {

            $validatedData['image'] =
                $request
                    ->file('image')
                    ->store(
                        'products',
                        'public'
                    );

        }

        $product =
            Product::create(
                $validatedData
            );

        /*
         * Nhiều ảnh chi tiết
         */
        $this->storeGalleryImages(
            $request,
            $product
        );

        return redirect()
            ->route(
                'admin.products.index'
            )
            ->with(
                'success',
                'Thêm sản phẩm thành công!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        $product->load('images');

        return view(
            'admin.products.show',
            compact('product')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories =
            Category::orderBy('name')
                ->get();

        $product->load('images');

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $validatedData =
            $request->validate(
                $this->productRules(),
                $this->productMessages()
            );

        $this->validateSaleRule(
            $request
        );

        $this->validateGalleryLimit(
            $request,
            $product
        );

        unset(
            $validatedData['gallery_images'],
            $validatedData['remove_gallery_images']
        );

        $oldMainImage =
            $product->image;

        /*
         * Thay ảnh đại diện
         */
        if ($request->hasFile('image')) {

            $validatedData['image'] =
                $request
                    ->file('image')
                    ->store(
                        'products',
                        'public'
                    );

        }

        $product->update(
            $validatedData
        );

        /*
         * Sau khi update thành công
         * mới xóa ảnh đại diện cũ.
         */
        if (
            $request->hasFile('image')
            &&
            $oldMainImage
            &&
            Storage::disk('public')
                ->exists($oldMainImage)
        ) {

            Storage::disk('public')
                ->delete(
                    $oldMainImage
                );

        }

        /*
         * Xóa ảnh gallery được chọn
         */
        $this->removeSelectedGalleryImages(
            $request,
            $product
        );

        /*
         * Thêm ảnh gallery mới
         */
        $this->storeGalleryImages(
            $request,
            $product
        );

        return redirect()
            ->route(
                'admin.products.index'
            )
            ->with(
                'success',
                'Cập nhật sản phẩm thành công!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $product->load('images');

        /*
         * Xóa ảnh đại diện
         */
        if (
            $product->image
            &&
            Storage::disk('public')
                ->exists($product->image)
        ) {

            Storage::disk('public')
                ->delete(
                    $product->image
                );

        }

        /*
         * Xóa toàn bộ ảnh chi tiết
         */
        foreach (
            $product->images
            as
            $galleryImage
        ) {

            if (
                $galleryImage->path
                &&
                Storage::disk('public')
                    ->exists(
                        $galleryImage->path
                    )
            ) {

                Storage::disk('public')
                    ->delete(
                        $galleryImage->path
                    );

            }

        }

        $product->delete();

        return redirect()
            ->route(
                'admin.products.index'
            )
            ->with(
                'success',
                'Xóa sản phẩm thành công!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - THIẾT LẬP KHUYẾN MÃI
    |--------------------------------------------------------------------------
    */

    public function setPromotion(
        Request $request,
        Product $product
    ) {
        $request->validate(
            [
                'sale_price' =>
                    'required|numeric|min:0',

                'sale_start' =>
                    'required|date',

                'sale_end' =>
                    'required|date|after:sale_start',
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

        if (
            (float) $request->sale_price
            >=
            (float) $product->price
        ) {

            return back()->with(
                'error',
                'Giá khuyến mãi phải nhỏ hơn giá gốc.'
            );

        }

        $product->update([
            'sale_price' =>
                $request->sale_price,

            'sale_start' =>
                $request->sale_start,

            'sale_end' =>
                $request->sale_end,
        ]);

        return redirect()
            ->route(
                'admin.products.index'
            )
            ->with(
                'success',
                '🔥 Đã đưa "' .
                $product->name .
                '" lên chương trình khuyến mãi!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - GỠ KHUYẾN MÃI
    |--------------------------------------------------------------------------
    */

    public function removePromotion(
        Product $product
    ) {
        $product->update([
            'sale_price' => null,
            'sale_start' => null,
            'sale_end' => null,
        ]);

        return redirect()
            ->route(
                'admin.products.index'
            )
            ->with(
                'success',
                'Đã gỡ "' .
                $product->name .
                '" khỏi chương trình khuyến mãi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GỢI Ý TÌM KIẾM
    |--------------------------------------------------------------------------
    */

    public function searchSuggestions(
        Request $request
    ) {
        $keyword =
            trim(
                (string)
                $request->query(
                    'q',
                    ''
                )
            );

        if (
            mb_strlen($keyword)
            <
            2
        ) {
            return response()->json([]);
        }

        $products =
            Product::with('category')

                ->where(
                    function ($query)
                    use ($keyword) {

                        $query->where(
                            'name',
                            'like',
                            '%' . $keyword . '%'
                        )

                        ->orWhere(
                            'description',
                            'like',
                            '%' . $keyword . '%'
                        );

                    }
                )

                ->orderByRaw(
                    'CASE WHEN name LIKE ? THEN 0 ELSE 1 END',
                    [
                        $keyword . '%'
                    ]
                )

                ->latest('id')
                ->limit(6)
                ->get();

        return response()->json(

            $products->map(
                function (
                    Product $product
                ) {

                    $imageUrl = null;

                    if ($product->image) {

                        $imageUrl =
                            str_starts_with(
                                $product->image,
                                'http'
                            )

                            ? $product->image

                            : asset(
                                'storage/'
                                .
                                ltrim(
                                    $product->image,
                                    '/'
                                )
                            );

                    }

                    return [
                        'id' =>
                            $product->id,

                        'name' =>
                            $product->name,

                        'category' =>
                            $product
                                ->category
                                ?->name
                            ??
                            'Chưa phân loại',

                        'price' =>
                            (float)
                            $product
                                ->getCurrentPrice(),

                        'original_price' =>
                            (float)
                            $product->price,

                        'on_sale' =>
                            $product->isOnSale(),

                        'in_stock' =>
                            (float)
                            $product->quantity
                            >
                            0,

                        'image' =>
                            $imageUrl,

                        'url' =>
                            route(
                                'products.show',
                                $product
                            ),
                    ];

                }
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - DANH SÁCH
    |--------------------------------------------------------------------------
    */

    public function userIndex(
        Request $request
    ) {
        $query =
            Product::with('category');

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );

            $query->where(
                function ($q)
                use ($search) {

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

                }
            );

        }

        if (
            $request->filled(
                'category_id'
            )
        ) {

            $query->where(
                'category_id',
                $request->category_id
            );

        }

        $currentPriceSql =
            $this->currentPriceSql();

        if (
            $request->filled(
                'min_price'
            )
        ) {

            $query->whereRaw(
                $currentPriceSql . ' >= ?',
                [
                    now(),
                    now(),
                    (float)
                    $request->min_price,
                ]
            );

        }

        if (
            $request->filled(
                'max_price'
            )
        ) {

            $query->whereRaw(
                $currentPriceSql . ' <= ?',
                [
                    now(),
                    now(),
                    (float)
                    $request->max_price,
                ]
            );

        }

        if (
            $request->stock
            ===
            'in_stock'
        ) {

            $query->where(
                'quantity',
                '>',
                0
            );

        }
        elseif (
            $request->stock
            ===
            'out_of_stock'
        ) {

            $query->where(
                'quantity',
                '<=',
                0
            );

        }

        switch ($request->sort) {

            case 'price_asc':

                $query->orderByRaw(
                    $currentPriceSql . ' ASC',
                    [
                        now(),
                        now(),
                    ]
                );

                break;


            case 'price_desc':

                $query->orderByRaw(
                    $currentPriceSql . ' DESC',
                    [
                        now(),
                        now(),
                    ]
                );

                break;


            case 'name_asc':

                $query->orderBy(
                    'name'
                );

                break;


            case 'name_desc':

                $query->orderByDesc(
                    'name'
                );

                break;


            default:

                $query->latest();

                break;
        }

        $products =
            $query
                ->paginate(20)
                ->withQueryString();

        $categories =
            Category::orderBy('name')
                ->get();

        return view(
            'products.index',
            compact(
                'products',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - CHI TIẾT
    |--------------------------------------------------------------------------
    */

    public function show_normal(
        Product $product
    ) {
        $product->load([
            'category',
            'images',
        ]);

        return view(
            'products.show',
            compact('product')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - KHUYẾN MÃI
    |--------------------------------------------------------------------------
    */

    public function promotions()
    {
        $now = now();

        $products =
            Product::with('category')

                ->whereNotNull(
                    'sale_price'
                )

                ->whereColumn(
                    'sale_price',
                    '<',
                    'price'
                )

                ->where(
                    function ($query)
                    use ($now) {

                        $query
                            ->whereNull(
                                'sale_start'
                            )

                            ->orWhere(
                                'sale_start',
                                '<=',
                                $now
                            );

                    }
                )

                ->where(
                    function ($query)
                    use ($now) {

                        $query
                            ->whereNull(
                                'sale_end'
                            )

                            ->orWhere(
                                'sale_end',
                                '>=',
                                $now
                            );

                    }
                )

                ->latest()

                ->paginate(12);

        return view(
            'products.promotions',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function productRules(): array
    {
        return [
            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

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

            /*
             * Ảnh đại diện
             */
            'image' =>
                'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            /*
             * Nhiều ảnh chi tiết
             */
            'gallery_images' =>
                'nullable|array|max:8',

            'gallery_images.*' =>
                'image|mimes:jpeg,png,jpg,webp|max:5120',

            /*
             * ID ảnh cần xóa khi Edit
             */
            'remove_gallery_images' =>
                'nullable|array',

            'remove_gallery_images.*' =>
                'integer',

            /*
             * Khuyến mãi
             */
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


            /*
             * Ảnh đại diện
             */
            'image.image' =>
                'Ảnh đại diện phải là một file ảnh.',

            'image.mimes' =>
                'Ảnh đại diện chỉ hỗ trợ JPG, JPEG, PNG hoặc WEBP.',

            'image.max' =>
                'Ảnh đại diện không được lớn hơn 5MB.',


            /*
             * Gallery
             */
            'gallery_images.array' =>
                'Danh sách ảnh chi tiết không hợp lệ.',

            'gallery_images.max' =>
                'Mỗi lần chỉ được chọn tối đa 8 ảnh chi tiết.',

            'gallery_images.*.image' =>
                'Mỗi ảnh chi tiết phải là một file ảnh.',

            'gallery_images.*.mimes' =>
                'Ảnh chi tiết chỉ hỗ trợ JPG, JPEG, PNG hoặc WEBP.',

            'gallery_images.*.max' =>
                'Mỗi ảnh chi tiết không được lớn hơn 5MB.',


            /*
             * Sale
             */
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

    /*
    |--------------------------------------------------------------------------
    | SQL GIÁ HIỆN TẠI
    |--------------------------------------------------------------------------
    */

    private function currentPriceSql(): string
    {
        return "
            CASE

                WHEN
                    sale_price IS NOT NULL

                    AND
                    sale_price < price

                    AND
                    (
                        sale_start IS NULL
                        OR
                        sale_start <= ?
                    )

                    AND
                    (
                        sale_end IS NULL
                        OR
                        sale_end >= ?
                    )

                THEN
                    sale_price

                ELSE
                    price

            END
        ";
    }

    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA QUY CÁCH BÁN
    |--------------------------------------------------------------------------
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
            &&
            $quantity < $minQuantity
        ) {

            throw ValidationException::withMessages([
                'quantity' =>
                    'Tồn kho phải lớn hơn hoặc bằng mức mua tối thiểu.',
            ]);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA TỐI ĐA 8 ẢNH CHI TIẾT
    |--------------------------------------------------------------------------
    */

    private function validateGalleryLimit(
        Request $request,
        ?Product $product = null
    ): void {
        $newImageCount =
            count(
                $request->file(
                    'gallery_images',
                    []
                )
            );

        $existingCount =
            $product
                ? $product
                    ->images()
                    ->count()
                : 0;

        $removeIds =
            collect(
                $request->input(
                    'remove_gallery_images',
                    []
                )
            )

            ->map(
                fn ($id) =>
                    (int) $id
            )

            ->filter()

            ->unique();

        $validRemoveCount = 0;

        if (
            $product
            &&
            $removeIds->isNotEmpty()
        ) {

            $validRemoveCount =
                $product
                    ->images()

                    ->whereIn(
                        'id',
                        $removeIds
                    )

                    ->count();

        }

        $finalCount =
            $existingCount
            -
            $validRemoveCount
            +
            $newImageCount;

        if ($finalCount > 8) {

            throw ValidationException::withMessages([
                'gallery_images' =>
                    'Mỗi sản phẩm được lưu tối đa 8 ảnh chi tiết.',
            ]);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | LƯU ẢNH CHI TIẾT
    |--------------------------------------------------------------------------
    */

    private function storeGalleryImages(
        Request $request,
        Product $product
    ): void {
        if (
            !$request->hasFile(
                'gallery_images'
            )
        ) {
            return;
        }

        $startSortOrder =
            (int)
            (
                $product
                    ->images()
                    ->max('sort_order')
                ??
                -1
            )
            +
            1;

        foreach (
            $request->file(
                'gallery_images',
                []
            )
            as
            $index => $file
        ) {

            $path =
                $file->store(
                    'products/gallery',
                    'public'
                );

            $product
                ->images()
                ->create([
                    'path' =>
                        $path,

                    'sort_order' =>
                        $startSortOrder
                        +
                        $index,
                ]);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | XÓA ẢNH CHI TIẾT ĐƯỢC ADMIN CHỌN
    |--------------------------------------------------------------------------
    */

    private function removeSelectedGalleryImages(
        Request $request,
        Product $product
    ): void {
        $removeIds =
            collect(
                $request->input(
                    'remove_gallery_images',
                    []
                )
            )

            ->map(
                fn ($id) =>
                    (int) $id
            )

            ->filter()

            ->unique();

        if ($removeIds->isEmpty()) {
            return;
        }

        /*
         * Chỉ lấy ảnh thuộc đúng sản phẩm
         * để tránh xóa ảnh sản phẩm khác.
         */
        $images =
            $product
                ->images()

                ->whereIn(
                    'id',
                    $removeIds
                )

                ->get();

        foreach (
            $images
            as
            $galleryImage
        ) {

            if (
                $galleryImage->path
                &&
                Storage::disk('public')
                    ->exists(
                        $galleryImage->path
                    )
            ) {

                Storage::disk('public')
                    ->delete(
                        $galleryImage->path
                    );

            }

            $galleryImage->delete();
        }
    }
}