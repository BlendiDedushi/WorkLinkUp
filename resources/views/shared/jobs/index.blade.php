<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jobs | WorkLinkUp</title>
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

        .zz {
            height: 38px;
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
    @if($jobs && $jobs->count() > 0)
    <section class="my-5">
        <div class="container">
            <form action="{{ route('jobs') }}" method="get" class="mb-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control rounded zz" placeholder="Job Title" id="title" name="q"
                            value="{{ $query ?? '' }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="form-select zz" id="city" name="city">
                            <option value="" selected>All Cities</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city')==$city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select zz" id="category" name="category">
                            <option value="" selected>All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' : ''
                                }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            <div>
                <h1 class="fs-1 text-white">All Jobs</h1>
                @if ($jobs->lastPage() > 1)
                <div class="d-flex gap-2 justify-content-between my-3">
                    <a class="btn btn-sm {{$jobs->onFirstPage() ? 'btn-outline-light disabled' : 'btn-outline-light'}}"
                        href="{{$jobs->previousPageUrl()}}"><i class="bi bi-caret-left"></i></a>
                    <div class="d-flex gap-3">
                        @for($i=1; $i<=$jobs->lastPage(); $i++)
                            <a class="btn btn-sm {{$i == $jobs->currentPage() ? 'btn-danger' : 'btn-outline-light'}}"
                                href="{{$jobs->url($i)}}">{{$i}}</a>
                            @endfor
                    </div>
                    <a class="btn btn-sm {{$jobs->onLastPage() ? 'btn-outline-light disabled' : 'btn-outline-light'}}"
                        href="{{$jobs->nextPageUrl()}}"><i class="bi bi-caret-right"></i></a>
                </div>
                @endif
            </div>
            @foreach($jobs as $job)
            <a href="{{ route('job', ['id' => $job->id]) }}">
                <div class="gg card my-4">
                    <div class="card-body text-center">
                        <h2 class="fs-3 badge bg-black text-wrap card-title">{{ $job->title }}</h2>
                        <h6 class="card-subtitle fs-5 mb-2 text-body-secondary"><b>{{ $job->user->email }}</b></h6>
                        <h6 class="card-subtitle fs-5 mb-2 text-body-secondary"><b>{{ $job->schedule->name }}</b></h6>
                        <div class="d-flex justify-content-around">
                            <div>
                                <h6 class="card-subtitle fs-5 mb-2 text-body-secondary">Category: <b> {{
                                        $job->category->name }} </b></h6>
                                <h6 class="card-subtitle fs-5 mb-2 text-body-secondary">City: <b> {{ $job->city->name
                                        }}</b></h6>
                            </div>
                            <div>
                                <h6 class="card-subtitle fs-5 mb-2 text-body-secondary">Positions : <b> {{
                                        $job->positions }}</b>
                                </h6>
                                <h6 class="card-subtitle fs-5 mb-2 text-body-secondary">Salary : <b> {{ $job->salary
                                        }}</b></h6>
                            </div>
                        </div>
                        <h6 class="card-subtitle fs-5 mb-2 text-body-secondary">Published on : <b> {{
                                $job->created_at->format('d/M/Y') }}</b></h6>
                    </div>
                </div>
            </a>
            @endforeach
            @if ($jobs->lastPage() > 1)
            <div class="d-flex gap-2 justify-content-between my-3">
                <a class="btn btn-sm {{$jobs->onFirstPage() ? 'btn-outline-light disabled' : 'btn-outline-light'}}"
                    href="{{$jobs->previousPageUrl()}}"><i class="bi bi-caret-left"></i></a>
                <div class="d-flex gap-3">
                    @for($i=1; $i<=$jobs->lastPage(); $i++)
                        <a class="btn btn-sm {{$i == $jobs->currentPage() ? 'btn-danger' : 'btn-outline-light'}}"
                            href="{{$jobs->url($i)}}">{{$i}}</a>
                        @endfor
                </div>
                <a class="btn btn-sm {{$jobs->onLastPage() ? 'btn-outline-light disabled' : 'btn-outline-light'}}"
                    href="{{$jobs->nextPageUrl()}}"><i class="bi bi-caret-right"></i></a>
            </div>
            @endif
        </div>
    </section>
    @else
    <div class="container my-5">
        <div class="alert alert-danger alert-dismissible text-center d-flex justify-content-between">
            No matching jobs found for the submitted form. Please adjust your search criteria.
            <a href="/jobs">
                <span style="color: black;">X</span>
            </a>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>