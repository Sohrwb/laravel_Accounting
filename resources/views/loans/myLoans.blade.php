@extends('layouts.app')

@section('title', 'لیست وام‌ها')

@section('content')
    <h3>وام‌های ثبت‌شده</h3>
    @php
        use Morilog\Jalali\Jalalian;
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>مبلغ</th>
                <th>تعداد اقساط</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>وضعیت</th>
                <th>باقی مانده وام</th>
                <th>مشاهده</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                <tr>
                    <td>{{ number_format($loan->amount) }} تومان</td>

                    <td>{{ $loan->installments_count }}</td>
                    <td>{{ Jalalian::fromDateTime($loan->start_date)->format('Y-m-d') }}</td>
                    <td>{{ Jalalian::fromDateTime($loan->end_date)->format('Y-m-d') }}</td>

                    <td>
                        @if ($loan->is_paid)
                            <span class="text-success">پرداخت شده</span>
                        @else
                            <span class="text-danger">در حال پرداخت</span>
                        @endif
                    </td>

                    <td>{{ number_format($loan->remaining_amount)}} تومان</td>
                    <td><a href="{{ route('loans.show', $loan) }}"class="btn btn-sm btn-primary">جزییات وام</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
