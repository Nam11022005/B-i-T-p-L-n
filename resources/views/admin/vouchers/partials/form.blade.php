@php
    $editing = isset($voucher);
@endphp


<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label fw-bold">
            Mã Voucher *
        </label>

        <input
            type="text"
            name="code"
            class="form-control text-uppercase"
            value="{{ old('code', $voucher->code ?? '') }}"
            placeholder="VD: TAYBAC10"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label fw-bold">
            Tên chương trình *
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $voucher->name ?? '') }}"
            placeholder="Ưu đãi Tây Bắc 10%"
            required
        >

    </div>


    <div class="col-md-4">

        <label class="form-label fw-bold">
            Loại giảm giá *
        </label>

        <select
            name="type"
            class="form-select"
            required
        >

            <option value="">
                -- Chọn loại --
            </option>

            <option
                value="percent"
                @selected(old('type', $voucher->type ?? '') === 'percent')
            >
                Giảm theo %
            </option>

            <option
                value="fixed"
                @selected(old('type', $voucher->type ?? '') === 'fixed')
            >
                Giảm số tiền
            </option>

            <option
                value="shipping"
                @selected(old('type', $voucher->type ?? '') === 'shipping')
            >
                Giảm phí vận chuyển
            </option>

        </select>

    </div>


    <div class="col-md-4">

        <label class="form-label fw-bold">
            Giá trị giảm *
        </label>

        <input
            type="number"
            name="value"
            min="0"
            step="0.01"
            class="form-control"
            value="{{ old('value', $voucher->value ?? '') }}"
            required
        >

        <small class="text-muted">
            %: nhập 10 = 10%. Tiền: nhập 50000.
        </small>

    </div>


    <div class="col-md-4">

        <label class="form-label fw-bold">
            Đơn tối thiểu
        </label>

        <input
            type="number"
            name="min_order_value"
            min="0"
            step="1000"
            class="form-control"
            value="{{ old('min_order_value', $voucher->min_order_value ?? 0) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label fw-bold">
            Giảm tối đa
        </label>

        <input
            type="number"
            name="max_discount"
            min="0"
            step="1000"
            class="form-control"
            value="{{ old('max_discount', $voucher->max_discount ?? '') }}"
        >

        <small class="text-muted">
            Có thể để trống nếu không giới hạn.
        </small>

    </div>


    <div class="col-md-6">

        <label class="form-label fw-bold">
            Giới hạn lượt sử dụng
        </label>

        <input
            type="number"
            name="usage_limit"
            min="1"
            step="1"
            class="form-control"
            value="{{ old('usage_limit', $voucher->usage_limit ?? '') }}"
        >

        <small class="text-muted">
            Để trống = không giới hạn.
        </small>

    </div>


    <div class="col-md-6">

        <label class="form-label fw-bold">
            Bắt đầu
        </label>

        <input
            type="datetime-local"
            name="starts_at"
            class="form-control"
            value="{{ old(
                'starts_at',
                isset($voucher) && $voucher->starts_at
                    ? $voucher->starts_at->format('Y-m-d\TH:i')
                    : ''
            ) }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label fw-bold">
            Hết hạn
        </label>

        <input
            type="datetime-local"
            name="expires_at"
            class="form-control"
            value="{{ old(
                'expires_at',
                isset($voucher) && $voucher->expires_at
                    ? $voucher->expires_at->format('Y-m-d\TH:i')
                    : ''
            ) }}"
        >

    </div>


    <div class="col-12 mt-4">

        <div class="form-check form-switch">

            <input
                type="checkbox"
                name="is_active"
                value="1"
                class="form-check-input"
                id="isActive"

                @checked(
                    old(
                        'is_active',
                        isset($voucher)
                            ? $voucher->is_active
                            : true
                    )
                )
            >

            <label
                for="isActive"
                class="form-check-label fw-bold"
            >
                Cho phép sử dụng Voucher
            </label>

        </div>

    </div>

</div>