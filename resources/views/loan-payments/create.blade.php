@extends('layouts.app')

@section('title', 'ثبت پرداخت قسط')

@section('content')
    <h3>ثبت پرداخت قسط جدید</h3>

    <form method="POST" action="{{ route('loan-payments.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">وام</label>
            <select name="loan_id" class="form-control" required>
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}">
                        {{ $loan->user->name }} - مبلغ: {{ number_format($loan->amount) }} - اقساط: {{ $loan->installments_count }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">مبلغ پرداختی (تومان)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">تاریخ پرداخت</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>

        <button class="btn btn-primary" type="submit">ثبت پرداخت</button>
    </form>
@endsection
