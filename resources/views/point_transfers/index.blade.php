@extends('layouts.app')

@section('title', 'تاریخچه انتقال امتیاز')

@section('content')
    <h3>انتقال‌های امتیاز</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>از</th>
                <th>به</th>
                <th>مقدار</th>
                <th>تاریخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->fromUser->name }}</td>
                    <td>{{ $transfer->toUser->name }}</td>
                    <td>{{ $transfer->points }}</td>
                    <td>{{ $transfer->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
