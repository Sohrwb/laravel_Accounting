@extends('layouts.app')

@section('title', 'ثبت وام جدید')

@section('content')
    <h3>ثبت وام جدید</h3>

    <style>
        select.form-control option {
            color: black !important;
            background-color: white !important;
        }
    </style>


    <form method="POST" action="{{ route('loans.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">کاربر</label>
            <select class="form-control" name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <x-shared.amount-input name="amount" />

        <div class="mb-3">
            <label class="form-label">تاریخ شروع</label>
            <div id="react-datepicker-root"></div>

        </div>

        <div class="mb-3">
            <label class="form-label">تعداد اقساط</label>
            <input type="number" class="form-control" name="installments_count" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">ثبت وام</button>

    </form>
@endsection

@section('scripts')
    @vite('resources/js/app.jsx')
@endsection
