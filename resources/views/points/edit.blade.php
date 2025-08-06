@extends('layouts.app')

@section('title', 'ویرایش امتیاز')

@section('content')
    <h3>ویرایش امتیاز کاربر: {{ $point->user->name }}</h3>

    <form method="POST" action="{{ route('points.update', $point->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">مقدار امتیاز</label>
            <input type="number" name="points" class="form-control" value="{{ $point->points }}" required>
        </div>

        <button type="submit" class="btn btn-primary">ذخیره</button>
    </form>
@endsection
