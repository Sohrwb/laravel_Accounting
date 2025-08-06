@extends('layouts.app')

@section('title', 'لیست وام‌ها')

@section('content')
    <h3>وام‌های ثبت‌شده</h3>

    <a href="{{ route('loans.create') }}" class="btn btn-success mb-3">درخواست وام جدید</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>کاربر</th>
                <th>مبلغ</th>
                <th>تعداد اقساط</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>وضعیت</th>
                <th>مشاهده</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ number_format($loan->amount) }} تومان</td>
                    <td>{{ $loan->installments_count }}</td>
                    <td>{{ $loan->start_date }}</td>
                    <td>{{ $loan->end_date }}</td>
                    <td>
                        @if($loan->is_paid)
                            <span class="text-success">پرداخت شده</span>
                        @else
                            <span class="text-danger">در حال پرداخت</span>
                        @endif
                    </td>
                    <td><a href="{{ route('loans.show', $loan) }}"class="btn btn-primary">جزییات وام</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
