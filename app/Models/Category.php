<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'parent',
        'term_id',
        'taxonomy',
    ];

    public function question(){
        return $this->belongsTo(Question::class, 'category_id');
    }

    public function followers(){
        return $this->hasMany(CategoryFollower::class, 'category_id');
    }
}
