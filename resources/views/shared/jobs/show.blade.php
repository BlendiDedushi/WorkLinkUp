<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Job | WorkLinkUp</title>
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

        .desc {
            box-shadow: 0px 0px 5px 3px rgba(218, 212, 206, 255);
        }

        #applyButton,
        #disabledButton,
        .crd {
            width: 30vh;
        }
    </style>
    @livewireStyles
</head>

<body class="bgcl">
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
    <section class="container d-flex justify-content-between my-5 font-monospace">
        <div class="border rounded bg-dark text-white desc w-75">
            <div class="p-3 text-start">
                <h2 class="fs-2 fw-bold fst-italic">{{ $job->title }}</h2>
            </div>
            <div class="p-3">
                <?php
                    $sentences = explode('.', $job->description);
                    foreach ($sentences as $sentence) {
                        $sentence = trim($sentence);
                        if (!empty($sentence)) {
                            if (strpos($sentence, 'Responsibilities:') !== false) {
                                echo '<p class="lh-lg text-start"><br><strong>Responsibilities:</strong><br>' . substr($sentence, strlen('Responsibilities:')) . '.</p>';
                            } elseif (strpos($sentence, 'Requirements:') !== false) {
                                echo '<p class="lh-lg text-start"><br><strong>Requirements:</strong><br>' . substr($sentence, strlen('Requirements:')) . '.</p>';
                            } elseif (strpos($sentence, 'Benefits:') !== false) {
                                echo '<p class="lh-lg text-start"><br><strong>Benefits:</strong><br>' . substr($sentence, strlen('Benefits:')) . '.</p>';
                            } else {
                                echo '<p class="lh-lg text-start">' . $sentence . '.</p>';
                            }
                        }
                    }
                ?>
            </div>

        </div>
        <div>
            @role('user')
            <div>
                <form action="{{ route('applications.store') }}" method="POST" id="applicationForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    @if($existingApplication)
                    <button type="button" class="btn btn-outline-light" disabled id="disabledButton">
                        Already Applied
                    </button>
                    @else
                    <button type="submit" class="btn btn-outline-light" id="applyButton">
                        Apply
                    </button>
                    @endif
                </form>
            </div>
            @endrole
            <div class="mt-4 crd">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-geo-alt"> Location:</i> <br>
                            <b> {{ $job->city->name }}</b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-bookmark"> Category:</i> <br>
                            <b> {{ $job->category->name }}</b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-clock"> Schedule:</i> <br>
                            <b> {{ $job->schedule->name }}</b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-people"> Open positions:</i> <br>
                            <b> {{ $job->positions}}</b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-pc-display-horizontal"> Remote:</i> <br>
                            <b> {{ $job->remote ? 'Yes' : 'No' }} </b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-buildings"> Company:</i> <br>
                            <b> {{ $job->user->name }} ({{$job->user->email}}) </b>
                        </li>
                        <li class="list-group-item bg-dark text-white"><i class="bi bi-wallet2"> Salary:</i> <br>
                            <b> {{ $job->salary }} &euro;</b>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>