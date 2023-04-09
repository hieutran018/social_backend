<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostLike extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable =[
        'user_id',
        'post_id'
    ];
    protected $table ='like_posts';

   public $timestamps = false;
}