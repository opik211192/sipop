<?php

namespace App\Http\Controllers\Assign;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AssignToUserController extends Controller
{
    public function create()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('assign.assigntouser', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'roles' => 'array|required',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::find($request->input('user'));
        if (!$user) {
            return back()->withErrors(['user' => 'User not found.']);
        }

        $role = Role::whereIn('id', $request->input('roles'))->get();
        $user->syncRoles($role);

        return back()->with('success', "Roles have been assigned to the user {$user->name}");
    }
}
