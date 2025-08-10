@extends('layouts.app')

@section('title', 'ورود کاربران')

@section('content')
    <div class="container py-4">
        <div class="row">
            @foreach ($users as $user)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <form method="POST" action="{{route('login')}}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <div class="mb-3">
                                    <label for="password-{{ $user->id }}" class="form-label">رمز عبور</label>
                                    <input type="password" class="form-control" id="password-{{ $user->id }}"
                                        name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">ورود</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
