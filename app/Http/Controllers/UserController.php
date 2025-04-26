<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('user', [
            'title' => 'User',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:50',
            'username' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Administrator,Waiter,Cashier,Owner',
        ]);

        User::create([
            'full_name' => $validated['fullName'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:50',
            'username' => 'required|string|max:20',
            'role' => 'required|in:Administrator,Waiter,Cashier,Owner',
        ]);

        $user = User::findOrFail($id);
        $user->full_name = $validated['fullName'];
        $user->username = $validated['username'];
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }
}
