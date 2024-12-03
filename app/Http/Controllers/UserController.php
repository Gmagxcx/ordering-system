<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a list of all users
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $users = User::where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('access', 'like', "%$search%")
                ->paginate(10);
        } else {
            $users = User::paginate(10);
        }

        // Count the number of users by access level
        $totalUsers = User::count();
        $regularUsers = User::where('access', 'user')->count();
        $employees = User::where('access', 'employee')->count();
        $administrators = User::where('access', 'admin')->count();

        return view('admin_viewUsers', compact('users', 'totalUsers', 'regularUsers', 'employees', 'administrators'));
    }

    // Show the form for editing a specific user
    public function edit($id)
    {
        $user = User::findOrFail($id); // Find the user by ID or fail

        return view('admin_editUser', compact('user')); // Return the edit view with user data
    }

    // Update the user information
    public function update(Request $request, $id)
    {
        // Validate the request input
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'access' => 'required|in:admin,employee',
        ]);

        // Find and update the user
        $user = User::findOrFail($id);
        $user->update($validated);

        // Redirect back with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // Delete a specific user
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID

        $user->delete(); // Delete the user

        // Redirect back with success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
