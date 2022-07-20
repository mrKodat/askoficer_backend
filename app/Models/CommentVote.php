<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    use HasFactory;

    protected $table = 'comment_votes';

    protected $fillable = [
        'user_id',
        'comment_id',
        'option_id',
        'vote',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'question_id'=> 'integer',
        'option_id'=> 'integer',
        'vote'=> 'integer',
    ];
}
