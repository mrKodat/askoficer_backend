<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'privacy_policy',
        'terms_and_conditions',
        'about_us',
        'contact_us',
        'faq',
        'fcm_key',
    ];
}
