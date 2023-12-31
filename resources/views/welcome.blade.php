<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | WorkLinkUp</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bgcl {
            /* background-image: linear-gradient(to bottom, #27374d, #2f4157, #374b61, #3f556b, #475f75, #50697e, #5a7488, #647e91, #728b9c, #8098a8, #8ea5b3, #9db2bf); */
            background-color: #101927;
        }

        .bgclh {
            background-color: #1e2936;
        }

        .scrollh::-webkit-scrollbar {
            display: none;
        }

        .card {
            height: 25vh;
        }
        .fnt{
            font-size: 13px;
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
    <section class="font-monospace">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <section class="container my-5 bgclh p-5 rounded">
                        <div class="card p-3 bg-dark">
                            <div class="card-body bg-dark text-center text-light mt-3">
                                <p class="fs-2 fw-bold">Welcome to WorkLinkUp: Where Opportunities Connect</p>
                                <br>
                                <p class="fw-semibold">
                                    Discover, connect, and thrive with WorkLinkUp – the ultimate platform for job
                                    seekers and employers.
                                    Whether you're on the hunt for your next career move or looking to find the perfect
                                    candidate,
                                    WorkLinkUp has you covered.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="carousel-item">
                    <section class="container my-5 bgclh p-5 rounded">
                        <div class="card p-3 bg-dark">
                            <div class="card-body bg-dark text-center text-light">
                                <p class="fs-2 fw-bold">For Job Seekers:</p>
                                <br>
                                <p class="fw-semibold">
                                    Search and Apply: Explore a vast array of job opportunities tailored to your skills
                                    and aspirations.
                                    Use our powerful search bar to filter jobs by city, category, or name, ensuring you
                                    find the perfect
                                    match.
                                </p>
                                <br>
                                <p class="fw-semibold">
                                    Easy Application: Applying for jobs is a breeze. Submit your applications seamlessly
                                    and track your
                                    progress—all from one central dashboard.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="carousel-item">
                    <section class="container my-5 bgclh p-5 rounded">
                        <div class="card p-3 bg-dark">
                            <div class="card-body bg-dark text-center text-light">
                                <p class="fs-2 fw-bold">For Companies and Agents:</p>
                                <br>
                                <p class="fw-semibold">
                                    Post Job Openings: Showcase your opportunities to a diverse pool of talent. Post
                                    jobs effortlessly,
                                    providing detailed information to attract the right candidates.
                                </p>
                                <br>
                                <p class="fw-semibold">
                                    Connect with Talent: Receive applications directly through our platform, making the
                                    hiring process
                                    efficient and streamlined.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="carousel-item">
                    <section class="container my-5 bgclh p-5 rounded">
                        <div class="card p-3 bg-dark">
                            <div class="card-body bg-dark text-center text-light">
                                <p class="fs-2 fw-bold">Why WorkLinkUp?</p>
                                <br>
                                <p class="fw-semibold">
                                    Networking Reinvented: Forge connections with professionals across industries. Build
                                    a network that
                                    opens doors to new opportunities and collaborations.
                                </p>
                                <br>
                                <p class="fw-semibold">
                                    Career Advancement: Elevate your professional journey with access to job postings,
                                    industry
                                    insights, and mentorship opportunities.
                                </p>
                                <p class="fw-semibold">
                                    Collaborate with Confidence: From startups to established enterprises, WorkLinkUp is
                                    where great
                                    ideas come to life.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="container font-monospace">
        <div class="w-50 container">
            <p class="fnt text-white">Search by job title:</p>
            <form method="get" action="{{ route('jobs') }}">
                <div class="d-flex gap-3 justify-content-center align-items-center">
                    <input type="text" class="form-control rounded bg-dark text-white" required name="q"
                        value="{{ $query ?? '' }}">
                    <button type="submit" class="btn btn-outline-danger">Search</button>
                </div>
            </form>
        </div>
    </section>

    <section class="container bgclh p-5 rounded font-monospace mt-5">
        <div class="card p-3 bg-dark">
            <div class="card-body bg-dark text-center text-light">
                <p class="fs-2 fw-bold">Join WorkLinkUp Today: Your Career Awaits!</p>
                <br>
                <p class="fw-semibold">
                    Signing up is quick and easy. Take the next step in your professional journey – join WorkLinkUp and
                    let your career thrive.
                </p>
                @guest
                <p class="fw-semibold">
                    Ready to make the leap?
                    <a href="{{ route('register') }}"
                        class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover underline">Sign
                        Up Now</a>
                </p>
                @endguest
                <br>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>