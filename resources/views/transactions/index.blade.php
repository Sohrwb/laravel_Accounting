@extends('layouts.app')

@section('title', 'لیست تراکنش‌ها')

@section('content')
    <h3>تراکنش‌های مالی</h3>

    <a href="{{ route('transactions.create') }}" class="btn btn-success mb-3">ثبت تراکنش جدید</a>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="user_name" class="form-control" placeholder="جستجوی نام کاربر"
                value="{{ request('user_name') }}">
        </div>

        <div class="col-md-2">
            <select name="filter_type" class="form-select">
                <option value="">همه تراکنش‌ها</option>
                <option value="investment" @if (request('filter_type') == 'investment') selected @endif>سرمایه‌گذاری</option>
                <option value="loan_payment" @if (request('filter_type') == 'loan_payment') selected @endif>پرداخت قسط</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="year" class="form-select">
                <option value="">همه سال‌ها</option>
                @php
                    $currentYear = \Morilog\Jalali\Jalalian::now()->getYear();
                @endphp
                @for ($y = $currentYear - 5; $y <= $currentYear; $y++)
                    <option value="{{ $y }}" @if (request('year') == $y) selected @endif>سال
                        {{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <select name="month" class="form-select">
                <option value="">همه ماه‌ها</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" @if (request('month') == $m) selected @endif>ماه
                        {{ $m }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="date_desc" @if (request('sort') == 'date_desc') selected @endif>تاریخ (جدیدترین)</option>
                <option value="date_asc" @if (request('sort') == 'date_asc') selected @endif>تاریخ (قدیمی‌ترین)</option>
                <option value="amount_desc" @if (request('sort') == 'amount_desc') selected @endif>مقدار (بیشترین)</option>
                <option value="amount_asc" @if (request('sort') == 'amount_asc') selected @endif>مقدار (کمترین)</option>
            </select>
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">اعمال فیلتر</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>کاربر</th>
                <th>مقدار (تومان)</th>
                <th>نوع تراکنش</th>
                <th>تاریخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $tx)
                <tr @if ($tx->type == 'investment') class="table-primary"
                @elseif($tx->type == 'loan_payment') class="table-danger" @endif>
                    <td>{{ $tx->user->name }}</td>
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
                    <td>{{ $tx->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- لینک‌های صفحه‌بندی با استایل بوت‌استرپ -->
    <div class="d-flex justify-content-center">
        {{ $transactions->links('pagination::bootstrap-5') }}
    </div>
@endsection
