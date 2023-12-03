<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return $cities;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:cities|max:100'
        ]);

        try {
            City::create($validatedData);
            return redirect()->route('dashboard')->with('success', 'City created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('cities.create')->with('error', 'An error occurred while creating the city.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100'
        ]);

        $city = City::findOrFail($id);

        try {
            $city->update($validatedData);
            return redirect()->route('dashboard')->with('success', 'City was updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while editing the city.');
        }
    }

    public function destroy(string $id)
    {
        $city = City::findOrFail($id);

        try {
            $city->delete();
            return redirect()->route('dashboard')->with('success', 'City was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the city.');
        }
    }
}
