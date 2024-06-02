<?php

namespace App\Http\Controllers\Backend\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Permission\PermissionResource;
use App\Http\Resources\Admin\Role\RoleResource;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
//        $users = User::where('id', '!=', Auth::id())->get();
        $users = User::all();
        $users->load(['roles', 'permissions']);
        $total_users = User::count();
        return Inertia::render('Admin/User/UserIndex', [
            'users' => $users,
            'total_users' => $total_users,
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all())
        ],

        );
    }

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['sometimes', 'array'],
            'permissions' => ['sometimes', 'array'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));
        if ($user == true) {
            return back()->with('success', 'User created successfully.');
        } else {
            return back()->with('failed', 'Unable to create user.');
        }
    }

    public function edit(Request $request, $user_id): Response {
        $user = User::find($user_id);
        $user->load(['roles', 'permissions']);
        Inertia::setRootView('admin');
        return Inertia::render('Admin/User/Edit', [
                'user' => new UserResource($user),
                'roles' => RoleResource::collection(Role::all()),
                'permissions' => PermissionResource::collection(Permission::all())
            ]
        );
    }

    public function update(Request $request, $user_id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|' . Rule::unique('users', 'email')->ignore($user_id),
            'roles' => ['sometimes', 'array'],
            'permissions' => ['sometimes', 'array'],

        ]);

        $user = User::find($user_id);
        $result = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
        ]);
        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));

        if ($result == true) {
            return back()->with('success', 'User updated successfully.');
        } else {
            return back()->with('failed', 'User failed to update.');
        }
    }


    public function destroy($user_id) {
        $user = User::find($user_id);
        if ($user->photo == NULL) {
            if ($user->delete() == true) {
                return back()->with('success', 'User Deleted Successfully');
            } else {
                return back()->with('failed', 'User Deleted Failed!');
            }
        } else {
            $photo_path = public_path('storage/uploads/user/' . $user->photo);
            unlink($photo_path);
            if ($user->delete() == true) {
                return back()->with('success', 'User Deleted Successfully');
            } else {
                return back()->with('failed', 'User Deleted Failed!');
            }
        }
    }
}
