<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard | WorkLinkUp</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bgcl {
            background-color: #101927;
        }

        .bgclh {
            background-color: #1e2936;
        }

        .gg {
            transition: box-shadow 0.2s ease-in-out;
        }

        .gg:hover {
            box-shadow: 0px 0px 5px 3px rgba(218, 212, 206, 255);
        }

        .scrollh::-webkit-scrollbar {
            display: none;
        }
    </style>
    @livewireStyles
</head>

<body class="bgcl scrollh">
    <header>
        @if (Route::has('login'))
        @auth
        <div>
            @livewire('navigation-menu')
        </div>
        @else
        <div class="bgclh">
            <div class="container d-flex justify-content-end">
                <div class="d-flex gap-3 my-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                </div>
            </div>
        </div>
        @endif
        @endauth
        @endif
    </header>
    <div class="container my-3 w-25">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible text-center">
            {{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
                <span style="color: black;">X</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible text-center">
            {{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
                <span style="color: black;">X</span>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible text-center">
            <ul class="list-unstyled">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
                <span style="color: black;">X</span>
            </button>
        </div>
        @endif
    </div>
    @role('admin')
    @include('components.admin-section')
    @endrole

    @role('company')
    @include('components.company-section')
    @endrole

    @role('user')
    @include('components.user-section')
    @endrole

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>