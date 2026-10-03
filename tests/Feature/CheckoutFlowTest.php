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
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $category = Category::create([
            'name' => 'Đặc sản Tây Bắc',
        ]);

        $product = Product::create([
            'name' => 'Thịt trâu gác bếp',
            'description' => 'Sản phẩm test checkout',
            'quantity' => 10,
            'price' => 350000,
            'category_id' => $category->id,
        ]);

        $this
            ->actingAs($customer)
            ->post(route('cart.add', $product));

        $response = $this
    ->actingAs($customer)
    ->post(route('checkout.process'), [
        'customer_name' => 'Nguyen Van Test',
        'customer_phone' => '0912345678',
        'shipping_address' => '123 Duong Test, Ha Noi',
        'notes' => 'Don hang test',
        'shipping_method' => 'standard',
        'payment_method' => 'cod',
    ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }


    public function test_customer_can_pay_for_an_order_with_wallet_balance(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'wallet_balance' => 500000,
        ]);

        $category = Category::create(['name' => 'Đặc sản ví']);

        $product = Product::create([
            'name' => 'Mắc khén test ví',
            'description' => 'Sản phẩm test thanh toán ví',
            'quantity' => 10,
            'price' => 350000,
            'category_id' => $category->id,
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product));

        $this
            ->actingAs($customer)
            ->post(route('checkout.process'), [
                'customer_name' => 'Nguyen Van Test',
                'customer_phone' => '0912345678',
                'shipping_address' => '123 Duong Test, Ha Noi',
                'shipping_method' => 'standard',
                'payment_method' => 'wallet',
            ])
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'total_price' => 375000,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 125000,
        ]);

        $this->assertDatabaseHas('wallet_transactions', [
            'user_id' => $customer->id,
            'type' => 'payment',
            'status' => 'completed',
            'amount' => 375000,
        ]);
    }
}
