<?php

namespace App\Http\Controllers\Backend\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UseProfilerController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/User/UserProfile', ['user' => Auth::user()]);
    }

    public function profile_photo(Request $request) {
        $request->validate([
            'avatar' => 'required|mimes:jpg,png|max:360',
        ]);
        if (Auth::user()->photo == '') {
            $file_upload = $request->file('avatar');
            $extension = $file_upload->getClientOriginalExtension();
            $file_name = Str::lower(str_replace([' ', '.'], ['-', '-'], Auth::user()->name)) . "." . $extension;
            $path = $request->file('avatar')->storeAs('public/uploads/user', $file_name);
            $result = User::find(Auth::id())->update([
                'photo' => $file_name,
                'updated_at' => Carbon::now(),
            ]);

            if ($result == true) {
                return back()->with('success', 'Image Uploaded Successfully');
            } else {
                return back()->with('failed', 'Uploaded Failed');
            }
        } else {
            $user_id = User::findOrFail(Auth::user()->id);
            $current_img = public_path('storage/uploads/user/' . $user_id->photo);
            unlink($current_img);

            $file_upload = $request->file('avatar');
            $extension = $file_upload->getClientOriginalExtension();

            $file_name = Str::lower(str_replace([' ', '.'], ['-', '-'], Auth::user()->name)) . "." . $extension;
            $path = $request->file('avatar')->storeAs('public/uploads/user', $file_name);
            $result = User::find(Auth::id())->update([
                'photo' => $file_name,
                'updated_at' => Carbon::now(),
            ]);

            if ($result == true) {
                return back()->with('success', 'Image Uploaded Successfully');
            } else {
                return back()->with('failed', 'Uploaded Failed');
            }
        }

    }

    public function update(Request $request, $id) {

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|lowercase|email|max:255|' . Rule::unique('users', 'email')->ignore($id),
//            'old_password' => 'required|string|max:255',
//            'new_password' => Rule::when(true, ['min:5'])
        ]);
        $user = User::find($id);
        if ($request->new_password == '') {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => Carbon::now(),
            ]);
            return back()->with('success', 'Updated Successfully');
        } else {
            if (Hash::check($request->old_password, Auth::user()->password)) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password),
                    'updated_at' => Carbon::now(),
                ]);
                return back()->with('success', 'Updated Successfully');
            } else {
                return back()->with('failed', 'The password does not match!');
            }
        }

    }
}
