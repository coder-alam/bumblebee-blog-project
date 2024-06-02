<?php

namespace App\Http\Controllers\Backend\Admin\RevokePermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RevokePermissionFormUserController extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, Permission $permission) {
//        $user->revokePermissionTo($permission);
        if ($user->revokePermissionTo($permission) == true) {
            return back()->with('success', 'Permission deleted successfully.');
        } else {
            return back()->with('failed', 'Permission deleted failed.');
        }
    }
}
