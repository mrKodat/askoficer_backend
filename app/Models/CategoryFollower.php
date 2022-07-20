<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFollower extends Model
{
    use HasFactory;

    protected $table = 'category_followers';

    protected $fillable = [
        'user_id',
        'category_id',
    ];
}
