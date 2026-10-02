<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressFlowTest extends TestCase
{
    use RefreshDatabase;


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER CÓ THỂ QUẢN LÝ ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function test_verified_customer_can_manage_addresses(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | 1. THÊM ĐỊA CHỈ ĐẦU TIÊN
        | Địa chỉ đầu tiên phải tự động thành mặc định
        |--------------------------------------------------------------------------
        */

        $response = $this
            ->actingAs($customer)
            ->post(
                route('addresses.store'),
                [
                    'label' => 'Nhà',

                    'receiver_name' =>
                        'Nguyễn Văn Test',

                    'phone' =>
                        '0912345678',

                    'province' =>
                        'Hà Nội',

                    'district' =>
                        'Cầu Giấy',

                    'ward' =>
                        'Dịch Vọng',

                    'address_detail' =>
                        'Số 12 đường Xuân Thủy',
                ]
            );


        $response
            ->assertRedirect(
                route('profile') . '#shipping-addresses'
            )
            ->assertSessionHas('success');


        $this->assertDatabaseHas(
            'user_addresses',
            [
                'user_id' =>
                    $customer->id,

                'label' =>
                    'Nhà',

                'receiver_name' =>
                    'Nguyễn Văn Test',

                'district' =>
                    'Cầu Giấy',

                'is_default' =>
                    1,
            ]
        );


        $firstAddress =
            UserAddress::query()
                ->where(
                    'user_id',
                    $customer->id
                )
                ->firstOrFail();


        $this->assertTrue(
            $firstAddress->is_default
        );


        $this->assertSame(
            'Số 12 đường Xuân Thủy, Dịch Vọng, Cầu Giấy, Hà Nội',
            $firstAddress->full_address
        );


        /*
        |--------------------------------------------------------------------------
        | 2. THÊM ĐỊA CHỈ THỨ HAI
        | Không chọn mặc định
        |--------------------------------------------------------------------------
        */

        $response = $this
            ->actingAs($customer)
            ->post(
                route('addresses.store'),
                [
                    'label' =>
                        'Công ty',

                    'receiver_name' =>
                        'Nguyễn Văn Test',

                    'phone' =>
                        '0987654321',

                    'province' =>
                        'Hà Nội',

                    'district' =>
                        'Nam Từ Liêm',

                    'ward' =>
                        'Mỹ Đình 1',

                    'address_detail' =>
                        'Số 88 đường Mỹ Đình',
                ]
            );


        $response
            ->assertRedirect(
                route('profile') . '#shipping-addresses'
            );


        $secondAddress =
            UserAddress::query()
                ->where(
                    'user_id',
                    $customer->id
                )
                ->where(
                    'label',
                    'Công ty'
                )
                ->firstOrFail();


        $this->assertFalse(
            $secondAddress->is_default
        );


        /*
        |--------------------------------------------------------------------------
        | 3. ĐẶT ĐỊA CHỈ THỨ HAI LÀM MẶC ĐỊNH
        |--------------------------------------------------------------------------
        */

        $response = $this
            ->actingAs($customer)
            ->patch(
                route(
                    'addresses.default',
                    $secondAddress
                )
            );


        $response
            ->assertRedirect(
                route('profile') . '#shipping-addresses'
            )
            ->assertSessionHas('success');


        $firstAddress->refresh();
        $secondAddress->refresh();


        $this->assertFalse(
            $firstAddress->is_default
        );


        $this->assertTrue(
            $secondAddress->is_default
        );


        /*
        |--------------------------------------------------------------------------
        | 4. SỬA ĐỊA CHỈ ĐẦU TIÊN
        |--------------------------------------------------------------------------
        */

        $response = $this
            ->actingAs($customer)
            ->put(
                route(
                    'addresses.update',
                    $firstAddress
                ),
                [
                    'label' =>
                        'Nhà bố mẹ',

                    'receiver_name' =>
                        'Nguyễn Văn Test',

                    'phone' =>
                        '0912345678',

                    'province' =>
                        'Hà Nội',

                    'district' =>
                        'Nam Từ Liêm',

                    'ward' =>
                        'Mễ Trì',

                    'address_detail' =>
                        'Số 20 đường Mễ Trì',
                ]
            );


        $response
            ->assertRedirect(
                route('profile') . '#shipping-addresses'
            )
            ->assertSessionHas('success');


        $this->assertDatabaseHas(
            'user_addresses',
            [
                'id' =>
                    $firstAddress->id,

                'label' =>
                    'Nhà bố mẹ',

                'district' =>
                    'Nam Từ Liêm',

                'ward' =>
                    'Mễ Trì',

                'address_detail' =>
                    'Số 20 đường Mễ Trì',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 5. XÓA ĐỊA CHỈ MẶC ĐỊNH
        | Địa chỉ còn lại phải tự thành mặc định
        |--------------------------------------------------------------------------
        */

        $response = $this
            ->actingAs($customer)
            ->delete(
                route(
                    'addresses.destroy',
                    $secondAddress
                )
            );


        $response
            ->assertRedirect(
                route('profile') . '#shipping-addresses'
            )
            ->assertSessionHas('success');


        $this->assertDatabaseMissing(
            'user_addresses',
            [
                'id' =>
                    $secondAddress->id,
            ]
        );


        $firstAddress->refresh();


        $this->assertTrue(
            $firstAddress->is_default
        );


        $this->assertDatabaseHas(
            'user_addresses',
            [
                'id' =>
                    $firstAddress->id,

                'is_default' =>
                    1,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER KHÔNG ĐƯỢC SỬA ĐỊA CHỈ CỦA USER KHÁC
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_manage_another_users_address(): void
    {
        $owner = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);


        $otherCustomer =
            User::factory()->create([
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);


        $address =
            UserAddress::create([
                'user_id' =>
                    $owner->id,

                'label' =>
                    'Nhà',

                'receiver_name' =>
                    'Chủ địa chỉ',

                'phone' =>
                    '0911111111',

                'province' =>
                    'Hà Nội',

                'district' =>
                    'Cầu Giấy',

                'ward' =>
                    'Dịch Vọng',

                'address_detail' =>
                    'Số 10 đường Test',

                'is_default' =>
                    true,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Không được sửa
        |--------------------------------------------------------------------------
        */

        $this
            ->actingAs($otherCustomer)
            ->put(
                route(
                    'addresses.update',
                    $address
                ),
                [
                    'label' =>
                        'Đã chiếm',

                    'receiver_name' =>
                        'Người khác',

                    'phone' =>
                        '0999999999',

                    'province' =>
                        'Hà Nội',

                    'district' =>
                        'Ba Đình',

                    'ward' =>
                        'Điện Biên',

                    'address_detail' =>
                        'Địa chỉ không hợp lệ',
                ]
            )
            ->assertForbidden();


        /*
        |--------------------------------------------------------------------------
        | Không được đặt mặc định
        |--------------------------------------------------------------------------
        */

        $this
            ->actingAs($otherCustomer)
            ->patch(
                route(
                    'addresses.default',
                    $address
                )
            )
            ->assertForbidden();


        /*
        |--------------------------------------------------------------------------
        | Không được xóa
        |--------------------------------------------------------------------------
        */

        $this
            ->actingAs($otherCustomer)
            ->delete(
                route(
                    'addresses.destroy',
                    $address
                )
            )
            ->assertForbidden();


        /*
        |--------------------------------------------------------------------------
        | Dữ liệu gốc vẫn còn nguyên
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseHas(
            'user_addresses',
            [
                'id' =>
                    $address->id,

                'user_id' =>
                    $owner->id,

                'label' =>
                    'Nhà',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER CHƯA XÁC THỰC EMAIL KHÔNG ĐƯỢC VÀO SỔ ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function test_unverified_customer_is_redirected_from_addresses(): void
    {
        $customer =
            User::factory()
                ->unverified()
                ->create([
                    'role' => 'customer',
                ]);


        $this
            ->actingAs($customer)
            ->get(
                route('addresses.index')
            )
            ->assertRedirect(
                route(
                    'verification.notice'
                )
            );
    }

    public function test_profile_contains_only_own_addresses_and_old_url_redirects(): void
    {
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $other = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        foreach ([$customer, $other] as $owner) {
            UserAddress::create([
                'user_id' => $owner->id, 'label' => 'Nhà', 'receiver_name' => $owner->name,
                'phone' => '0912345678', 'address_detail' => 'Unique address for user '.$owner->id,
                'is_default' => true,
            ]);
        }
        $this->actingAs($customer)->get(route('profile'))->assertOk()
            ->assertSee('id="shipping-addresses"', false)
            ->assertSee('Unique address for user '.$customer->id)
            ->assertDontSee('Unique address for user '.$other->id)
            ->assertSee('Thêm địa chỉ mới')->assertSee('Sửa địa chỉ')
            ->assertDontSee('Địa chỉ của tôi');
        $this->get(route('addresses.index'))->assertRedirect(route('profile').'#shipping-addresses');
    }

    public function test_address_errors_are_kept_separate_on_profile(): void
    {
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $this->actingAs($customer)->from(route('profile'))->post(route('addresses.store'), [
            'address_form' => 'new', 'label' => 'Nhà thử', 'phone' => 'invalid',
        ])->assertRedirect(route('profile').'#shipping-addresses')->assertSessionHasErrors(['phone', 'receiver_name'], null, 'addresses');
        $this->get(route('profile'))->assertOk()->assertSee('Số điện thoại không hợp lệ.')
            ->assertSee('value="Nhà thử"', false);
        $this->assertDatabaseCount('user_addresses', 0);
    }
}