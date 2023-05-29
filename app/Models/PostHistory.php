<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'post_content',
        'user_id',
        'privacy',
        'parent_post',
        'group_id',
        'feel_activity_id',
        'status'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function icon()
    {
        return $this->hasOne(FeelAndActivity::class, 'id', 'feel_activity_id');
    }
    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
    public function mediafile()
    {
        return $this->hasMany(MediaFilePost::class, 'post_history_id', 'id');
    }
    protected $hidden = [
        'user',
        'comment',
        'group',
        'updated_at',
        'deleted_at',
        'status',
    ];
    protected $table = 'post_histories';
}
