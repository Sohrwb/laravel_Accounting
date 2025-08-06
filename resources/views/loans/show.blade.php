@extends('layouts.app')

@section('title', 'جزئیات وام')

@section('content')
    @php
        use Morilog\Jalali\Jalalian;
    @endphp
    <h3>جزئیات وام</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>کاربر:</strong> {{ $loan->user->name }}</p>
            <p><strong>مبلغ:</strong> {{ number_format($loan->amount) }} تومان</p>
            <p><strong>تعداد اقساط:</strong> {{ $loan->installments_count }}</p>
            <p><strong>تاریخ شروع:</strong> {{ Jalalian::fromDateTime($loan->start_date)->format('Y/m/d') }}</p>
            <p><strong>تاریخ پایان:</strong> {{ Jalalian::fromDateTime($loan->end_date)->format('Y/m/d') }}</p>
            <p><strong>وضعیت:</strong>
                @if ($loan->is_paid)
                    <span class="text-success">پرداخت شده</span>
                @else
                    <span class="text-danger">در حال پرداخت</span>
                @endif
            </p>
        </div>
    </div>

    <h5>اقساط</h5>
    @if ($payments->isEmpty())
        <p>برای این وام هنوز قسطی ثبت نشده است.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>شماره قسط</th>
                    <th>مبلغ</th>
                    <th>تاریخ سررسید</th>
                    <th>وضعیت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ number_format($payment->amount) }} تومان</td>
                        <td>{{ Jalalian::fromDateTime($payment->due_date)->format('Y/m/d') }}</td>
                        <td>
                            @if ($payment->is_paid)
                                <span class="text-success">پرداخت شده</span>
                            @else
                                <form action="{{ route('loan-payments.pay', $payment) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">پرداخت</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('loans.index') }}" class="btn btn-secondary mt-3">بازگشت به لیست وام‌ها</a>
@endsection
