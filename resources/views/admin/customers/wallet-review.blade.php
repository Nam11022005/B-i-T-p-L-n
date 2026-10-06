<details style="margin-top:12px">
    <summary style="cursor:pointer;color:#38583b;font-weight:700">Duyệt / từ chối yêu cầu</summary>
    <form method="POST" action="{{ route('admin.customers.wallet.review', [$customer, $transaction]) }}" style="display:grid;gap:10px;margin-top:12px;max-width:540px">
        @csrf
        <label class="small">Lý do xử lý
            <textarea name="note" required maxlength="500" rows="2" class="form-control mt-1" placeholder="Kết quả đối chiếu và mã giao dịch ngân hàng nếu có"></textarea>
        </label>
        <label class="small d-flex gap-2 align-items-start"><input type="checkbox" name="received" value="1" class="mt-1"> Đã đối chiếu và nhận đủ {{ number_format((float) $transaction->amount, 0, ',', '.') }}đ vào ngân hàng (khi duyệt).</label>
        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" name="decision" value="approve" class="btn btn-success btn-sm">Duyệt nạp tiền</button>
            <button type="submit" name="decision" value="reject" class="btn btn-outline-danger btn-sm">Từ chối</button>
        </div>
        <small class="text-muted">Từ chối sẽ không cộng tiền. Thông báo SePay đến sau không tự thay đổi quyết định này.</small>
    </form>
</details>
