<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {
        $jobs = Job::all();

        return view("shared.jobs.index", ["jobs" => $jobs]);
    }

    public function dashboard(CityController $cityController, CategoryController $categoryController, ScheduleController $scheduleController, ApplicationController $applicationController, UserController $userController)
    {
        if (auth()->user()->hasRole('company')) {
            $jobs = Job::where('user_id', auth()->id())->get();
            $applications = Application::whereHas('job', function ($query) use ($jobs) {
                $query->whereIn('user_id', $jobs->pluck('user_id'));
            })->get();

            return view('dashboard', ["jobs" => $jobs, "applications" => $applications]);
        } else if (auth()->user()->hasRole('admin')) {
            $users = $userController->index();
            $jobs = Job::all();
            $cities = $cityController->index();
            $categories = $categoryController->index();
            $schedules = $scheduleController->index();
            $applications = $applicationController->index();

            return view('dashboard', ["users" => $users,"jobs" => $jobs, "cities" => $cities, "categories" => $categories, "schedules" => $schedules,"applications" => $applications]);
        } else {
            $applications = Application::where('user_id', auth()->id())->get();

            return view('dashboard', ["applications" => $applications]);
        }
    }

    public function create()
    {
        return view("jobs.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $job = Job::findOrFail($id);

        return view('shared.jobs.show', ['job' => $job]);
    }

    public function edit(string $id)
    {
        return view("jobs.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
