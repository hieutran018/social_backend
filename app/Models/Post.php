<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CommentPost;
use App\Models\PostLike;
use App\Models\MediaFilePost;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_content',
        'user_id',
        'privacy',
        'parent_post',
        'group_id',
        'status'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function group()
    {
        return $this->hasOne(Group::class,'id','group_id');
    }
    public function mediafile()
    {
        return $this->hasMany(MediaFilePost::class,'post_id','id');
    }
    protected $hidden = [
        'user',
        'comment',
        'group'
       
    ];

    public function comment()
    {
        return $this->hasMany(CommentPost::class,'post_id','id');
    }
    public function like()
    {
        return $this->hasMany(PostLike::class,'post_id','id');
    }
}