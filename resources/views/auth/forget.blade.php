@extends('layouts.app')

@section('content')

<div class="row bg-white p-4">

    <h2>فرم فراموشی رمز</h2>
    <form method="POST" action="{{ route('forget') }}">
        @csrf

        <div class="mb-3 col-6">
            <label for="email" class="form-label">ایمیل</label>
            <input type="email" name="email" class="form-control" required>
        </div>


        <button type="submit" class="btn btn-success">ورود</button>
    </form>
</div>
@endsection
