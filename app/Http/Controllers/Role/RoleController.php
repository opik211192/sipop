<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role.role', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        return response()->json(['success' => 'Role created successfully.', 'role' => $role]);
    }

    public function edit(Role $role)
    {
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->name;
        $role->guard_name = $request->guard_name ?? 'web'; // Default to 'web'
        $role->save();

        return response()->json(['success' => 'Role updated successfully.', 'role' => $role]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
