@extends('layouts.app')

@section('content')
    @php
        use Morilog\Jalali\Jalalian;
    @endphp

    <div class="container mt-4">
        <h2>گزارش ماهانه</h2>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ماه</th>
                    <th>کل سرمایه</th>
                    <th>کل اقساط پرداختی</th>
                    <th>کل وام اعطا شده</th>
                    <th>ورودی کل</th>
                    <th>جزئیات</th>
                </tr>
            </thead>
            <tbody>
          

                @foreach ($combinedData as $data)
                    <tr>
                        <td>{{ Jalalian::fromDateTime($data['month_year'])->format('Y-m') }}</td>
                        <td>{{ number_format($data['total_investment']) }} تومان</td>
                        <td>{{ number_format($data['total_installments']) }} تومان</td>
                        <td>{{ number_format($data['total_loans']) }} تومان</td>
                        <td>{{ number_format($data['total_input']) }} تومان</td>
                        <td>
                            <a href="{{ route('admin.months.show', $data['month_year']) }}" class="btn btn-primary btn-sm">مشاهده</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
