<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'conversation_id',
        'content'
    ];

    public $timeStamp = false;
    protected $table = 'messages';
    protected $hidden = [
        'user'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function mediaFile()
    {
        return $this->hasMany(MediaFileMessage::class, 'message_id', 'id');
    }
}
