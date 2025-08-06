@extends('layouts.app')

@section('title', 'لیست کاربران')

@section('content')
    <h3>کاربران سیستم</h3>

    <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">کاربر جدید</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>خانواده</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->family->name ?? '---' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">ویرایش</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('حذف شود؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
