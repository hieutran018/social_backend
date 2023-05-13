<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostLike extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
    ];
    protected $hidden = [
        'post_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $table = 'like_posts';

    public $timestamps = false;
}
