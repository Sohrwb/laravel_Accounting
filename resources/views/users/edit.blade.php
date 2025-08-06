@extends('layouts.app')

@section('title', 'ویرایش کاربر')

@section('content')
    <h3>ویرایش {{ $user->name }}</h3>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>نام</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>ایمیل</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>رمز جدید (در صورت نیاز)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>خانواده</label>
            <select name="family_id" class="form-control" required>
                @foreach($families as $family)
                    <option value="{{ $family->id }}" {{ $user->family_id == $family->id ? 'selected' : '' }}>
                        {{ $family->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">ذخیره تغییرات</button>
    </form>
@endsection
