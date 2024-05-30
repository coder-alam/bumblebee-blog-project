<?php

namespace App\Http\Controllers\Backend\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleRequest;
use App\Http\Resources\Admin\Permission\PermissionResource;
use App\Http\Resources\Admin\Role\RoleResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {
    public function index(Request $request): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Role/RoleIndex', ['roles' => RoleResource::collection(Role::all())]);
    }

    public function store(RoleRequest $request) {

        $role = Role::create(['name' => $request->role_name]);
        if ($role == true) {
            return to_route('role.index')->with('success', 'Role created successfully.');
        } else {
            to_route('role.index')->with('failed', ' Role created failed.');
        }

    }

    public function edit($role_id): Response {
        $role = Role::findById($role_id);

        Inertia::setRootView('admin');
        return Inertia::render('Admin/Role/Edit', [
            'role' => new RoleResource($role),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    public function update(RoleRequest $request, $role_id): RedirectResponse {
//        $request->validated();
        $role = Role::findById($role_id);

        $result = $role->update([
            'name' => $request->role_name,
            'updated_at' => Carbon::now()
        ]);
        $role->syncPermissions($request->input('permissions.*.name'));
        if ($result == true) {
            return to_route('role.index')->with('success', 'Role updated successfully.');
        } else {
            back()->with('failed', 'Role updated failed.');
        }
    }

    public function destroy($role_id): RedirectResponse {
        $role = Role::findById($role_id);

        if ($role->delete() == true) {
            return to_route('role.index')->with('success', 'Role deleted successfully.');
        } else {
            return to_route('role.index')->with('failed', 'Role deleted failed.');
        }
    }

}
