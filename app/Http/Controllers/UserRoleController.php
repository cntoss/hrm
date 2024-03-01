<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleController extends ApiController
{
    public function assignRole(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        // Retrieve the user
        $user = User::findOrFail($request->input('user_id'));

        // Retrieve the role
        $role = Role::where('name', $request->input('role_name'))->first();

        // Assign the role to the user
        $user->assignRole($role);
         return $this->successResponse(
            "Role assigned successfully.",
             $user);
    }
    public function getRoles(){
        $roles = Role::all();
        return $this->successResponse(['Roles Fetched successfully', $roles]);
    }

    public function getPermissions(){
        $permissions = Permission::all();
        return $this->successResponse(['Permissions Fetched successfully', $permissions]);
    }

}
