@php
    $formKey = $address ? (string) $address->id : 'new';
    $restoreInput = $errors->getBag('addresses')->any() && (string) old('address_form') === $formKey;
    $fields = [
        'label' => ['Tên gợi nhớ', 50, true],
        'receiver_name' => ['Họ tên người nhận', 255, true],
        'phone' => ['Số điện thoại', 20, true],
        'province' => ['Tỉnh / Thành phố', 100, false],
        'district' => ['Quận / Huyện', 100, false],
        'ward' => ['Phường / Xã', 100, false],
        'address_detail' => ['Địa chỉ chi tiết', 500, true],
    ];
@endphp
<form class="pf-address-form" action="{{ $address ? route('addresses.update', $address) : route('addresses.store') }}" method="POST">
    @csrf
    @if($address) @method('PUT') @endif
    <input type="hidden" name="address_form" value="{{ $formKey }}">
    @foreach($fields as $field => [$label, $max, $required])
        @php
            $defaultValue = $address?->{$field} ?? ($field === 'receiver_name' ? $user->name : ($field === 'label' ? 'Nhà' : ''));
            $value = $restoreInput ? old($field, $defaultValue) : $defaultValue;
        @endphp
        <div class="{{ $field === 'address_detail' ? 'full' : '' }}">
            <label for="address-{{ $formKey }}-{{ $field }}">{{ $label }}{{ $required ? ' *' : '' }}</label>
            <input id="address-{{ $formKey }}-{{ $field }}" type="{{ $field === 'phone' ? 'tel' : 'text' }}" name="{{ $field }}" value="{{ $value }}" maxlength="{{ $max }}" @required($required)>
        </div>
    @endforeach
    <label class="pf-address-check full">
        <input type="checkbox" name="is_default" value="1" @checked($restoreInput ? old('is_default') : ($address?->is_default ?? $addresses->isEmpty()))>
        Đặt làm địa chỉ mặc định
    </label>
    <div class="full"><button class="pf-primary-btn" type="submit">{{ $address ? 'Lưu thay đổi' : 'Lưu địa chỉ mới' }}</button></div>
</form>
