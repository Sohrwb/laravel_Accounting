@extends('layouts.app')

@section('title', 'لیست تراکنش‌ها')

@section('content')
    <h3>تراکنش‌های مالی</h3>

    <a href="{{ route('transactions.create') }}" class="btn btn-success mb-3">ثبت تراکنش جدید</a>

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
            @foreach($transactions as $tx)
                <tr>
                    <td>{{ $tx->user->name }}</td>
                    <td>{{ number_format($tx->amount) }}</td>
                    <td>
                        @if($tx->type == 'investment')
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
@endsection
