<?php

namespace Tests\Feature;

use App\Models\{User, Order, OrderItem, Product, Category, Voucher, OrderStatusHistory};
use App\Services\ExpireBankOrders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpireBankOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function order(array $attributes = []): Order
    {
        $user = User::factory()->create();
        return Order::create(array_merge([
            'user_id' => $user->id, 'customer_name' => $user->name, 'customer_phone' => '0912345678',
            'shipping_address' => 'Hà Nội', 'subtotal' => 100000, 'shipping_fee' => 0,
            'discount' => 0, 'total_price' => 100000, 'status' => 'pending',
            'payment_method' => 'bank', 'payment_status' => 'pending_confirmation',
            'shipping_method' => 'standard', 'payment_expires_at' => now()->subMinute(),
        ], $attributes));
    }

    public function test_command_restores_stock_and_voucher_once_without_page_visits(): void
    {
        $voucher = Voucher::create(['code' => 'EXPIRE', 'name' => 'Test', 'type' => 'fixed', 'value' => 1000, 'used_count' => 1]);
        $order = $this->order(['voucher_code' => $voucher->code]);
        $category = Category::create(['name' => 'Rau']);
        $product = Product::create(['name' => 'Rau', 'category_id' => $category->id, 'quantity' => 2, 'price' => 100000, 'unit' => 'kg']);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 0.25, 'price' => 100000]);
        $this->artisan('orders:expire-bank')->assertSuccessful();
        $this->artisan('orders:expire-bank')->assertSuccessful();
        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame('unpaid', $order->fresh()->payment_status);
        $this->assertEquals(2.25, $product->fresh()->quantity);
        $this->assertEquals(0, $voucher->fresh()->used_count);
        $this->assertEquals(1, OrderStatusHistory::where('order_id', $order->id)->count());
    }

    public function test_paid_unexpired_non_bank_and_shipping_orders_are_preserved(): void
    {
        foreach ([['payment_status' => 'paid'], ['status' => 'shipped'], ['status' => 'delivered'],
            ['status' => 'cancelled'], ['payment_method' => 'cod'], ['payment_method' => 'wallet'],
            ['payment_expires_at' => now()->addMinute()], ['payment_expires_at' => null]] as $attributes) {
            $order = $this->order($attributes);
            $this->assertFalse(app(ExpireBankOrders::class)->expire($order->id));
            $this->assertSame($order->status, $order->fresh()->status);
        }
        $this->assertDatabaseCount('order_status_histories', 0);
    }

    public function test_expiry_rechecks_payment_saved_after_candidate_was_selected(): void
    {
        $order = $this->order();
        Order::whereKey($order->id)->update(['payment_status' => 'paid']);
        $this->assertFalse(app(ExpireBankOrders::class)->expire($order->id));
        $this->assertSame('pending', $order->fresh()->status);
    }
}
