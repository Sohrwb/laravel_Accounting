@extends('layouts.app')

@section('content')
    @php
        use Morilog\Jalali\Jalalian;
    @endphp
    <div class="container mt-4">
        <h2>جزئیات تراکنش‌های ماه {{ $month }}</h2>
        <a href="{{ route('admin.months.index') }}" class="btn btn-secondary mb-3">بازگشت</a>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>تاریخ</th>
                    <th>توضیحات</th>
                    <th>مبلغ</th>
                    <th>نوع</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $t)
                    <tr
                        @if ($t->type == 'investment') class="table-primary"
    @elseif($t->type == 'loan_payment')
        class="table-danger" @endif>

                        <td>{{ Jalalian::fromDateTime($t->date)->format('Y-m-d') }}</td>
                        <td><a href="{{ route('admin.users.show', $t->user) }}">{{ $t->user->name }}</a></td>

                        <td>{{ number_format($t->amount) }} ریال</td>
                        <td>{{ $t->type == 'investment' ? 'سرمایه‌گذاری' : 'وام' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
