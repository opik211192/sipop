<?php

namespace App\Http\Controllers\Assign;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AssignController extends Controller
{
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $rolesWithPermissions = Role::with('permissions')->get(); // Menambahkan untuk tabel

        return view('assign.assigntopermission', [
            'roles' => $roles,
            'permissions' => $permissions,
            'rolesWithPermissions' => $rolesWithPermissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'array|required',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::find($request->input('role'));
        if (!$role) {
            return back()->withErrors(['role' => 'Role not found.']);
        }

        $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
        $role->syncPermissions($permissions);

        return back()->with('success', "Permissions have been assigned to the role {$role->name}");
    }
}
