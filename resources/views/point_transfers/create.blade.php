@extends('layouts.app')

@section('title', 'انتقال امتیاز')

@section('content')
    <h3>انتقال امتیاز به اعضای خانواده</h3>

    <form method="POST" action="{{ route('point-transfers.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">کاربر مقصد</label>
            <select name="to_user_id" class="form-control" required>
                @foreach($familyUsers as $user)
                    @if($user->id !== auth()->id())
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">مقدار امتیاز</label>
            <input type="number" name="points" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">انتقال</button>
    </form>
@endsection
