<?php

namespace App\Http\Controllers\Backend\Admin\RevokePermission;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RevokePermissionFormRoleController extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role_id, Permission $permission_id) {

        if ($role_id->revokePermissionTo($permission_id) == true) {
            return back()->with('success', 'Role & Permission deleted successfully.');
        } else {
            return back()->with('failed', 'Role & Permission deleted failed.');
        }
    }
}
