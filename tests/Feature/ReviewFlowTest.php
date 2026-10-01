<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewFlowTest extends TestCase
{
    use RefreshDatabase;


    private function createCustomer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }


    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }


    private function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Đặc sản Tây Bắc',
        ]);


        return Product::create([
            'name' => 'Thịt trâu gác bếp',
            'description' => 'Sản phẩm dùng để test đánh giá.',
            'quantity' => 20,
            'price' => 350000,
            'category_id' => $category->id,
        ]);
    }


    private function createOrder(
        User $customer,
        Product $product,
        string $status = 'delivered'
    ): Order {
        $order = Order::create([
            'user_id' => $customer->id,

            'customer_name' => $customer->name,
            'customer_phone' => '0385742505',
            'shipping_address' => '123 Đường Test, Hà Nội',
            'notes' => null,

            'subtotal' => 350000,
            'shipping_fee' => 25000,
            'discount' => 0,
            'total_price' => 375000,

            'status' => $status,

            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
            'payment_code' => null,

            'shipping_method' => 'standard',
            'voucher_code' => null,
        ]);


        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 350000,
        ]);


        return $order;
    }


    public function test_customer_with_delivered_order_can_review_product(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createProduct();


        $this->createOrder(
            $customer,
            $product,
            'delivered'
        );


        $response = $this
            ->actingAs($customer)
            ->from(
                route(
                    'products.show',
                    $product
                )
            )
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 5,
                    'comment' => 'Sản phẩm rất ngon.',
                ]
            );


        $response
            ->assertRedirect(
                route(
                    'products.show',
                    $product
                )
            )
            ->assertSessionHas(
                'success'
            );


        $this->assertDatabaseHas(
            'reviews',
            [
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Sản phẩm rất ngon.',
            ]
        );
    }


    public function test_customer_without_delivered_order_cannot_review_product(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createProduct();


        $this->createOrder(
            $customer,
            $product,
            'confirmed'
        );


        $response = $this
            ->actingAs($customer)
            ->from(
                route(
                    'products.show',
                    $product
                )
            )
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 5,
                    'comment' => 'Test chưa giao hàng.',
                ]
            );


        $response
            ->assertRedirect(
                route(
                    'products.show',
                    $product
                )
            )
            ->assertSessionHas(
                'error'
            );


        $this->assertDatabaseCount(
            'reviews',
            0
        );
    }


    public function test_review_rating_must_be_between_one_and_five(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createProduct();


        $this->createOrder(
            $customer,
            $product,
            'delivered'
        );


        $response = $this
            ->actingAs($customer)
            ->from(
                route(
                    'products.show',
                    $product
                )
            )
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 6,
                    'comment' => 'Rating không hợp lệ.',
                ]
            );


        $response
            ->assertRedirect(
                route(
                    'products.show',
                    $product
                )
            )
            ->assertSessionHasErrors(
                'rating'
            );


        $this->assertDatabaseCount(
            'reviews',
            0
        );
    }


    public function test_second_review_updates_existing_review_instead_of_creating_duplicate(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createProduct();


        $this->createOrder(
            $customer,
            $product,
            'delivered'
        );


        $this
            ->actingAs($customer)
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 4,
                    'comment' => 'Đánh giá lần đầu.',
                ]
            );


        $this
            ->actingAs($customer)
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 5,
                    'comment' => 'Cập nhật đánh giá.',
                ]
            );


        $this->assertDatabaseCount(
            'reviews',
            1
        );


        $this->assertDatabaseHas(
            'reviews',
            [
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Cập nhật đánh giá.',
            ]
        );


        $this->assertDatabaseMissing(
            'reviews',
            [
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'rating' => 4,
                'comment' => 'Đánh giá lần đầu.',
            ]
        );
    }


    public function test_admin_cannot_submit_product_review(): void
    {
        $admin = $this->createAdmin();

        $product = $this->createProduct();


        $response = $this
            ->actingAs($admin)
            ->from(
                route(
                    'products.show',
                    $product
                )
            )
            ->post(
                route(
                    'reviews.store',
                    $product
                ),
                [
                    'rating' => 5,
                    'comment' => 'Admin review test.',
                ]
            );


        $response
            ->assertRedirect(
                route(
                    'products.show',
                    $product
                )
            )
            ->assertSessionHas(
                'error'
            );


        $this->assertDatabaseCount(
            'reviews',
            0
        );
    }


    public function test_admin_can_delete_product_review(): void
    {
        $customer = $this->createCustomer();

        $admin = $this->createAdmin();

        $product = $this->createProduct();


        $review = Review::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Đánh giá để admin xóa.',
        ]);


        $response = $this
            ->actingAs($admin)
            ->from(
                route(
                    'products.show',
                    $product
                )
            )
            ->delete(
                route(
                    'admin.reviews.destroy',
                    $review
                )
            );


        $response
            ->assertRedirect(
                route(
                    'products.show',
                    $product
                )
            )
            ->assertSessionHas(
                'success'
            );


        $this->assertDatabaseMissing(
            'reviews',
            [
                'id' => $review->id,
            ]
        );
    }
}