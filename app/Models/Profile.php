<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'role', 'about', 'email', 'phone', 'address', 
        'skills', 'education', 'experiences', 'hobbies', 'photo', 
        'badge_1', 'badge_2', 'gallery_1', 'gallery_2', 'gallery_3',
        'about_title', 'about_1', 'about_2', 'about_3',
        'about_sub_1', 'about_sub_2', 'about_sub_3' 
    ];
}