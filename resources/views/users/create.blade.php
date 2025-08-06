@extends('layouts.app')

@section('title', 'افزودن کاربر')

@section('content')
    <h3>کاربر جدید</h3>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label>نام</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>ایمیل</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>رمز عبور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>خانواده</label>
            <select name="family_id" class="form-control" required>
                @foreach ($families as $family)
                    <option value="{{ $family->id }}">{{ $family->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">ذخیره</button>
    </form>
@endsection
