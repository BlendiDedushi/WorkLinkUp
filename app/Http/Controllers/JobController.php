<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy("id","desc")->paginate(10);
        return view("shared.jobs.index", ["jobs"=> $jobs]);
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

    // public function getAllJobs(){
    //     if(auth()->user()->hasRole("admin")){
    //         $jobs = Job::all();
    //         return view("dashboard", ["jobs"=> $jobs]);
    //     }
    // }
}
