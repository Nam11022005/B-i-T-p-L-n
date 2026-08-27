<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_product_to_cart_and_view_cart(): void
    {
        $category = Category::create(['name' => 'Điện tử']);
        $product = Product::create([
            'name' => 'Laptop test',
            'description' => 'Laptop cho test',
            'quantity' => 10,
            'price' => 15000000,
            'category_id' => $category->id,
        ]);

        $response = $this->post(route('cart.add', $product));

        $response->assertRedirect(route('cart.index'));
        $this->assertEquals('Laptop test', session('cart.' . $product->id . '.name'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Laptop test');
    }
}
