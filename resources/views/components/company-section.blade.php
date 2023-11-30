<section class="container my-5">
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
                        <th scope="col">User</th>
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
                        <td>{{ $job->user->name }}</td>
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
                Alert: You haven't added any jobs yet. Take the opportunity to create new job listings and attract
                potential applicants to your positions.
            </div>
            @endif
        </div>
    </div>
    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseCompanyA" aria-expanded="true" aria-controls="collapseCompanyA">
                Applications { {{ count($applications) }} }
            </button>
        </p>
        <div class="collapse show" id="collapseCompanyA">
            @if(count($applications) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Job</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <th scope="row">{{ $application->id }}</th>
                        <td>{{ $application->user->email }}</td>
                        <td>
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                href="{{ route('job', ['id' => $application->job_id]) }}">
                                {{ $application->job->title }}
                        </a>
                        </td>
                        <td>{{ $application->created_at->format('H:i d-M-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info text-center" role="alert">
                Attention: No applications have been made by users for any of your jobs yet. Feel free to check back
                later.
            </div>
            @endif
        </div>
    </div>
</section>