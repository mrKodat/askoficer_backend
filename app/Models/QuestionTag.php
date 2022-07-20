<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'tag',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class)->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options');
    }

    public function questionTag() {
        return $this->belongsTo(Tag::class, 'id');
    }
}
