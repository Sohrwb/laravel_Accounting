@extends('layouts.app')

@section('title', 'پروفایل کاربر')

@section('content')
    <h3>پروفایل {{ $user->name }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>نام:</strong> {{ $user->name }}</p>
            <p><strong>ایمیل:</strong> {{ $user->email }}</p>
            <p><strong>شناسه خانواده:</strong> {{ $user->family_id }}</p>
            <p><strong>مجموع سرمایه‌گذاری:</strong> {{ number_format($user->total_investment) }} تومان</p>
            <p><strong>مقدار امتیاز:</strong> {{ number_format($user->point->points) ?? 0 }}</p>

            @if ($user->loans->where('is_paid', false)->count())
                <p class="text-danger"><strong>وام فعال:</strong> بله</p>
                <ul>
                    @foreach ($user->loans->where('is_paid', false) as $loan)
                        <li>مبلغ: {{ number_format($loan->amount) }} - اقساط: {{ $loan->installments_count }} - شروع:
                            {{ $loan->start_date }}</li>
                    @endforeach
                </ul>
            @else
                <p><strong>وام فعال:</strong> ندارد</p>
            @endif
        </div>
    </div>

    <h4>لیست تراکنش‌ها</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>مقدار</th>
                <th>نوع</th>
                <th>تاریخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->transactions as $tx)
                <tr>
                    <td>{{ number_format($tx->amount) }} تومان</td>
                    <td>
                        @if ($tx->type === 'investment')
                            سرمایه‌گذاری
                        @elseif($tx->type === 'loan_payment')
                            پرداخت قسط
                        @endif
                    </td>
                    <td>{{ $tx->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
