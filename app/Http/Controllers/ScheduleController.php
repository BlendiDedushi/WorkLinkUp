<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return $schedules;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:schedules|max:100'
        ]);

        try {
            Schedule::create($validatedData);
            return redirect()->route('dashboard')->with('success', 'Schedule created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while creating the schedule.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100'
        ]);

        $schedule = Schedule::findOrFail($id);

        try {
            $schedule->update($validatedData);
            return redirect()->route('dashboard')->with('success', 'Schedule was updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while editing the schedule.');
        }
    }

    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        try {
            $schedule->delete();
            return redirect()->route('dashboard')->with('success', 'Schedule was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the schedule.');
        }
    }
}
