<?php

namespace App\Http\Controllers\Backend\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\PermissionRequest;
use App\Http\Resources\Admin\Permission\PermissionResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller {
    public function index(Request $request): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Permission/PermissionIndex', ['permissions' => PermissionResource::collection(Permission::all())]);
    }

    public function store(PermissionRequest $request) {
        $request->validated();

        $permission = Permission::create([
            'name' => $request->permission_name,
            'created_at' => Carbon::now(),
        ]);

        if ($permission == true) {
            return to_route('permission.index')->with('success', 'Permission created successfully.');
        } else {
            return to_route('permission.index')->with('failed', 'Permission created failed.');
        }
    }

    public function edit(Request $request, $permission_id): Response {
        $permission = Permission::findById($permission_id);
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Permission/Edit', ['permission' => new PermissionResource($permission)]);
    }

    public function update(PermissionRequest $request, $permission_id): RedirectResponse {
        $permission = Permission::findById($permission_id);

        $result = $permission->update([
            'name' => $request->permission_name,
            'updated_at' => Carbon::now(),
        ]);

        if ($result == true) {
            return to_route('permission.index')->with('success', 'Permission updated successfully.');
        } else {
            back()->with('failed', 'Permission updated failed.');
        }
    }

    public function destroy($permission_id): RedirectResponse {
        $permission = Permission::findById($permission_id);

        if ($permission->delete() == true) {

            return to_route('permission.index')->with('success', 'Permission deleted successfully.');

        } else {

            return to_route('permission.index')->with('failed', 'Permission deleted failed.');
        }
    }
}
