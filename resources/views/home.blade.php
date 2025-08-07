@extends('layouts.app')

@section('title', 'صفحه اصلی')
@php
    use Morilog\Jalali\Jalalian;
    $user = auth()->user();
@endphp
@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1>به سیستم حسابداری بانکی خوش آمدید</h1>
            <p class="lead">مدیریت سرمایه‌گذاری، دریافت وام و انتقال امتیاز در بستری ساده و امن</p>
        </div>

        @auth
            <div class="text-center">
                <h4 class="mb-3">سلام {{ $user->name }} 👋</h4>
                <a href="{{ route('profile') }}" class="btn btn-primary m-2">مشاهده پروفایل</a>
                <a href="{{ route('investments.create', $user) }}" class="btn btn-success m-2">افزایش سرمایه</a>
                @if (auth()->user()->loans()->exists())
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>مبلغ</th>
                                    <th>سررسید</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
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
                                                <span class="text-warning">در انتظار پرداخت</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$payment->is_paid)
                                                <form action="{{ route('loan-payments.pay', $payment) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">پرداخت</button>
                                                </form>
                                            @else
                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <a href="{{ route('loans.create') }}" class="btn btn-warning m-2">درخواست وام</a>
                @endif
            </div>
        @else
            <div class="text-center">
                <a href="{{ route('login') }}" class="btn btn-outline-primary m-2">ورود</a>
                <a href="{{ route('register') }}" class="btn btn-outline-success m-2">ثبت‌نام</a>
            </div>
        @endauth
    </div>
@endsection
