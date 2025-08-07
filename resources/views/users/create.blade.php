@extends('layouts.app')

@section('title', 'افزودن کاربر')

@section('content')
    <h3>کاربر جدید</h3>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label>نام</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>ایمیل</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <x-shared.amount-input name="amount" :withScore="true" />

        <div class="mb-3">
            <label>رمز عبور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>خانواده</label>
            <div class="d-flex gap-2 align-items-center">
                <select name="family_id" class="form-control" required>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
                    افزودن خانواده
                </button>
            </div>
        </div>

        <button class="btn btn-primary">ذخیره</button>
    </form>

    <!-- Modal افزودن خانواده -->
    <div class="modal fade" id="addFamilyModal" tabindex="-1" aria-labelledby="addFamilyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('family.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFamilyModalLabel">افزودن خانواده</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <label>نام خانواده</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">افزودن</button>
                </div>
            </form>
        </div>
    </div>



@endsection
