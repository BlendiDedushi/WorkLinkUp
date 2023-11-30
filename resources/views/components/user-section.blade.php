<section class="container my-5">
    <p class="d-inline-flex gap-1">
        <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUserA"
            aria-expanded="true" aria-controls="collapseUserA">
            Applications { {{ count($applications) }} }
        </button>
    </p>
    <div class="collapse show" id="collapseUserA">
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
                    <td>{{ $application->user->name }}</td>
                    <td>
                        <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            href="{{ route('job', ['id' => $application->job_id]) }}">
                            {{ $application->job->title }}
                        </a>
                    </td>
                    <td>{{ $application->job->user->name }} - ({{ $application->job->user->email }})</td>
                    <td>{{ $application->created_at->format('H:i d-M-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info text-center" role="alert">
            Alert: You haven't applied to any jobs yet. Explore our available job listings and apply to the ones
            that match your skills and interests.
        </div>
        @endif
    </div>
</section>