@extends('layouts.app')

@section('title', 'لیست پرداخت اقساط')

@section('content')
    <h3>پرداخت اقساط</h3>
    <a href="{{ route('loan-payments.create') }}" class="btn btn-success mb-3">ثبت پرداخت جدید</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>کاربر</th>
                <th>وام</th>
                <th>مبلغ پرداختی</th>
                <th>تاریخ پرداخت</th>
                <th>شماره قسط</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loanPayments as $payment)
                <tr>
                    <td>{{ $payment->loan->user->name }}</td>
                    <td>{{ $payment->loan->name }}</td>
                    <td>{{ number_format($payment->amount) }} تومان</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->installment_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
