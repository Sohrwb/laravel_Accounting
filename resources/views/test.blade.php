@extends('layouts.app')

@section('content')
    <form action="#" method="POST">
        @csrf

        <div id="react-datepicker-root"></div>
        <input type="hidden" name="date" />

        <!-- سایر فیلدهای فرم -->
        <button type="submit">ارسال</button>
    </form>
@endsection

