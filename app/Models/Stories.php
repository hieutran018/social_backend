<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Stories extends Model
{
    use HasFactory;
    protected $fillable = [
        'expiration_timestamp',
        'user_id',
        'viewer_count',
        'type',
        'file_name_story'

    ];
    public $timestamp = false;
    protected $hidden = [
        'user'
    ];
    protected $table = 'stories';
    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function renameFileStory(): void //nên return string
    {
        //avatar

        //check if user has avatar is link http
        $isHttp = !empty(parse_url($this->file_name_story, PHP_URL_SCHEME));
        if ($isHttp) {
            $this->file_name_story = $this->file_name_story;
        } else {
            $this->file_name_story = URL::to('stories/' . $this->user_id . '/' . $this->file_name_story);
        }
    }
}
