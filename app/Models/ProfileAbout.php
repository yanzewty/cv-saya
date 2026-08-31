<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProfileAbout extends Model
{

    protected $fillable = [
        'profile_id',
        'is_main',   
        'tag',
        'title',
        'description',
    ];
}