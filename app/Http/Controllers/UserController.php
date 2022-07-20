<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator as Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $users)
    {
        $users = User::where([['id', '!=', 0], ['id', '!=', Auth::user()->id]])->get();
        return view('users.users-index', ['users' => $users]);
    }

    public function useredit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('users.user-edit')->with('users', $users);
    }

    public function userupdate(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            if ($user->avatar != null) {
                $oldImagePath = public_path("/uploads/users/avatars/$user->avatar");
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $avatar =  $request->file('avatar');
            $extension = $avatar->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $avatar->move('uploads/users/avatars/', $filename);
            $user->avatar = $filename;
            $user->update(new User(array_merge($request->all(), ['avatar' => $filename])));
        } else {
            $user->update($request->all());
        }

        return redirect('/users')->with('status', 'User information updated');
    }

    public function userdelete($id)
    {
        $users = User::findOrFail($id);
        if ($users->image !== null) {
            $oldImagePath = public_path("/uploads/users/avatars/$users->image");
            if (File::exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $users->delete();

        return redirect('/users')->with('status', 'User deleted successfully');
    }

    public function useradd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return back()->with('status', $message);
        }

        $user = new User;
        $user->username = $request->username;
        $user->displayname = $request->displayname;
        $user->email = $request->email;
        $user->description = $request->description;
        $user->password = Hash::make($request->password);
        $user->admin = $request->admin;
        $user->status = $request->status;

        if ($request->avatar != null) {
            if ($request->hasFile('avatar')) {
                $avatar =  $request->file('avatar');
                $extension = $avatar->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $avatar->move('uploads/users/avatars/', $filename);
                $user->avatar = $filename;
                $user->save(array_merge($request->all(), ['avatar' => $filename]));
            }
        } else {
            $user->save();
            // User::create($request->all());
        }

        return redirect('/users')->with('status', 'User added successfully');
    }

    // public function addDeviceToken($token) {
    //     $deviceToken = new DeviceToken;
    //     $deviceToken->device_token = $token;
    //     $deviceToken->save();

    //     return response()->json(["message" => "Device Token added successfully!"], 201);
    // }
}
