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

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $authenticatedUser = auth()->user();
    
        if ($authenticatedUser->hasRole('admin')) {
            return view('shared.users.show', compact('user'));
        }
    
        if ($authenticatedUser->hasRole('company')) {
            if ($authenticatedUser->id === $user->id || $authenticatedUser->jobs->flatMap(function ($job) {
                return $job->applications;
            })->where('user_id', $user->id)->isNotEmpty()) {
                return view('shared.users.show', compact('user'));
            }
        }
    
        if ($authenticatedUser->hasRole('user') && $authenticatedUser->id === $user->id) {
            return view('shared.users.show', compact('user'));
        }
    
        return redirect()->route('dashboard')->with('error', 'You do not have permission to view this user.');
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
