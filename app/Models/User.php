<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'nicename',
        'email',
        'password',
        'registered',
        'displayname',
        'nickname',
        'description',
        'capabilities',
        'user_group',
        'avatar',
        'cover',
        'points',
        'source',
        'followers',
        'questions',
        'answers',
        'best_answers',
        'posts',
        'comments',
        'notifications',
        'new_notifications',
        'verified',
        'admin',
        'status',
        'badge_id',
        'profile_crediential',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id', 'author_id');
    }

    public function badge()
    {
        return $this->hasOne(UserBadge::class, 'user_id', 'id')->leftJoin('badges', 'badges.id', 'user_badges.badge_id')->select('user_badges.user_id', 'badges.name', 'badges.color');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'author_id');
    }

    public function allquestions()
    {
        return $this->hasMany(Question::class, 'author_id', 'id')->where('type', 'Question');
    }

    public function allpolls()
    {
        return $this->hasMany(Question::class, 'author_id', 'id')->where('type', 'Poll');
    }

    public function waitingquestions()
    {
        return $this->hasMany(Question::class, 'author_id', 'id')->where('bestAnswer', null);
    }

    public function favorites()
    {
        return $this->hasMany(QuestionFavorite::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Comment::class, 'author_id')->where('type', '=', 'Answer');
    }

    public function followers()
    {
        return $this->hasMany(UserFollower::class, 'follower_id', 'id');
    }

    public function notification()
    {
        return $this->hasMany(AppNotification::class, 'user_id', 'id');
    }

    public function following()
    {
        return $this->hasMany(UserFollower::class, 'user_id', 'id');
    }

    public function pushNotification($title, $body, $message)
    {
        $token = $this->device_token;
        $fcmKey = DB::table('settings')->find(1)->fcm_key;

        if ($token == null) return;

        $data['notification']['title'] = $title;
        $data['notification']['body'] = $body;
        $data['notification']['sound'] = true;
        $data['priority'] = 'normal';
        $data['data']['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
        $data['data']['message'] = $message;
        $data['to'] = $token;
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $fcmKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        $success = json_decode($response, true)['success'];
    }
}
