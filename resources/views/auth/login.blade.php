@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">ورود</div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">ایمیل</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">رمز عبور</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-success px-4">ورود</button>
                                </div>
                                <div>
                                    <a href="{{ route('register') }}" class="btn btn-link">ثبت‌نام نکرده‌اید؟</a>
                                    <a href="{{ route('forget') }}" class="btn btn-danger ">فراموشی رمز عبور</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
