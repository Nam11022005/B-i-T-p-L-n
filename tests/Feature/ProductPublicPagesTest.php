<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPublicPagesTest extends TestCase
{
    use RefreshDatabase;

   public function test_guest_can_view_public_product_listing_and_detail_pages(): void
{
    $category = Category::create([
        'name' => 'Đặc sản Tây Bắc',
    ]);

    $product = Product::create([
        'name' => 'Thịt trâu gác bếp',
        'description' => 'Đặc sản Tây Bắc dùng để test',
        'quantity' => 10,
        'price' => 350000,
        'category_id' => $category->id,
    ]);

    $this
        ->get(route('products.index'))
        ->assertOk()
        ->assertViewIs('products.index')
        ->assertSee('Thịt trâu gác bếp');

    $this
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertViewIs('products.show')
        ->assertSee('Thịt trâu gác bếp');
}

    public function test_customer_cannot_access_create_product_page(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user)
            ->get('/products/create')
            ->assertNotFound();
    }

    public function test_admin_can_access_product_management_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Điện tử']);

        $this->actingAs($admin)
            ->get(route('admin.products.create'))
            ->assertOk();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Laptop admin',
            'description' => 'Sản phẩm tạo bởi admin',
            'quantity' => 7,
            'price' => 18000000,
            'category_id' => $category->id,
            'unit' => 'kg',
            'min_quantity' => 1,
            'quantity_step' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Laptop admin']);
    }
}
