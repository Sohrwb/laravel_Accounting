@extends('layouts.app')

@section('title', 'ثبت وام جدید')

@section('content')
    <h3>ثبت وام جدید</h3>

    <form method="POST" action="{{ route('loans.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">کاربر</label>
            <select class="form-control" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">مبلغ (تومان)</label>
            <input type="number" class="form-control" name="amount" required>
        </div>

        <div class="mb-3">
            <label class="form-label">تاریخ شروع</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>

        <div class="mb-3">
            <label class="form-label">تاریخ پایان</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>

        <div class="mb-3">
            <label class="form-label">تعداد اقساط</label>
            <input type="number" class="form-control" name="installments_count" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">ثبت وام</button>
    </form>
@endsection
