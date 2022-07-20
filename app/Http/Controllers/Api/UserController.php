<?php

namespace App\Http\Controllers\Api;

use App\Events\SendPushNotificationEvent;
use App\Events\UserPointsUpdated;
use App\Events\UserPointsUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\DeviceToken;
use App\Models\Point;
use App\Models\Question;
use App\Models\Recipe;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserFollower;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::where('email', $request->email)->orwhere('username', $request->username)->with('badge')->withCount('question as questions')->withCount('followers as followers')->withCount('following as following')->withCount('notification as notifications')->first();
        if (!$user) {
            return response([
                'message' => ['Check again or try your email address.']
            ], 404);
        } else if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These password you entered is incorrect.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        // $badge = Badge::whereRaw('? between `from` and `to`', [$user->points])->get();

        $response = [
            'user' => $user,
            // 'badge' => $badge,
            'token' => $token
        ];

        // $user = User::where('email', $request->email)->orwhere('username', $request->username)->with('badge')->withCount('question as questions')->withCount('followers as followers')->first();

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->orwhere('username', $request->username)->with('badge as badge')->withCount('notification as notifications')->withCount('followers as followers')->withCount('following as following')->first();
        if (!$user) {
            return response([
                'message' => ['Unknown username. Check again or try your email address.']
            ], 404);
        } else if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These password you entered is incorrect.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->username = $request->input('username');
        $user->displayname = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        DB::table('user_badges')->insert(['user_id' => $user->id, 'badge_id' => 1]);

        event(new UserPointsUpdatedEvent($user->id, Point::find(1)->points));
        event(new Registered($user));

        // $user = User::create($request->all());
        return response()->json(["code" => "201", "message" => "Account created successfully", "user" => $user], 201);
    }

    public function registerSocialUser(Request $request)
    {
        $exist = User::where('email', $request->email)->first();
        if ($exist) {
            return response()->json(["user" => $exist], 201);
        } else {
            $rules = [
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'source' => 'required',
                'authId' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = new User;
            $user->username = $request->input('username');
            $user->displayname = $request->input('username');
            $user->email = $request->input('email');
            $user->authId = $request->input('authId');
            $user->password = Hash::make($request->input('authId'));
            $user->source = $request->input('source');
            $user->avatar = $request->input('avatar');
            $user->email_verified_at = Carbon::now()->toDateString();
            $user->save();

            DB::table('user_badges')->insert(['user_id' => $user->id, 'badge_id' => 1]);

            event(new UserPointsUpdatedEvent($user->id, Point::find(1)->points));
            // event(new Registered($user));

            $created = User::where('id', $user->id)->first();
            return response()->json(["code" => "201", "user" => $created], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo($id)
    {
        $user = User::where('id', $id)->with('badge')->withCount('answers as answers')->withCount('question as questions')->withCount('notification as notifications')->withCount('followers as followers')->withCount('following as following')->first();
        if (is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($user, 200);
    }

    public function getUserProfile($id)
    {
        $user = User::where('id', $id)
            ->with('allquestions')
            ->with('allpolls')
            ->with('waitingquestions')
            ->withCount('followers as followers')->withCount('following as following')
            ->with(array('favorites' => function ($query) use ($id) {
                $query->where('user_id', $id)->with('question');
            }))
            ->first();
        if (is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'displayname' => 'required',
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        $user->displayname = $request->input('displayname');
        $user->email = $request->input('email');
        if ($request->input('description') != null)
            $user->description = $request->input('description');
        if ($request->input('password') != null)
            $user->password = Hash::make($request->input('password'));

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
            $user->avatar = url('') . '/uploads/users/avatars/' . $filename;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover != null) {
                $oldImagePath = public_path("/uploads/users/covers/$user->cover");
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $cover =  $request->file('cover');
            $extension = $cover->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $cover->move('uploads/users/covers/', $filename);
            $user->cover = $filename;
        }

        $user->save();

        return response()->json(["message" => ""], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteAccount($id)
    {
        User::where('id', $id)->delete();
        return response()->json(["message" => "Account deleted successfully"], 201);
    }

    public function deleteImage($id)
    {
        $user = User::find($id);
        if ($user->image != null) {
            $oldImagePath = public_path("/uploads/users/avatars/$user->image");
            if (File::exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        DB::table('users')->where('id', $id)->update(['image' => NULL]);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $user->update(['password' => Hash::make($request->input('password'))]);
        return response()->json(["message" => "Password updated successfully"], 200);
    }

    public function search($name, $id)
    {
        $user = User::whereRaw("concat(firstName, ' ', lastName) like '%$name%' ")->where('id', '!=', $id)->get();
        if (is_null($user)) {
            return response()->json(["message" => "No user found!"], 404);
        }
        return response()->json($user, 200);
    }

    public function addUserFollow($id, $followerId)
    {

        $follow = DB::table('user_followers')->where([['user_id', '=', $id], ['follower_id', '=', $followerId]])->first();
        $senderName = User::find($id)->displayname;

        if (is_null($follow)) {
            DB::table('user_followers')->insert(['user_id' =>  $id, 'follower_id' => $followerId]);
            event(new UserPointsUpdatedEvent($followerId, Point::find(7)->points));
            event(new SendPushNotificationEvent($followerId, config('app.name'), $senderName . ' has followed you.', null, $id));
            return response()->json(["following" => true], 201);
        } else {
            DB::table('user_followers')->where([['user_id', '=', $id], ['follower_id', '=', $followerId]])->delete();
            event(new SendPushNotificationEvent($followerId, config('app.name'), $senderName . ' has unfollowed you.', null, $id));
            return response()->json(["following" => false], 201);
        }
    }

    public function getUserFollowing($id)
    {
        $users = UserFollower::with('follower')->where('user_id', '=', $id)->get()->pluck('follower');
        return response()->json($users, 200);
    }

    public function getUserFollowers($id)
    {
        $users = UserFollower::with('user')->where('follower_id', '=', $id)->get()->pluck('user');
        return response()->json($users, 200);
    }

    public function checkIfUserIsFollowing($id, $followerId)
    {
        $users = DB::table('user_followers')->where(['user_id' => $id, 'follower_id' => $followerId])->count();

        if ($users == 0) {
            return response()->json(["following" => false], 200);
        } else {
            return response()->json(["following" => true, "message" => "Already Following User"], 200);
        }
    }

    public function setDeviceToken(Request $request)
    {
        User::where('id', $request->user_id)->update(['device_token' => $request->token]);
        return response()->json(["message" => "Device Token updated successfully"], 201);
    }

    public function forgotPassword(Request $request)
    {
        if (User::where('email', '=', $request->email)->exists()) {
            $credentials = request()->validate(['email' => 'required|email']);
            Password::sendResetLink($credentials);

            return response()->json(["message" => 'Reset password link sent to your email'], 201);
        } else {
            return response()->json(["message" => 'Email not found'], 201);
        }
    }

    public function checkAccountStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 0) {
            return response()->json(["status" => false], 200);
        } else {
            return response()->json(["status" => true], 200);
        }
    }

    public function getUserQuestions($id)
    {
        $questions = Question::where([['type', 'Question'], ['author_id', $id], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }))->get();
        return response()->json($questions, 200);
    }

    public function getUserPollQuestions($id)
    {
        $questions = Question::where([['type', 'Poll'], ['author_id', $id], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }))->get();
        return response()->json($questions, 200);
    }

    public function getUserFavQuestions($id)
    {
        $questions = Question::leftJoin('question_favorites', 'question_favorites.question_id', 'questions.id')->where([['question_favorites.user_id', $id], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }))->get();
        return response()->json($questions, 200);
    }

    public function getUserAskedQuestions($id)
    {
        $questions = Question::where([['asking', '=', $id]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }))->get();
        return response()->json($questions, 200);
    }

    public function getUserWaitingQuestions($id)
    {
        $questions = Question::where([['author_id', '=', $id], ['asking', '!=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }))->get();
        return response()->json($questions, 200);
    }

    public function getUserNotifications($id)
    {
        $notifications = DB::table('user_notifications')->where('user_id', '=', $id)->get();
        return response()->json($notifications, 200);
    }

    public function deleteUserNotification($id)
    {
        $notifications = DB::table('user_notifications')->where('id', '=', $id)->delete();
        return response()->json([], 200);
    }
}
