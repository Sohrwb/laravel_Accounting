@extends('layouts.app')

@section('title', 'لیست تراکنش‌ها')

@section('content')
@php
    use Morilog\Jalali\Jalalian;
@endphp
<h3>تراکنش‌های مالی</h3>

<a href="{{ route('profile') }}" class="btn btn-success mb-3">برگشت به پروفایل </a>

{{-- فرم فیلتر و مرتب سازی --}}
<form method="GET" class="mb-3 d-flex gap-2 align-items-center">

    {{-- مرتب سازی بر اساس تاریخ --}}
    <select name="sort" class="form-select w-auto">
        <option value="">مرتب سازی بر اساس</option>
        <option value="date_asc" @if(request('sort') == 'date_asc') selected @endif>تاریخ صعودی</option>
        <option value="date_desc" @if(request('sort') == 'date_desc') selected @endif>تاریخ نزولی</option>
        <option value="amount_desc" @if(request('sort') == 'amount_desc') selected @endif>بیشترین مقدار</option>
        <option value="amount_asc" @if(request('sort') == 'amount_asc') selected @endif>کمترین مقدار</option>
    </select>

    {{-- فیلتر نوع تراکنش --}}
    <select name="filter_type" class="form-select w-auto">
        <option value="">همه تراکنش‌ها</option>
        <option value="investment" @if(request('filter_type') == 'investment') selected @endif>فقط سرمایه‌گذاری</option>
        <option value="loan_payment" @if(request('filter_type') == 'loan_payment') selected @endif>فقط پرداخت قسط</option>
    </select>

    <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
    <a href="{{ route('transactions.show',Auth::user()) }}" class="btn btn-secondary">ریست</a>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>مقدار (تومان)</th>
            <th>نوع تراکنش</th>
            <th>تاریخ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $tx)
            <tr @if ($tx->type == 'investment') class="table-primary"
                @elseif($tx->type == 'loan_payment') class="table-danger" @endif>
                <td>{{ number_format($tx->amount) }}</td>
                <td>
                    @if ($tx->type == 'investment')
                        سرمایه‌گذاری
                    @elseif($tx->type == 'loan_payment')
                        پرداخت قسط
                    @else
                        {{ $tx->type }}
                    @endif
                </td>
                <td>{{ Jalalian::fromDateTime($tx->date)->format('Y/m/d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
