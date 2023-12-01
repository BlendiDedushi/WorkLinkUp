<section class="container my-5 d-flex flex-column gap-3">
    <div>
        <p class="d-inline-flex gap-1 mb-3">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseCompanyJ" aria-expanded="true" aria-controls="collapseCompanyJ">
                Jobs { {{ count($jobs) }} }
            </button>
        </p>
        <div class="collapse show" id="collapseCompanyJ">
            <button type="button" class="btn btn-sm btn-outline-primary my-3" data-bs-toggle="modal"
                data-bs-target="#createJobModal">
                Create Job <i class="bi bi-plus-square"></i>
            </button>
            @if(count($jobs) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">City</th>
                        <th scope="col">Category</th>
                        <th scope="col">Schedule</th>
                        <th scope="col">Positions</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Remote</th>
                        <th scope="col">Added</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <th scope="row">{{ $job->id }}</th>
                        <td>
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                href="{{ route('job', ['id' => $job->id]) }}">
                                {{ $job->title }}
                            </a>
                        </td>
                        <td>{{ $job->city->name }}</td>
                        <td>{{ $job->category->name }}</td>
                        <td>{{ $job->schedule->name }}</td>
                        <td>{{ $job->positions }}</td>
                        <td>{{ $job->salary }}</td>
                        <td>{{ $job->remote ? 'Yes' : 'No' }}</td>
                        <td>{{ $job->created_at->format('H:i d-M-Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: green;"
                                data-bs-toggle="modal" data-bs-target="#editJobModal{{ $job->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $job->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- editJobModal -->
                    <div class="modal fade text-light" id="editJobModal{{ $job->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Job</h1>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <input type="text" name="title" class="form-control rounded"
                                                placeholder="Job title..." value="{{ $job->title }}" required>
                                        </div>
                                        <div class="mb-3 d-flex gap-2">
                                            <select name="city_id" class="form-select w-50" required>
                                                <option value="" disabled>Select City</option>
                                                @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ $job->city_id == $city->id ?
                                                    'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <select name="category_id" class="form-select w-50" required>
                                                <option value="" disabled>Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $job->category_id ==
                                                    $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 d-flex gap-3">
                                            <select name="schedule_id" class="form-select w-75" required>
                                                <option value="" disabled>Select Schedule</option>
                                                @foreach ($schedules as $schedule)
                                                <option value="{{ $schedule->id }}" {{ $job->schedule_id ==
                                                    $schedule->id ? 'selected' : '' }}>{{ $schedule->name }}</option>
                                                @endforeach
                                            </select>
                                            <div>
                                                <select name="remote" class="form-select" required>
                                                    <option value="" disabled>Select Remote</option>
                                                    <option value="0" {{ $job->remote === 0 ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="1" {{ $job->remote === 1 ? 'selected' : '' }}>Yes
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Job Description:</label>
                                            <textarea name="description" class="form-control rounded text-start"
                                                required>{{ $job->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="positions" class="form-label">Number of Positions Open:</label>
                                            <input type="number" name="positions" class="form-control rounded"
                                                value="{{ $job->positions }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="salary" class="form-label">Salary:</label>
                                            <input type="number" name="salary" class="form-control rounded"
                                                value="{{ $job->salary }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Save
                                            Changes</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- deleteJobModal -->
                    <div class="modal fade text-light" id="deleteJobModal{{ $job->id }}" data-bs-backdrop="static"
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
                                    <p>Are you sure you want to delete this city - {{ $job->title }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST">
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
                Alert: You haven't added any jobs yet. Take the opportunity to create new job listings and attract
                potential applicants to your positions.
            </div>
            @endif
            <!-- Create Job Modal -->
            <div class="modal fade text-light" id="createJobModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark border">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Job</h1>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span style="color: white;">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('jobs.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="mb-3">
                                    <input type="text" name="title" class="form-control rounded"
                                        placeholder="Job title..." required>
                                </div>
                                <div class="mb-3 d-flex gap-2">
                                    <select name="city_id" class="form-select w-50" required>
                                        <option value="" disabled selected>Select City</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <select name="category_id" class="form-select w-50" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 d-flex gap-3">
                                    <select name="schedule_id" class="form-select w-75" required>
                                        <option value="" disabled selected>Select Schedule</option>
                                        @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->id }}">{{ $schedule->name }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        <select name="remote" class="form-select" required>
                                            <option value="" disabled selected>Remote</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Job Description:</label>
                                    <textarea name="description" class="form-control rounded" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="positions" class="form-label">Number of Positions Open:</label>
                                    <input type="number" name="positions" class="form-control rounded" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary:</label>
                                    <input type="number" name="salary" class="form-control rounded" required>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Create Job</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <p class="d-inline-flex gap-1 mb-3">
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