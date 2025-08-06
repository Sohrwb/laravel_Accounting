@extends('layouts.app')

@section('title', 'افزودن سرمایه‌گذاری')

@section('content')
    <h3>ثبت سرمایه‌گذاری جدید</h3>
    <style>
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
            cursor: pointer;
            transition: 0.2s;
        }

        .month-label:hover {
            background: #f8f9fa;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked+.month-label {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
    </style>


    <form method="POST" action="{{ route('investments.store') }}">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">کاربر</label>
            <select class="form-control" name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">مبلغ (تومان)</label>
            <input type="number" class="form-control" name="amount" required>
        </div>



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
                    <input type="radio" name="month" value="{{ $num }}" id="month-{{ $num }}">
                    <div class="month-label">{{ $name }}</div>
                </label>
            @endforeach
        </div>

        <br>




        <button type="submit" class="btn btn-primary">ذخیره</button>
    </form>
@endsection
