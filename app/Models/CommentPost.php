<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_content',
        'post_id',
        'user_id',
        'parent_comment',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(CommentPost::class, 'parent_comment', 'id');
    }
    public function file()
    {
        return $this->belongsTo(MediaFileComment::class, 'id', 'comment_id');
    }
    protected $hidden = [
        'user',
        'user_id',
    ];
}
