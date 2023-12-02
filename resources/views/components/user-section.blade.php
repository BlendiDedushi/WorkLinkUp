<section class="container my-5">
    <p class="d-inline-flex gap-1">
        <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUserA"
            aria-expanded="true" aria-controls="collapseUserA">
            Applications { {{ count($applications) }} }
        </button>
    </p>
    <div class="collapse show mt-3" id="collapseUserA">
        @if(count($applications) > 0)
        <table class="table table-striped table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Company</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                <tr>
                    <th scope="row">{{ $application->id }}</th>
                    <td>
                        <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            href="{{ route('job', ['id' => $application->job_id]) }}">
                            {{ $application->job->title }}
                        </a>
                    </td>
                    <td>{{ $application->job->user->name }} - ({{ $application->job->user->email }})</td>
                    <td>{{ $application->created_at->format('H:i d-M-Y') }}</td>
                    <td>{{ $application->status }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                            data-bs-toggle="modal" data-bs-target="#deleteApplicationModal{{ $application->id }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>
                </tr>
                <!-- deleteApplicationModal -->
                <div class="modal fade text-light" id="deleteApplicationModal{{ $application->id }}"
                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <p>Are you sure you want to delete this application - [ {{ $application->id }} ] ?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light"
                                    data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('applications.destroy', $application->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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