<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return view('admin.user_list', compact('users'));
    }

    public function create()
    {
        return view('admin.create_user');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => ['required', 'in:1,2,3'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user.edit', $user->id)->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        if (Gate::denies('admin-only', Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.create_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        //using gates
        if (Gate::denies('admin-only', Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Allow null for password updates, no need to fill password while updating users.
            'role_id' => ['required', 'in:1,2,3'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        $user->name = $validator->validated()['name'];
        $user->email = $validator->validated()['email'];

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validator->validated()['password']);
        }

        $user->role_id = $validator->validated()['role_id'];

        $user->save();

        return redirect()->route('user.edit', $user->id)->with('success', 'User Updated successfully!');
    }

    public function delete($id)
    {
        // Check if the authenticated user is an admin
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::findOrFail($id);

        //deleting the users directly instead of setting a flag variable false.
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
