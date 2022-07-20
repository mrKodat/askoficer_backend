<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
		'body',
		'userId',
		'conversation_id',
		'read'
	];

    protected $casts = [
		'body' => 'string',
		'userId' => 'integer',
		'conversation_id' => 'integer',
		'read '=> 'boolean',
	];

	public function conversation()
	{
		return $this->belongsTo(Conversation::class);
	}
}
