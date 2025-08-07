<div class="mb-3">
    <label>{{ $label ?? 'مبلغ (تومان)' }}</label>
    <input type="text" id="{{ $id ?? 'amount_formatted' }}" class="form-control m-1 formatted-amount" required>

    <input type="hidden" name="{{ $name ?? 'total_investment' }}" class="amount-hidden">
</div>
<div class="form-text m-1 amount-in-words" style="font-weight: bold;"></div>

@if (!empty($withScore))
    <div class="mb-3">
        <label>امتیاز حساب :</label>
        <input type="text" class="form-control score-output" readonly>
        <input type="hidden" name="point" class="score-hidden">
    </div>
@endif

