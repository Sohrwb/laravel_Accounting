@extends('layouts.app')

@section('title', 'مدیریت امتیاز کاربران')

@section('content')
    <h3>لیست امتیاز کاربران</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نام کاربر</th>
                <th>میزان سرمایه</th>
                <th>امتیاز فعلی</th>
                <th>حداکثر قابل استفاده برای وام (۲.۵ برابر سرمایه)</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($points as $point)
                <tr>
                    <td>{{ $point->user->name }}</td>
                    <td>{{ number_format($point->user->investments_sum_amount) }} تومان</td>
                    <td>{{ $point->points }}</td>
                    <td>{{ number_format($point->user->investments_sum_amount * 2.5) }}</td>
                    <td>
                        <a href="{{ route('points.edit', $point->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
