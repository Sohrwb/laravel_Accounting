@extends('layouts.app')

@section('title', 'لیست سرمایه‌گذاری‌ها')
@php
    use Morilog\Jalali\Jalalian;
@endphp
@section('content')
    <h3>سرمایه‌گذاری‌ها</h3>
    <a href="{{ route('profile') }}" class="btn btn-success mb-3"> برگشت به پروفایل </a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>کاربر</th>
                <th>مبلغ</th>
                <th>ماه</th>
                <th>ثبت شده در</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($investments as $investment)
                <tr>
                    <td>{{ $investment->user->name }}</td>
                    <td>{{ number_format($investment->amount) }} تومان</td>
                    <td>{{ $investment->month ."-". ($monthName = getPersianMonthName($investment->month)) }}</td>
                    <td>{{ Jalalian::fromDateTime($investment->created_at)->format('Y/m/d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
