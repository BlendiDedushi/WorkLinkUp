<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::all();

        return $applications;
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $existingApplication = Application::where('user_id', $user_id)
            ->where('job_id', $request->job_id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('dashboard')->with('error', 'You have already applied for this job.');
        }

        $validatedData = $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $validatedData['user_id'] = $user_id;

        try {
            Application::create($validatedData);
            return redirect()->route('dashboard')->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:Approved,Pending,Declined',
        ]);

        $application = Application::findOrFail($id);

        try {
            $application->update($validatedData);
            return redirect()->route('dashboard')->with('success', 'Application was updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while editing the application.');
        }
    }

    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);

        try {
            $application->delete();
            return redirect()->route('dashboard')->with('success', 'Application was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the application.');
        }
    }
}
