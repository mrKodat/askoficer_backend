<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'secondUserId',
    ];

    protected $casts = [
        'userId' => 'integer',
        'secondUserId' => 'integer',
    ];


    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
