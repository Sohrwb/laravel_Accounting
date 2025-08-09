@extends('layouts.app')

@section('title', 'ثبت تراکنش')

@section('content')
    <h3>ثبت تراکنش جدید</h3>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">کاربر</label>
            <select name="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <x-shared.amount-input name="amount" />

        <div class="mb-3">
            <label class="form-label">تاریخ پرداخت</label>
            <div id="react-datepicker-root" ></div>

        </div>

        <div class="mb-3">
            <label class="form-label">نوع تراکنش</label>
            <select name="type" class="form-control" required>
                <option value="investment">سرمایه‌گذاری</option>
                <option value="loan_payment">پرداخت وام</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">ثبت</button>
    </form>
@endsection
