<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function UserLogout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile', compact('user'));
    }

    public function UserProfileStore(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($file = $request->file('profile_photo_path')) {
            unlink('upload/user_images/' . $data->profile_photo_path);
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['profile_photo_path'] = $filename;
        };

        $notification = array(
            'message' => 'User Profile Updated Successfully!',
            'alert-type' => 'success'
        );

        $data->save();
        return  redirect()->route('user.profile')->with($notification);
    }

    public function UserChangePassword()
    {
        // QUERY Builder Style: $user= DB::table('users')->where('id', Auth::user()->id)->first()
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }
    public function UserPasswordUpdate(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $userPassword = Auth::user()->password;


        if (Hash::check($request->current_password, $userPassword)) {
            $user = User::find(Auth::id());
            // pass entered password by user, and make it a hash password
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route(('user.logout'));
        } else {
            return redirect()->back();
        }
    }
}