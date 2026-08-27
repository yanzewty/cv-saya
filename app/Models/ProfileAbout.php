<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileAbout extends Model
{
    // Mengizinkan kolom-kolom ini diisi data secara massal (mass assignment)
    protected $fillable = [
        'profile_id',
        'tag',
        'title',
        'subtitle',
        'description'
    ];
}