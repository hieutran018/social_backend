<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FriendShip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_request',
        'use_accept',
        'status'
    ];
    protected $hidden = [
        'users',
        'user'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_request');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_accept');
    }

    protected $table = 'list_friends';
    public $timestamps = false;
}
