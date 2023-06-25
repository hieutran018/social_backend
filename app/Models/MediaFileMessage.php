<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFileMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'media_file_name',
        'media_type',
        'message_id',
        'user_id',
    ];
    public $timestamps = false;
    protected $table = 'media_file_messages';
}
