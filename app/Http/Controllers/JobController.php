<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\City;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ApplicationController;

class JobController extends Controller
{
    public function __construct(CityController $cityController, CategoryController $categoryController, ScheduleController $scheduleController, ApplicationController $applicationController, UserController $userController)
    {
        $this->userController = $userController;
        $this->cityController = $cityController;
        $this->categoryController = $categoryController;
        $this->scheduleController = $scheduleController;
        $this->applicationController = $applicationController;
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        $cityId = $request->input('city');
        $categoryId = $request->input('category');

        $jobs = Job::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('title', 'like', '%' . $query . '%');
        })
        ->when($cityId, function ($queryBuilder) use ($cityId) {
            $queryBuilder->where('city_id', $cityId);
        })
        ->when($categoryId, function ($queryBuilder) use ($categoryId) {
            $queryBuilder->where('category_id', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $cities = City::all();
        $categories = Category::all();

        return view("shared.jobs.index", [
            "jobs" => $jobs,
            "query" => $query,
            "cities" => $cities,
            "categories" => $categories,
        ]);
    }

    public function dashboard(CityController $cityController, CategoryController $categoryController, ScheduleController $scheduleController, ApplicationController $applicationController, UserController $userController)
    {
        if (auth()->user()->hasRole('company')) {
            $jobs = Job::where('user_id', auth()->id())->get();
            $applications = Application::whereHas('job', function ($query) use ($jobs) {
                $query->whereIn('user_id', $jobs->pluck('user_id'));
            })->get();
            $pendingApplications = Application::whereHas('job', function ($query) use ($jobs) {
                $query->whereIn('user_id', $jobs->pluck('user_id'));
            })->where('status', 'Pending')->get();

            $cities = $cityController->index();
            $categories = $categoryController->index();
            $schedules = $scheduleController->index();

            return view('dashboard', compact('jobs', 'applications', 'cities', 'categories', 'schedules', 'pendingApplications'));
        } else if (auth()->user()->hasRole('admin')) {
            $users = $userController->index();
            $jobs = Job::all();
            $cities = $cityController->index();
            $categories = $categoryController->index();
            $schedules = $scheduleController->index();
            $applications = $applicationController->index();
            $roles = Role::all();

            return view('dashboard', compact('users', 'roles', 'jobs', 'cities', 'categories', 'schedules', 'applications'));
        } else {
            $applications = Application::where('user_id', auth()->id())->get();

            return view('dashboard', ["applications" => $applications]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $validatedData = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'schedule_id' => 'required|exists:schedules,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'positions' => 'required|integer|min:1',
            'salary' => 'required|numeric|min:0',
            'remote' => 'nullable|boolean',
        ]);

        $validatedData['user_id'] = $user_id;

        try {
            Job::create($validatedData);
            return redirect()->route('dashboard')->with('success', 'Job created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while creating the job.');
        }

    }

    public function show(string $id)
    {
        $job = Job::findOrFail($id);
        $user = auth()->user();
        $existingApplication = Application::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->first();

        return view('shared.jobs.show', compact('job', 'existingApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'schedule_id' => 'required|exists:schedules,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'positions' => 'required|integer|min:1',
            'salary' => 'required|numeric|min:0',
            'remote' => 'nullable|boolean',
        ]);

        $job = Job::findOrFail($id);

        try {
            $job->update($validatedData);
            return redirect()->route('dashboard')->with('success', 'Job was updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while editing the job.');
        }
    }

    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        try {
            $job->delete();
            return redirect()->route('dashboard')->with('success', 'Job was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the job.');
        }
    }
}
