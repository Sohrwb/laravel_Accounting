@extends('layouts.app')

@section('title', 'لیست تراکنش‌ها')

@section('content')
    @php
        use Morilog\Jalali\Jalalian;
    @endphp
    <h3>تراکنش‌های مالی</h3>

    <a href="{{ route('profile') }}" class="btn btn-success mb-3">برگشت به پروفایل </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>مقدار (تومان)</th>
                <th>نوع تراکنش</th>
                <th>تاریخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $tx)
                <tr
                    @if ($tx->type == 'investment') class="table-primary"
    @elseif($tx->type == 'loan_payment')
        class="table-danger" @endif>
                
                    <td>{{ number_format($tx->amount) }}</td>
                    <td>
                        @if ($tx->type == 'investment')
                            سرمایه‌گذاری
                        @elseif($tx->type == 'loan_payment')
                            پرداخت قسط
                        @else
                            {{ $tx->type }}
                        @endif
                    </td>
                    <td>{{ Jalalian::fromDateTime($tx->created_at)->format('Y/m/d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
