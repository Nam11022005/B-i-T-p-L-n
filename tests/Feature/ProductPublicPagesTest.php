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

    public function test_user_can_view_public_product_listing_and_detail_pages(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Điện tử']);
        $product = Product::create([
            'name' => 'Laptop test',
            'description' => 'Mô tả mẫu',
            'quantity' => 10,
            'price' => 15000000,
            'category_id' => $category->id,
        ]);

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk()
            ->assertViewIs('products.index');

        $this->actingAs($user)
            ->get(route('products.show', $product))
            ->assertOk()
            ->assertViewIs('products.show');
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
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Laptop admin']);
    }
}
