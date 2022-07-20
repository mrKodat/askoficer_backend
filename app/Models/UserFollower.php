<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollower extends Model
{
    use HasFactory;

    protected $table = 'user_followers';

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id')->with('badge');
    }

    public function follower() {
        return $this->hasOne(User::class, 'id', 'follower_id')->with('badge');
    }
}
