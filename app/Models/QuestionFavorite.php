<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionFavorite extends Model
{
    use HasFactory;

    protected $table = 'question_favorites';

    protected $fillable = [
        'user_id',
        'question_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'question_id'=> 'integer',
    ];

    public function question() {
        return $this->hasOne(Question::class, 'id', 'user_id')->with('answers')->withCount('answers as answersCount')->with('user')->with('category')->with('tags')->with('options');
    }
}
