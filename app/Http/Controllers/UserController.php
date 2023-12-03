<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $authenticatedUser = auth()->user();

        if ($authenticatedUser->hasRole('admin')) {
            return view('shared.users.show', compact('user'));
        }

        if ($authenticatedUser->hasRole('company')) {
            if (
                $authenticatedUser->id === $user->id || $authenticatedUser->jobs->flatMap(function ($job) {
                    return $job->applications;
                })->where('user_id', $user->id)->isNotEmpty()
            ) {
                return view('shared.users.show', compact('user'));
            }
        }

        if ($authenticatedUser->hasRole('user') && $authenticatedUser->id === $user->id) {
            return view('shared.users.show', compact('user'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to view this user.');
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

    public function addPdf(Request $request)
    {
        try {
            $request->validate([
                'pdf' => 'required|mimes:pdf|max:2048',
            ]);

            $user = auth()->user();

            $emailPrefix = explode('@', $user->email)[0];

            $filename = $request->file('pdf')->storeAs('pdfs', $emailPrefix . '.pdf', 'public');

            $user->filename = $filename;
            $user->save();

            return redirect()->back()->with('success', 'PDF file added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading PDF file: ' . $e->getMessage());
        }
    }

    public function updatePdf(Request $request)
    {
        try {
            $request->validate([
                'pdf' => 'required|mimes:pdf|max:2048',
            ]);

            $user = auth()->user();
            $emailPrefix = explode('@', $user->email)[0];

            Storage::disk('public')->delete($user->filename);

            $filename = $request->file('pdf')->storeAs('pdfs', $emailPrefix . '_updated.pdf', 'public');

            $user->filename = $filename;
            $user->save();

            return redirect()->back()->with('success', 'PDF file updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating PDF file: ' . $e->getMessage());
        }
    }

    public function deletePdf()
    {
        try {
            $user = auth()->user();
            Storage::disk('public')->delete($user->filename);

            $user->filename = null;
            $user->save();

            return redirect()->back()->with('success', 'PDF file deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting PDF file: ' . $e->getMessage());
        }
    }



    public function downloadPdf(string $id)
    {
        $user = User::findOrFail($id);

        $authenticatedUser = auth()->user();
        if (!$authenticatedUser->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        if ($user->filename) {
            $filePath = storage_path("app/public/{$user->filename}");

            $filenamePrefix = explode('/', $user->filename)[1];

            if (file_exists($filePath)) {
                return response()->download($filePath, $filenamePrefix);
            } else {
                abort(404, 'PDF file not found for the user');
            }
        } else {
            abort(404, 'PDF file not found for the user');
        }
    }

}
