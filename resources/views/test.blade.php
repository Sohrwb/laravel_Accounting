@extends('layouts.app')

@section('content')
    <form action="#" method="POST">
        @csrf

        <div id="react-datepicker-root"></div>
        <input type="hidden" name="date" />

        <div class="mb-3">
            <label class="form-label">کاربر</label>
            <select class="form-control" name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- سایر فیلدهای فرم -->
        <button type="submit">ارسال</button>
    </form>
@endsection
