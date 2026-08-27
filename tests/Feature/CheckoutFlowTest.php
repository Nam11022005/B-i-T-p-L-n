<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_order_from_cart(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $category = Category::create(['name' => 'Điện tử']);
        $product = Product::create([
            'name' => 'Máy tính',
            'description' => 'Laptop test checkout',
            'quantity' => 10,
            'price' => 20000000,
            'category_id' => $category->id,
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product));

        $response = $this->actingAs($customer)->post(route('checkout.place'));

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['user_id' => $customer->id, 'status' => 'pending']);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 1]);
    }
}
