<?php

namespace App\Http\Controllers\Backend\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
        $users = User::where('id', '!=', Auth::id())->get();
        $total_users = User::count();
        return Inertia::render('Admin/User/UserIndex', compact('users', 'total_users'));
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
