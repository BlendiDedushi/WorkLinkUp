<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:schedules|max:100'
        ]);

        try {
            Category::create($validatedData);
            return redirect()->route('dashboard')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while creating the category.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100'
        ]);

        $category = Category::findOrFail($id);

        try {
            $category->update($validatedData);
            return redirect()->route('dashboard')->with('success', 'Category was updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while editing the category.');
        }
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();
            return redirect()->route('dashboard')->with('success', 'Category was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the category.');
        }
    }
}
