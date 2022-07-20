<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionVote extends Model
{
    use HasFactory;

    protected $table = 'question_votes';

    protected $fillable = [
        'user_id',
        'question_id',
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
