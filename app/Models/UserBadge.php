<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;

    protected $table = 'user_badges';
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'badge_id',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'id', 'badge_id');
    }
}
