<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag', 'title', 
        'sub_1', 'desc_1', 
        'sub_2', 'desc_2', 
        'sub_3', 'desc_3'
    ];
}