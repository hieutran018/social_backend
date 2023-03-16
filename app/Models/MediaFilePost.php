<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFilePost extends Model
{
    use HasFactory;
    protected $fillable = [
        'media_file_name',
        'media_type',
        'post_id',
        'user_id',
        'status'
    ];
    public $timestamps = false;
}