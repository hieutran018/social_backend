<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'conversation_name',
        'conversation_type',
        'user_one',
        'user_two'
    ];

    public $timeStamp = false;
    protected $table = 'conversations';
    protected $hidden = [
        'userOne',
        'userTwo',
        'user_one',
        'user_two',
        'created_at',
        'updated_at'
    ];
    public function userOne()
    {
        return $this->hasOne(User::class, 'id', 'user_one');
    }
    public function userTwo()
    {
        return $this->hasOne(User::class, 'id', 'user_two');
    }
}
