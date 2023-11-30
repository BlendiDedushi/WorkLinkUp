<section class="container my-5">
    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseAdminU" aria-expanded="true" aria-controls="collapseAdminU">
                Users { {{ count($users) }} }
            </button>
        </p>
        <div class="collapse show" id="collapseAdminU">
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><b>{{ strtoupper($user->getRoleNames()->implode(', ')) }}</b></td>
                        <td>{{ $user->created_at->format('H:i d-M-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseCompanyJ" aria-expanded="true" aria-controls="collapseCompanyJ">
                Jobs { {{ count($jobs) }} }
            </button>
        </p>
        <div class="collapse show" id="collapseCompanyJ">
            @if(count($jobs) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Company</th>
                        <th scope="col">City</th>
                        <th scope="col">Category</th>
                        <th scope="col">Schedule</th>
                        <th scope="col">Title</th>
                        <th scope="col">Positions</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Remote</th>
                        <th scope="col">Added</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <th scope="row">{{ $job->id }}</th>
                        <td>{{ $job->user->email }}</td>
                        <td>{{ $job->city->name }}</td>
                        <td>{{ $job->category->name }}</td>
                        <td>{{ $job->schedule->name }}</td>
                        <td>
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                href="{{ route('job', ['id' => $job->id]) }}">
                                {{ $job->title }}
                            </a>
                        </td>
                        <td>{{ $job->positions }}</td>
                        <td>{{ $job->salary }}</td>
                        <td>{{ $job->remote ? 'Yes' : 'No' }}</td>
                        <td>{{ $job->created_at->format('H:i d-M-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info text-center" role="alert">
                Attention: There are currently no jobs available. Check back later for new job listings.
            </div>
            @endif
        </div>
    </div>
    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseAdminA" aria-expanded="true" aria-controls="collapseAdminA">
                Applications { {{ count($applications) }} }
            </button>
        </p>
        <div class="collapse show" id="collapseAdminA">
            @if(count($applications) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Job</th>
                        <th scope="col">Company</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <th scope="row">{{ $application->id }}</th>
                        <!-- App\Models\User::where('id',$application->user_id)->first()->email -->
                        <td>{{ $application->user->email }}</td>
                        <td>
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                href="{{ route('job', ['id' => $application->job_id]) }}">
                                {{ $application->job->title }}
                            </a>
                        </td>
                        <td>{{ $application->job->user->email }}</td>
                        <td>{{ $application->created_at->format('H:i d-M-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info text-center" role="alert">
                Attention: No applications have been made by users for any jobs yet. Feel free to check back later.
            </div>
            @endif
        </div>
    </div>
    <div>
        <div class="d-flex justify-content-between">
            <p class="d-inline-flex gap-1">
                <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseAdminC" aria-expanded="false" aria-controls="collapseAdminC">
                    Categories { {{ count($categories) }} }
                </button>
            </p>
            <p class="d-inline-flex gap-1">
                <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseAdminCt" aria-expanded="false" aria-controls="collapseAdminCt">
                    Cities { {{ count($cities) }} }
                </button>
            </p>
            <p class="d-inline-flex gap-1">
                <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseAdminS" aria-expanded="false" aria-controls="collapseAdminS">
                    Schedules { {{ count($schedules) }} }
                </button>
            </p>
        </div>

        <div class="d-flex justify-content-between">
            <div class="collapse" id="collapseAdminC">
                @if(count($categories) > 0)
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->format('H:i d-M-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info text-center" role="alert">
                    Attention: There are currently no categories available. Please add some categories to enhance your
                    job
                    listings.
                </div>
                @endif
            </div>

            <div class="collapse" id="collapseAdminCt">
                @if(count($cities) > 0)
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $city)
                        <tr>
                            <th scope="row">{{ $city->id }}</th>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->created_at->format('H:i d-M-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info text-center" role="alert">
                    Attention: There are currently no cities available. Please add some cities to enhance your job
                    listings.
                </div>
                @endif
            </div>
            <div class="collapse" id="collapseAdminS">
                @if(count($schedules) > 0)
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr>
                            <th scope="row">{{ $schedule->id }}</th>
                            <td>{{ $schedule->name }}</td>
                            <td>{{ $schedule->created_at->format('H:i d-M-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info text-center" role="alert">
                    Attention: There are currently no schedules available. Please add some schedules to enhance your job
                    listings.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>