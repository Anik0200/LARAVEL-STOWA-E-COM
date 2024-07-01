<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    //All Roles
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(5);
        return view('backend.RolePermision.index', compact('roles'));
    }

    //Create Roles From
    public function createRole()
    {
        $permission = Permission::all();
        return view('backend.RolePermision.create', compact('permission'));
    }

    //Insert Roles
    public function insertRole(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
            ],
            [
                'name' => 'This Field Is Required',
            ]
        );

        $roleId = Role::create([

            'name' => $request->name,

        ]);

        $roleId->givePermissionTo([$request->permission]);

        return redirect(route('backend.role.index'))->with('success', 'Create Successfull!');
    }

    //Edit Roles
    public function editRole(Request $request, $id)
    {
        $role        = Role::find($id);
        $permissions = Permission::all();
        return view('backend.RolePermision.editRole', compact('permissions', 'id', 'role'));
    }

    //Update Roles
    public function updatetRole(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
            ],
            [
                'name' => 'This Field Is Required',
            ]
        );

        $role = Role::find($id);

        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions([$request->permission]);

        return redirect(route('backend.role.index'))->with('success', "Edit Successfull!");
    }

    //Delete Roles
    public function deleteRole(Request $request, $id)
    {

        $role = Role::find($id);
        $role->delete();

        return redirect(route('backend.role.index'))->with('success', "Delete Successfull!");
    }

    //All User
    public function users()
    {
        $allUsers = User::withTrashed()->paginate(5);
        return view('backend.RolePermision.users', compact('allUsers'));
    }

    //Edit User
    public function editUser(Request $request, $id)
    {
        $user  = User::find($id);
        $roles = Role::all();
        return view('backend.RolePermision.userEdit', compact('id', 'user', 'roles'));
    }

    //Update User
    public function updatetUser(Request $request, $id)
    {
        $request->validate(
            [
                'name'  => 'required|max:100',
                'email' => 'required|max:100',
            ],
            [
                'name'  => 'This Field Is Required',
                'email' => 'This Field Is Required',
            ]
        );

        $user = User::find($id);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return redirect(route('backend.role.users'))->with('success', "Edit Successfull!");
    }

    //Delete User
    public function userDelete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect(route('backend.role.users'))->with('success', "Delete Successfull!");
    }

    //Undo User
    public function userUndo(Request $request, $id)
    {
        $user = User::onlyTrashed()->find($id);

        $user->restore();

        return redirect(route('backend.role.users'))->with('success', "Undo Successfull!");
    }

    //Destroy User
    public function userDestroy(Request $request, $id)
    {
        $user = User::onlyTrashed()->find($id);

        $user->forceDelete();

        return redirect(route('backend.role.users'))->with('success', "Permanently Deletd!");
    }

    //All Permission
    public function allPermission()
    {
        $permissions = Permission::paginate(5);
        return view('backend.RolePermision.allPermission', compact('permissions'));
    }

    //Insert Permission
    public function insertPermission(Request $request)
    {

        $request->validate(
            [
                'permissionName' => 'required|max:10',
            ],
            [
                'permissionName' => 'This Field Is Required',
            ]
        );

        Permission::create([
            'name' => $request->permissionName,
        ]);

        return redirect(route('backend.role.permission.index'))->with('success', 'Create Successfull!');
    }

    //Edit Permission
    public function editPermission(Request $request, $id)
    {
        $permission = Permission::find($id);
        return view('backend.RolePermision.editPermission', compact('id', 'permission'));
    }

    //Update Permission
    public function updatePermission(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
            ],
            [
                'name' => 'This Field Is Required',
            ]
        );

        $permission = Permission::find($id);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect(route('backend.role.permission.index'))->with('success', "Edit Successfull!");
    }

    //Delete Permission
    public function deletePermission(Request $request, $id)
    {
        $permission = Permission::find($id);

        $permission->delete();

        return redirect(route('backend.role.permission.index'))->with('success', "Delete Successfull!");
    }
}
