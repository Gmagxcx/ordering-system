<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a list of all users
    public function index()
    {
        $users = User::all(); // Retrieve all users from the database

        // Count the number of users by access level
        $totalUsers = $users->count();
        $regularUsers = $users->where('access', 'user')->count();
        $employees = $users->where('access', 'employee')->count();
        $administrators = $users->where('access', 'admin')->count();

        $users = User::paginate(2);
        
        return view('admin_viewUsers', compact('users', 'totalUsers', 'regularUsers', 'employees', 'administrators')); // Return view with users data
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
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    // Delete a specific user
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID

        $user->delete(); // Delete the user

        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
