@extends('layouts.app')

@php
    use Morilog\Jalali\Jalalian;
@endphp
@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Box 1: اطلاعات وام و اقساط -->
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="card h-100 shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">اطلاعات وام</h5>
                    </div>
                    <div class="card-body text-end">
                        @if ($loan)
                            {{-- اطلاعات کلی وام --}}
                            <ul class="list-unstyled mb-4">
                                <li><strong>کاربر:</strong> {{ $loan->user->name }}</li>
                                <li><strong>مبلغ وام:</strong> {{ number_format($loan->amount) }} تومان</li>
                                <li><strong>تعداد اقساط:</strong> {{ $loan->installments_count }}</li>
                                <li><strong>تاریخ شروع:</strong>
                                    {{ Jalalian::fromDateTime($loan->start_date)->format('Y/m/d') }}</li>
                                <li><strong>تاریخ پایان:</strong>
                                    {{ Jalalian::fromDateTime($loan->end_date)->format('Y/m/d') }}
                                </li>
                                <li>
                                    <strong>وضعیت:</strong>
                                    @if ($loan->is_paid)
                                        <span class="text-success fw-bold">پرداخت شده</span>
                                    @else
                                        <span class="text-danger fw-bold">در حال پرداخت</span>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-success mt-3"> مشاهده وام
                                    </a>
                                </li>
                            </ul>

                            {{-- لیست اقساط --}}
                            <h6 class="text-center mb-3">لیست اقساط</h6>

                            @if ($payments->isEmpty())
                                <div class="alert alert-warning text-center">
                                    برای این وام هنوز قسطی ثبت نشده است.
                                </div>
                            @else
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
                                                    <td>{{ Jalalian::fromDateTime($payment->due_date)->format('Y/m/d') }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->is_paid)
                                                            <span class="text-success">پرداخت شده</span>
                                                        @else
                                                            <span class="text-warning">در انتظار پرداخت</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!$payment->is_paid)
                                                            <form action="{{ route('loan-payments.pay', $payment) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-primary">پرداخت</button>
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
                            @endif

                            <a href="{{ route('loans.my') }}" class="btn btn-success w-100 mt-3">بازگشت به لیست
                                وام‌ها</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Box 2: سرمایه‌گذاری خانواده -->
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="card h-100 shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0">سرمایه‌گذاری اعضای خانواده</h5>
                    </div>
                    <div class="card-body p-3">
                        @if ($familyMembers->isEmpty())
                            <div class="alert alert-warning text-center">
                                هیچ عضوی برای این خانواده ثبت نشده است.
                            </div>
                        @else
                            <ul class="list-group list-group-flush ">
                                <a class="btn btn-outline-primary " href="{{ route('investments.show', $user) }}">لیست
                                    سرمایه های
                                    من</a>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                    <strong> سرمایه من:</strong> {{ number_format($user->total_investment) }} تومان
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                    <strong> امتیاز من:</strong> {{ number_format($point->points) }}
                                </li>
                            </ul>

                            <h6 class="text-center my-3">لیست افراد خانواده</h6>

                            @foreach ($familyMembers as $member)
                                @php
                                    $point = $member->point->points ?? 0;

                                @endphp

                                <div class="border rounded p-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>{{ $member->name }}</strong>

                                        <form action="{{ route('investments.create', $member) }}" method="get"
                                            class="m-0">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-primary">پرداخت</button>
                                        </form>
                                    </div>
                                    <div class="text-muted small">
                                        سرمایه: {{ number_format($member->total_investment) }} تومان |
                                        امتیاز: {{ $point }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <!-- Box 3 -->
            <div class="col-12 col-md-4">
                <div class="p-3 text-white text-center h-100 rounded" style="background-color: #dc3545; overflow: hidden;">
                    <h5 class="mb-3">مدیریت اعضای خانواده</h5>

                    <div class="bg-white text-dark rounded shadow-sm p-3" style="max-height: 500px; overflow-y: auto;">
                        @if ($familyMembers->isEmpty())
                            <div class="alert alert-warning text-center">هیچ عضوی برای این خانواده ثبت نشده است.</div>
                        @else
                            @foreach ($familyMembers as $member)
                                @php
                                    $investmentAmount = $member->total_investments ?? 0;
                                    $point = $member->point->points ?? 0;

                                    $currentMonthPayment = $member->loans
                                        ->flatMap(fn($loan) => $loan->payments)
                                        ->first(
                                            fn($payment) => !$payment->is_paid &&
                                                \Carbon\Carbon::parse($payment->due_date)->isSameMonth(now()),
                                        );

                                    $hasLoan = $member->loans && $member->loans->isNotEmpty();
                                @endphp

                                <div class="border rounded p-2 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>{{ $member->name }}</strong>

                                    </div>

                                    <div class="text-muted small mb-2">
                                        سرمایه: {{ number_format($member->total_investment) }} تومان |
                                        امتیاز: {{ number_format($point) }}
                                    </div>
                                    @if ($hasLoan)
                                        @if ($hasLoan && $currentMonthPayment)
                                            <div class="alert alert-warning p-2 mb-0 text-center">
                                                <div class="small mb-1">
                                                    <strong>قسط این ماه:</strong>
                                                    {{ number_format($currentMonthPayment->amount) }} تومان
                                                </div>
                                                <div class="small mb-2">
                                                    سررسید:
                                                    {{ Jalalian::fromDateTime($currentMonthPayment->due_date)->format('Y/m/d') }}
                                                </div>
                                                <form action="{{ route('loan-payments.pay', $currentMonthPayment) }}"
                                                    method="POST" class="m-0">
                                                    @csrf
                                                    <button class="btn btn-sm btn-primary">پرداخت قسط</button>
                                                </form>
                                            </div>
                                        @endif
                                        <p class="bg-warning rounded"> وام دارد </ح>
                                    @endif

                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
