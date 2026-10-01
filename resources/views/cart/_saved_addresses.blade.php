{{-- =====================================================
     ĐỊA CHỈ GIAO HÀNG ĐÃ LƯU
     Chèn phần này phía trên các input customer_name,
     customer_phone, shipping_address trong checkout.
====================================================== --}}

@if(isset($addresses) && $addresses->count() > 0)

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="fw-bold mb-0">
                    📍 Chọn địa chỉ giao hàng
                </h5>

                <a
                    href="{{ route('addresses.index') }}"
                    class="btn btn-sm btn-outline-secondary"
                >
                    Quản lý địa chỉ
                </a>
            </div>

            <div class="row g-3">

                @foreach($addresses as $address)

                    <div class="col-lg-6">

                        <label
                            class="w-100 p-3 border rounded-3"
                            style="cursor:pointer;"
                        >

                            <div class="d-flex gap-2">

                                <input
                                    type="radio"
                                    name="address_id"
                                    value="{{ $address->id }}"
                                    class="form-check-input address-radio"
                                    data-name="{{ $address->receiver_name }}"
                                    data-phone="{{ $address->phone }}"
                                    data-address="{{ $address->full_address }}"
                                    {{ old(
                                        'address_id',
                                        optional($defaultAddress)->id
                                    ) == $address->id
                                        ? 'checked'
                                        : ''
                                    }}
                                >

                                <div>
                                    <div class="fw-bold">
                                        {{ $address->label }}

                                        @if($address->is_default)
                                            <span class="badge bg-success ms-1">
                                                Mặc định
                                            </span>
                                        @endif
                                    </div>

                                    <div>
                                        {{ $address->receiver_name }}
                                        ·
                                        {{ $address->phone }}
                                    </div>

                                    <div class="text-muted small mt-1">
                                        {{ $address->full_address }}
                                    </div>
                                </div>

                            </div>

                        </label>

                    </div>

                @endforeach

            </div>

            <div class="form-check mt-3">
                <input
                    type="radio"
                    name="address_id"
                    value=""
                    class="form-check-input address-radio"
                    id="otherAddress"
                >

                <label class="form-check-label" for="otherAddress">
                    Nhập địa chỉ khác cho đơn hàng này
                </label>
            </div>

        </div>
    </div>

@endif

<script>
document.addEventListener('DOMContentLoaded', function () {

    const nameInput =
        document.querySelector('[name="customer_name"]');

    const phoneInput =
        document.querySelector('[name="customer_phone"]');

    const addressInput =
        document.querySelector('[name="shipping_address"]');

    function applySavedAddress(radio)
    {
        if (!radio || !radio.value) {
            return;
        }

        if (nameInput) {
            nameInput.value = radio.dataset.name || '';
        }

        if (phoneInput) {
            phoneInput.value = radio.dataset.phone || '';
        }

        if (addressInput) {
            addressInput.value = radio.dataset.address || '';
        }
    }

    document
        .querySelectorAll('.address-radio')
        .forEach(function (radio) {

            radio.addEventListener('change', function () {
                applySavedAddress(this);
            });

            if (radio.checked) {
                applySavedAddress(radio);
            }
        });

});
</script>
