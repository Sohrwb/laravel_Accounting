<!DOCTYPE html>
<html lang="fa">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'سیستم حسابداری')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>



<body dir="rtl" class="bg-light">

    @php
        $user = auth()->user();
    @endphp

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            {{-- لوگو --}}
            <a class="navbar-brand ms-auto" href="{{ route('home') }}">بانک من</a>

            @auth
                <span class=" text-dark text-center mx-5">{{ $user->name }}</span>
            @endauth
            @auth
                {{-- دکمه همبرگری (فقط اگر کاربر لاگین باشد) --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endauth

            {{-- محتوا (فقط اگر کاربر لاگین باشد) --}}
            @auth

                @auth

                @endauth

                <div class="collapse navbar-collapse" id="navbarContent">
                    {{-- لینک‌ها --}}
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger border m-1" href="{{ route('admin.users.index') }}"> لیست
                                    کاربران</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger border m-1" href="#"> لیست وام ها </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-success border m-1" href="#">لیست تراکنش ها</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-dark border m-1" href="#"> پرداخت دستی</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary border m-1" href="{{ route('profile') }}">پروفایل
                                    من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger border m-1" href="#">خانواده من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-success border m-1"
                                    href="{{ route('transactions.show', $user) }}">تراکنش‌های من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-dark border m-1" href="#">وام من</a>
                            </li>
                        @endif
                    </ul>

                    {{-- دکمه خروج --}}
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="get">
                                @csrf
                                <button class="btn btn-outline-danger" type="submit">خروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            {{-- فقط در صورت عدم ورود کاربر --}}
            @guest
                <div class="mx-auto">
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">ورود</a>
                </div>
            @endguest
        </div>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif


    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('js/amount-handler.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
