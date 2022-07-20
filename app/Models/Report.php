<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'question_id',
        'answer_id',
        'content',
        'type',
        'date',
    ];
}
