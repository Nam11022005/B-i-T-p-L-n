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

    public function test_weight_based_products_require_a_practical_minimum_in_cart(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $category = Category::create(['name' => 'Đặc sản khối lượng']);
        $product = Product::create([
            'name' => 'Thịt lợn gác bếp',
            'description' => 'Sản phẩm test ngưỡng khối lượng',
            'quantity' => 10,
            'price' => 350000,
            'category_id' => $category->id,
            'unit' => 'kg',
            'min_quantity' => 0.1,
            'quantity_step' => 0.1,
        ]);

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 0.1])
            ->assertRedirect()
            ->assertSessionHas('error', 'Sản phẩm "Thịt lợn gác bếp" phải mua tối thiểu 0.5 kg và tăng theo bước 0.25.');

        $this->assertNull(session('cart.' . $product->id));

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 0.5])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('success');

        $this->assertSame(0.5, (float) session('cart.' . $product->id . '.quantity'));

        $this->actingAs($customer)
            ->patch(route('cart.update', $product->id), ['quantity' => 0.1])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame(0.5, (float) session('cart.' . $product->id . '.quantity'));
    }

    public function test_gram_products_require_at_least_one_hundred_grams(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $category = Category::create(['name' => 'Đặc sản gram']);
        $product = Product::create([
            'name' => 'Trà Shan Tuyết đóng gói',
            'quantity' => 1000,
            'price' => 150000,
            'category_id' => $category->id,
            'unit' => 'g',
            'min_quantity' => 10,
            'quantity_step' => 10,
        ]);

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 99])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertNull(session('cart.' . $product->id));

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 100])
            ->assertRedirect(route('cart.index'));

        $this->assertSame(100.0, (float) session('cart.' . $product->id . '.quantity'));
    }

    public function test_checkout_rejects_a_legacy_weight_quantity_below_the_minimum(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $category = Category::create(['name' => 'Đặc sản checkout']);
        $product = Product::create([
            'name' => 'Thịt bò gác bếp',
            'quantity' => 10,
            'price' => 400000,
            'category_id' => $category->id,
            'unit' => 'kg',
            'min_quantity' => 0.1,
            'quantity_step' => 0.1,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 0.1,
                'price' => $product->price,
                'unit' => 'kg',
            ],
        ]);

        $this->actingAs($customer)
            ->post(route('checkout.process'), [
                'customer_name' => $customer->name,
                'customer_phone' => '0912345678',
                'shipping_address' => 'Địa chỉ test',
                'shipping_method' => 'standard',
                'payment_method' => 'cod',
            ])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
    }
}
