<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MediaFilePost;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_content',
        'user_id',
        'privacy',
        'parent_post',
        'status'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function mediafile()
    {
        return $this->hasMany(MediaFilePost::class,'post_id','id');
    }
    protected $hidden = [
        'user',
        'user_id',
    ];
}