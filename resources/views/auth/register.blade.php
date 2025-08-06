@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">ثبت‌نام</div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">نام</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">ایمیل</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">رمز عبور</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">ثبت‌نام</button>
                        <a href="{{ route('login') }}" class="btn btn-link">حساب دارید؟ ورود</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
