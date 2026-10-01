<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()
            ->paginate(10);

        return view(
            'admin.vouchers.index',
            compact('vouchers')
        );
    }


    public function create()
    {
        return view('admin.vouchers.create');
    }


    public function store(Request $request)
    {
        $data = $this->validateVoucher($request);

        $data['code'] =
            strtoupper(trim($data['code']));

        $data['is_active'] =
            $request->boolean('is_active');


        Voucher::create($data);


        return redirect()
            ->route('admin.vouchers.index')
            ->with(
                'success',
                '🎟️ Thêm voucher thành công!'
            );
    }


    public function edit(Voucher $voucher)
    {
        return view(
            'admin.vouchers.edit',
            compact('voucher')
        );
    }


    public function update(
        Request $request,
        Voucher $voucher
    ) {
        $data = $this->validateVoucher(
            $request,
            $voucher
        );

        $data['code'] =
            strtoupper(trim($data['code']));

        $data['is_active'] =
            $request->boolean('is_active');


        $voucher->update($data);


        return redirect()
            ->route('admin.vouchers.index')
            ->with(
                'success',
                '✅ Cập nhật voucher thành công!'
            );
    }


    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()
            ->route('admin.vouchers.index')
            ->with(
                'success',
                '🗑️ Đã xóa voucher!'
            );
    }


    private function validateVoucher(
        Request $request,
        ?Voucher $voucher = null
    ): array {
        return $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',

                Rule::unique('vouchers', 'code')
                    ->ignore($voucher?->id),
            ],

            'name' =>
                'required|string|max:255',

            'type' =>
                'required|in:percent,fixed,shipping',

            'value' =>
                'required|numeric|min:0',

            'min_order_value' =>
                'required|numeric|min:0',

            'max_discount' =>
                'nullable|numeric|min:0',

            'usage_limit' =>
                'nullable|integer|min:1',

            'starts_at' =>
                'nullable|date',

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],
        ], [
            'code.required' =>
                'Vui lòng nhập mã voucher.',

            'code.unique' =>
                'Mã voucher này đã tồn tại.',

            'name.required' =>
                'Vui lòng nhập tên voucher.',

            'type.required' =>
                'Vui lòng chọn loại voucher.',

            'value.required' =>
                'Vui lòng nhập giá trị giảm.',

            'expires_at.after_or_equal' =>
                'Ngày hết hạn phải sau ngày bắt đầu.',
        ]);
    }
}