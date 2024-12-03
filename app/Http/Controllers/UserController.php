<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); 

        $totalUsers = $users->count();
        $regularUsers = $users->where('access', 'user')->count();
        $employees = $users->where('access', 'employee')->count();
        $administrators = $users->where('access', 'admin')->count();

        $users = User::paginate(10);
        
        return view('admin_viewUsers', compact('users', 'totalUsers', 'regularUsers', 'employees', 'administrators')); // Return view with users data
    }

    public function showProfile()
    {
        $user = Auth::user();
        $orders = Order::with('items.product') 
            ->where('user_id', $user->id)
            ->orderByDesc('order_date')
            ->get();

        return view('profile', compact('orders'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); 

        return view('admin_editUser', compact('user')); 
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'access' => 'required|in:admin,employee',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); 
        $user->delete();  

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
