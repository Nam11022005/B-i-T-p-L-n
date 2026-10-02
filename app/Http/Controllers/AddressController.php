<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DANH SÁCH ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return redirect()->to(route('profile') . '#shipping-addresses');
    }


    /*
    |--------------------------------------------------------------------------
    | THÊM ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $this->validateAddress(
            $request
        );


        DB::transaction(
            function () use ($data, $request) {

                $userId = Auth::id();


                $hasAddress =
                    UserAddress::query()
                        ->where(
                            'user_id',
                            $userId
                        )
                        ->exists();


                /*
                 * Địa chỉ đầu tiên tự động
                 * trở thành địa chỉ mặc định.
                 */
                $makeDefault =
                    !$hasAddress
                    ||
                    $request->boolean(
                        'is_default'
                    );


                if ($makeDefault) {

                    UserAddress::query()
                        ->where(
                            'user_id',
                            $userId
                        )
                        ->update([
                            'is_default' => false,
                        ]);

                }


                UserAddress::create([
                    ...$data,

                    'user_id' =>
                        $userId,

                    'is_default' =>
                        $makeDefault,
                ]);

            }
        );


        return redirect()
            ->to(route('profile') . '#shipping-addresses')
            ->with(
                'success',
                'Đã thêm địa chỉ giao hàng.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CẬP NHẬT ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        UserAddress $address
    ) {
        $this->authorizeOwner(
            $address
        );


        $data =
            $this->validateAddress(
                $request
            );


        DB::transaction(
            function () use (
                $address,
                $data,
                $request
            ) {

                if (
                    $request->boolean(
                        'is_default'
                    )
                ) {

                    UserAddress::query()
                        ->where(
                            'user_id',
                            Auth::id()
                        )
                        ->whereKeyNot(
                            $address->id
                        )
                        ->update([
                            'is_default' => false,
                        ]);

                }


                $address->update([
                    ...$data,

                    'is_default' =>
                        $request->boolean(
                            'is_default'
                        )
                            ? true
                            : $address->is_default,
                ]);

            }
        );


        return redirect()
            ->to(route('profile') . '#shipping-addresses')
            ->with(
                'success',
                'Đã cập nhật địa chỉ.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | XÓA ĐỊA CHỈ
    |--------------------------------------------------------------------------
    */

    public function destroy(
        UserAddress $address
    ) {
        $this->authorizeOwner(
            $address
        );


        DB::transaction(
            function () use ($address) {

                $wasDefault =
                    $address->is_default;


                $userId =
                    $address->user_id;


                $address->delete();


                /*
                 * Nếu xóa địa chỉ mặc định
                 * thì tự lấy địa chỉ mới nhất
                 * làm mặc định.
                 */
                if ($wasDefault) {

                    $next =
                        UserAddress::query()
                            ->where(
                                'user_id',
                                $userId
                            )
                            ->latest()
                            ->first();


                    if ($next) {

                        $next->update([
                            'is_default' => true,
                        ]);

                    }

                }

            }
        );


        return redirect()
            ->to(route('profile') . '#shipping-addresses')
            ->with(
                'success',
                'Đã xóa địa chỉ.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ĐẶT ĐỊA CHỈ MẶC ĐỊNH
    |--------------------------------------------------------------------------
    */

    public function setDefault(
        UserAddress $address
    ) {
        $this->authorizeOwner(
            $address
        );


        DB::transaction(
            function () use ($address) {

                UserAddress::query()
                    ->where(
                        'user_id',
                        Auth::id()
                    )
                    ->update([
                        'is_default' => false,
                    ]);


                $address->update([
                    'is_default' => true,
                ]);

            }
        );


        return redirect()
            ->to(route('profile') . '#shipping-addresses')
            ->with(
                'success',
                'Đã đặt làm địa chỉ mặc định.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA CHỦ SỞ HỮU
    |--------------------------------------------------------------------------
    */

    private function authorizeOwner(
        UserAddress $address
    ): void {
        abort_unless(
            (int) $address->user_id
                ===
            (int) Auth::id(),
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validateAddress(
        Request $request
    ): array {
        try {
            return $request->validateWithBag('addresses',
                [
                    'label' => [
                        'required',
                        'string',
                        'max:50',
                    ],
    
                    'receiver_name' => [
                        'required',
                        'string',
                        'max:255',
                    ],
    
                    'phone' => [
                        'required',
                        'string',
                        'max:20',
                        'regex:/^[0-9+\-\s]{9,20}$/',
                    ],
    
                    'province' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],
    
                    'district' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],
    
                    'ward' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],
    
                    'address_detail' => [
                        'required',
                        'string',
                        'max:500',
                    ],
                ],
                [
                    'label.required' =>
                        'Vui lòng nhập tên gợi nhớ cho địa chỉ.',
    
                    'receiver_name.required' =>
                        'Vui lòng nhập tên người nhận.',
    
                    'phone.required' =>
                        'Vui lòng nhập số điện thoại.',
    
                    'phone.regex' =>
                        'Số điện thoại không hợp lệ.',
    
                    'address_detail.required' =>
                        'Vui lòng nhập địa chỉ chi tiết.',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $exception) {
            throw $exception->redirectTo(route('profile') . '#shipping-addresses');
        }
    }
}