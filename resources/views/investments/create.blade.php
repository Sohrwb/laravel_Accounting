@extends('layouts.app')

@section('title', 'افزودن سرمایه‌گذاری')

@section('content')
    <h3>ثبت سرمایه‌گذاری جدید</h3>

    <style>
        .user-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .user-label {
            padding: 10px 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            min-width: 120px;
            transition: 0.2s;
        }

        .user-label:hover {
            background-color: #f1f1f1;
        }

        input[type="radio"][name="user_id"] {
            display: none;
        }

        input[type="radio"][name="user_id"]:checked+.user-label {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .month-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            max-width: 300px;
            margin: auto;
        }

        .month-label {
            display: block;
            text-align: center;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: default;
        }

        input[type="radio"][name="month"] {
            display: none;
        }

        input[type="radio"][name="month"]:checked+.month-label {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        input[type="radio"][name="month"]:disabled+.month-label {
            background-color: #e9ecef;
            color: #999;
            border-color: #ddd;
        }

        .paid-info {
            text-align: center;
            font-size: 18px;
            color: #198754;
            margin-bottom: 15px;
            font-weight: bold;

        }

        .user-label {
            padding: 10px 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            min-width: 120px;
            transition: 0.2s;
            text-decoration: none;
            color: #000;
        }

        .user-label:hover {
            background-color: #f1f1f1;
        }

        .user-label.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
    </style>

    <form method="POST" action="{{ route('investments.store') }}">
        @csrf

        <input type="hidden" name="user_id" value="{{ $selectedUserId }}">

        {{-- انتخاب اعضای خانواده به صورت دکمه لینک‌دار --}}
        <div class="user-grid">
            @foreach ($users as $user)
                <a href="{{ route('investments.create', ['user' => $user->id]) }}"
                    class="user-label {{ $user->id == $selectedUserId ? 'active' : '' }}">
                    {{ $user->name }}
                </a>
            @endforeach
        </div>

        @php
            $selectedUserId = $selectedUserId ?? null;
            $total = isset($selectedUserId, $investments[$selectedUserId]) ? $investments[$selectedUserId] : null;
            $selectedUser = $users->firstWhere('id', $selectedUserId);
        @endphp


        @if ($total)
            <div class="paid-info">
                {{ $selectedUser->name }} در این ماه {{ number_format($total) }} تومان پرداخت کرده است
            </div>
        @endif



        {{-- ورودی مبلغ --}}
        <x-shared.amount-input name="amount" />

        {{-- ماه جاری فقط قابل انتخاب (غیرفعال کردن بقیه) --}}
        <div class="month-grid">
            @php
                $months = [
                    1 => 'فروردین',
                    2 => 'اردیبهشت',
                    3 => 'خرداد',
                    4 => 'تیر',
                    5 => 'مرداد',
                    6 => 'شهریور',
                    7 => 'مهر',
                    8 => 'آبان',
                    9 => 'آذر',
                    10 => 'دی',
                    11 => 'بهمن',
                    12 => 'اسفند',
                ];
            @endphp



            @foreach ($months as $num => $name)
                <label>
                    <input type="radio" name="month" value="{{ $num }}" id="month-{{ $num }}"
                        {{ $num == $currentMonth ? 'checked' : 'disabled' }}>
                    <div class="month-label">{{ $name }}</div>
                </label>
            @endforeach
        </div>

        <br>

        <button type="submit" class="btn btn-primary">ذخیره</button>
    </form>
@endsection
