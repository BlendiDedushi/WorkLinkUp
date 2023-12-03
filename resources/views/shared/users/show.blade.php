<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UserProfile | WorkLinkUp</title>
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

    <section class="container d-flex justify-content-between my-2">
        <div class="w-50 d-flex flex-column">
            <div class=" d-flex justify-content-between">
                <div>
                    @if(!empty($user->profile_photo_path))
                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" style="width: 30vh;"
                        alt="{{ $user->name }}" class="img-thumbnail rounded float-start">
                    @else
                    <img src="{{ $user->profile_photo_url }}" style="width: 30vh;" alt="{{ $user->name }}"
                        class="img-thumbnail rounded float-start">
                    @endif
                </div>
                <div class="text-white text-start  d-flex flex-column justify-content-center mx-5 gap-2 p-2">
                    <p class="fs-4"><b>{{ $user->name }}</b></p>
                    <p>Email: <b>{{ $user->email }}</b></p>
                    @if ($user->filename && auth()->user()->hasRole('admin'))
                    <p>Current PDF File: <a
                            class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            href="{{ route('download.pdf', $user->id) }}">Download PDF <i
                                class="bi bi-file-earmark-arrow-down"></i></a></p>
                    @endif
                    @if ($user->filename && auth()->user()->hasRole('user'))
                    @if(!$user->sendRequest)
                        <form action="{{ route('sendRequest') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Change role to company</button>
                        </form>
                    @endif
                    @endif
                </div>
            </div>
            <div class="text-white w-50 mt-2">
                @if (auth()->user()->hasRole(['company', 'user']) && auth()->user()->id === $user->id)
                @if (!$user->filename)
                <div>
                    <form action="{{ route('add.pdf') }}" method="post" enctype="multipart/form-data" id="pdfForm">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Add PDF File:</label>
                            <input class="form-control bg-success rounded border" name="pdf" accept=".pdf" type="file"
                                id="formFile" required onchange="submitForm()">
                        </div>
                    </form>
                </div>
                @endif
                @if ($user->filename)
                <form action="{{ route('update.pdf') }}" method="post" enctype="multipart/form-data" id="pdfForm2">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Update PDF File:</label>
                        <input class="form-control bg-warning rounded border" name="pdf" accept=".pdf" type="file"
                            id="formFile" required onchange="submitForm2()">
                    </div>
                </form>

                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#deletePdfModal{{ $user->id }}">
                    <!-- <i class="bi bi-x-lg"></i> -->
                    Delete PDF
                </button>
                <!-- deletePdfModal -->
                <div class="modal fade text-light" id="deletePdfModal{{ $user->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark border">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirm Deletion</h1>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span style="color: white;">X</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this document?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('delete.pdf') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
        @if($user->filename)
        <div class="border w-50">
            <div class="p-2">
                <iframe class="ratio ratio-16x9" src="{{ asset('storage/' . $user->filename .'#toolbar=0') }}"
                    style="height: 92vh;"></iframe>
            </div>
        </div>
        @endif
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    @livewireScripts

    <script>
        function submitForm() {
            document.getElementById('pdfForm').submit();
        }
        function submitForm2() {
            document.getElementById('pdfForm2').submit();
        }
    </script>
</body>

</html>