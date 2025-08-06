@extends('layouts.app')

@section('title', 'ورود')

@section('content')
   
    <h2>رمز جدید</h2>
    <form method="POST" action="{{ route('resetPassword.post') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="password" class="form-label">رمز عبور</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>


        <button type="submit" class="btn btn-success">ثبت</button>
    </form>
@endsection
