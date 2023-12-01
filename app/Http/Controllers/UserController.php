<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'role' => 'required|exists:roles,id',
        ]);
    
        $user = User::findOrFail($id);
    
        $roleId = (int) $request->input('role');
    
        $user->syncRoles([$roleId]);
    
        return redirect()->route('dashboard')->with('success', 'User role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            return redirect()->route('dashboard')->with('success', 'User was deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while deleting the user.');
        }
    }
}
