<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MediaFilePost;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['album_name','user_id','privacy'];
    protected $table = 'albums';
    public $timestamps = false;
    

    public function mediaFiles()
    {
        return $this->hasMany(MediaFilePost::class,'album_id','id');
    }
}