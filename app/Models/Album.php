<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MediaFilePost;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Album extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['album_name', 'user_id', 'privacy'];
    protected $table = 'albums';
    public $timestamps = false;


    public function mediaFiles()
    {
        return $this->hasMany(MediaFilePost::class, 'album_id', 'id');
    }

    // public function renameThumnail(): void //nên return string
    // {
    //     $mediaFiless = $this->mediaFiles;
    //     if (empty($mediaFiless)) {
    //         $this->thumnail = null;
    //     } else {
    //         //check if user has avatar is link http
    //         $image = $mediaFiless[$mediaFiless->count() - 1]->media_file_name;
    //         $isHttp = !empty(parse_url($image, PHP_URL_SCHEME));
    //         if ($isHttp) {
    //             $this->thumnail = $image;
    //         } else {
    //             $this->thumnail = URL::to('media_file_post/' . $this->user_id . '/' . $image);
    //         }
    //     }
    // }
}
