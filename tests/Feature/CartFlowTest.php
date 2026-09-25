<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_customer_can_add_product_to_cart_and_view_cart(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $category = Category::create([
            'name' => 'Đặc sản Tây Bắc',
        ]);

        $product = Product::create([
            'name' => 'Thịt trâu gác bếp',
            'description' => 'Sản phẩm dùng để test giỏ hàng',
            'quantity' => 10,
            'price' => 350000,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($customer)
            ->post(route('cart.add', $product));

        $response->assertRedirect(route('cart.index'));

        $this->assertEquals(
            'Thịt trâu gác bếp',
            session('cart.' . $product->id . '.name')
        );

        $this
            ->actingAs($customer)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Thịt trâu gác bếp');
    }

    public function test_guest_cannot_access_cart(): void
    {
        $this
            ->get(route('cart.index'))
            ->assertRedirect(route('login'));
    }
}