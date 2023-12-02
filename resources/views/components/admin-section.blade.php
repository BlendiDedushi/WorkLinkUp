<section class="container my-5 d-flex flex-column gap-3">
    <div>
        <div class="d-flex justify-content-between">
            <p class="d-inline-flex gap-1">
                <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseAdminU" aria-expanded="true" aria-controls="collapseAdminU">
                    Users { {{ count($users) }} }
                </button>
            </p>
             <!-- notification for role update -->
           {{--  @if(count($pendingApplications) > 0)
                <div>
                    <button type="button" class="btn btn-outline-light position-relative rounded-circle text-danger"
                        id="notifyButton" data-bs-toggle="modal" data-bs-target="#notificationModal">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                            id="notificationBadge">
                            {{ count($pendingApplications) }}
                        </span>
                    </button>
                    <div class="modal fade text-light" id="notificationModal" tabindex="-1"
                        aria-labelledby="notificationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach($pendingApplications as $application)
                                    <p><b>{{ $application->user->email }}</b> applied for <b>{{ $application->job->title
                                            }}</b>
                                        {{ $application->created_at->diffForHumans() }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
        </div>
        <div class="collapse show mt-3" id="collapseAdminU">
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-warning"
                                href="{{ route('user', $user->id) }}">
                                {{ $user->email }} <i class="bi bi-box-arrow-in-right"></i>
                            </a>
                        </td>
                        <td><b>{{ strtoupper($user->getRoleNames()->implode(', ')) }}</b></td>
                        <td>{{ $user->created_at->format('H:i d-M-Y') }}</td>
                        @if($user->id !== auth()->user()->id)
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: green;"
                                data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                        @else
                        <td class="text-center">
                        </td>
                        <td class="text-center">
                        </td>
                        @endif
                    </tr>
                    <!-- editUserModal -->
                    <div class="modal fade text-light" id="editUserModal{{ $user->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User Role</h1>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <p class="mb-2">{{ $user->email }}</p>
                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <select name="role" id="roles" class="form-select form-select-sm w-50"
                                                required>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ?
                                                    'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-light"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- deleteUserModal -->
                    <div class="modal fade text-light" id="deleteUserModal{{ $user->id }}" data-bs-backdrop="static"
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
                                    <p>Are you sure you want to delete this user - {{ $user->email }} ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
        </div>
    </div>

    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseCompanyJ" aria-expanded="true" aria-controls="collapseCompanyJ">
                Jobs { {{ count($jobs) }} }
            </button>
        </p>
        <div class="collapse show mt-3" id="collapseCompanyJ">
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
                        <th scope="col" class="text-center">Delete</th>
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
                            <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-warning"
                                href="{{ route('job', ['id' => $job->id]) }}">
                                {{ $job->title }} <i class="bi bi-box-arrow-in-right"></i>
                            </a>
                        </td>
                        <td>{{ $job->positions }}</td>
                        <td>{{ $job->salary }}</td>
                        <td>{{ $job->remote ? 'Yes' : 'No' }}</td>
                        <td>{{ $job->created_at->format('H:i d-M-Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $job->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                    </tr>
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
                                    <p>Are you sure you want to delete this job - {{ $job->title }} ?</p>
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
        <div class="collapse show mt-3" id="collapseAdminA">
            @if(count($applications) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Job</th>
                        <th scope="col">Company</th>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <th scope="row">{{ $application->id }}</th>
                        <!-- App\Models\User::where('id',$application->user_id)->first()->email -->
                        <td>{{ $application->user->email }}</td>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->job->user->email }}</td>
                        <td>{{ $application->created_at->format('H:i d-M-Y') }}</td>
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
                Attention: No applications have been made by users for any jobs yet. Feel free to check back later.
            </div>
            @endif
        </div>
    </div>
    <div>
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseAdminC" aria-expanded="false" aria-controls="collapseAdminC">
                Categories { {{ count($categories) }} }
            </button>
        </p>
        <div class="collapse w-50" id="collapseAdminC">
            <button type="button" class="btn btn-sm btn-outline-primary my-3" data-bs-toggle="modal"
                data-bs-target="#createCategoryModal">
                Create Category <i class="bi bi-plus-square"></i>
            </button>
            @if(count($categories) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at->format('H:i d-M-Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: green;"
                                data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- editCategoryModal -->
                    <div class="modal fade text-light" id="editCategoryModal{{ $category->id }}"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category</h1>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="name">Category Name:</label>
                                        <input type="text" name="name" value="{{ $category->name }}"
                                            class="rounded text-dark" required>
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
                    <!-- deleteCategoryModal -->
                    <div class="modal fade text-light" id="deleteCategoryModal{{ $category->id }}"
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
                                    <p>Are you sure you want to delete this category - {{ $category->name }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
                Attention: There are currently no categories available. Please add some categories to enhance your
                job
                listings.
            </div>
            @endif
            <!-- Create Category Modal -->
            <div class="modal fade text-light" id="createCategoryModal" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark border">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Category</h1>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span style="color: white;">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <label for="name">Category Name:</label>
                                <input type="text" name="name" class="rounded text-dark" required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Create
                                    Category</button>
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
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseAdminCt" aria-expanded="false" aria-controls="collapseAdminCt">
                Cities { {{ count($cities) }} }
            </button>
        </p>
        <div class="collapse w-50" id="collapseAdminCt">
            <button type="button" class="btn btn-sm btn-outline-primary my-3" data-bs-toggle="modal"
                data-bs-target="#createCityModal">
                Create City <i class="bi bi-plus-square"></i>
            </button>
            @if(count($cities) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                    <tr>
                        <th scope="row">{{ $city->id }}</th>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->created_at->format('H:i d-M-Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: green;"
                                data-bs-toggle="modal" data-bs-target="#editCityModal{{ $city->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteCityModal{{ $city->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- editCityModal -->
                    <div class="modal fade text-light" id="editCityModal{{ $city->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit City</h1>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('cities.update', $city->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="name">City Name:</label>
                                        <input type="text" name="name" value="{{ $city->name }}"
                                            class="rounded text-dark" required>
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
                    <!-- deleteCityModal -->
                    <div class="modal fade text-light" id="deleteCityModal{{ $city->id }}" data-bs-backdrop="static"
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
                                    <p>Are you sure you want to delete this city - {{ $city->name }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
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
                Attention: There are currently no cities available. Please add some cities to enhance your job
                listings.
            </div>
            @endif
            <!-- Create City Modal -->
            <div class="modal fade text-light" id="createCityModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark border">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create City</h1>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span style="color: white;">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('cities.store') }}" method="POST">
                                @csrf
                                <label for="name">City Name:</label>
                                <input type="text" name="name" class="rounded text-dark" required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Create
                                    City</button>
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
        <p class="d-inline-flex gap-1">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseAdminS" aria-expanded="false" aria-controls="collapseAdminS">
                Schedules { {{ count($schedules) }} }
            </button>
        </p>
        <div class="collapse w-50" id="collapseAdminS">
            <button type="button" class="btn btn-sm btn-outline-primary my-3" data-bs-toggle="modal"
                data-bs-target="#createScheduleModal">
                Create Schedule <i class="bi bi-plus-square"></i>
            </button>
            @if(count($schedules) > 0)
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <tr>
                        <th scope="row">{{ $schedule->id }}</th>
                        <td>{{ $schedule->name }}</td>
                        <td>{{ $schedule->created_at->format('H:i d-M-Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: green;"
                                data-bs-toggle="modal" data-bs-target="#editScheduleModal{{ $schedule->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link" style="padding: 0; color: red;"
                                data-bs-toggle="modal" data-bs-target="#deleteScheduleModal{{ $schedule->id }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                        </td>
                    </tr>
                    <!-- editScheduleModal -->
                    <div class="modal fade text-light" id="editScheduleModal{{ $schedule->id }}"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark border">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Schedule</h1>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span style="color: white;">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="name">Schedule Name:</label>
                                        <input type="text" name="name" value="{{ $schedule->name }}"
                                            class="rounded text-dark" required>
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
                    <!-- deleteScheduleModal -->
                    <div class="modal fade text-light" id="deleteScheduleModal{{ $schedule->id }}"
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
                                    <p>Are you sure you want to delete this schedule - {{ $schedule->name }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST">
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
                Attention: There are currently no schedules available. Please add some schedules to enhance your job
                listings.
            </div>
            @endif
            <!-- Create Schedule Modal -->
            <div class="modal fade text-light" id="createScheduleModal" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark border">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Schedule</h1>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span style="color: white;">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('schedules.store') }}" method="POST">
                                @csrf
                                <label for="name">Schedule Name:</label>
                                <input type="text" name="name" class="rounded text-dark" required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Create
                                    Schedule</button>
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
</section>