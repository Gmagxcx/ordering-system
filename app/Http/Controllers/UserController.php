<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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

        $totalUsers = User::count();
        $regularUsers = User::where('access', 'user')->count();
        $employees = User::where('access', 'employee')->count();
        $administrators = User::where('access', 'admin')->count();

        return view('admin_viewUsers', compact('users', 'totalUsers', 'regularUsers', 'employees', 'administrators'));
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
            'access' => 'required|in:admin,employee,user',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
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
}
