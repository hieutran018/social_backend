<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class FriendShip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_request',
        'use_accept',
        'status'
    ];

    public function user(){
        return $this->hasMany(User::class,'id','user_request');
    }

    public function users(){
        return $this->hasMany(User::class,'id','user_accept');
    }

    protected $table = 'list_friend';
    public $timestamps = false;
}