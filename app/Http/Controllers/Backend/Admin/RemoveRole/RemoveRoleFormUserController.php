<?php

namespace App\Http\Controllers\Backend\Admin\RemoveRole;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RemoveRoleFormUserController extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, Role $role) {
        if ($user->removeRole($role) == true) {
            return back()->with('success', 'Remove deleted successfully.');
        } else {
            return back()->with('failed', 'Remove deleted failed.');
        }
    }
}
