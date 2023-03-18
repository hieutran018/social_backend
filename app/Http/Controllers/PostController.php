<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use URL;

class PostController extends Controller
{
    public function fetchPost(){
        $lstPost = Post::all();
        foreach($lstPost as $post){
           $post->username = $post->user->first_name. ' ' . $post->user->last_name;
           $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d h:m:s');
           $post->avatarUser = URL::to('user/person/'.$post->user->id.'/'.$post->user->avatar);
           $post->totalMediaFile = $post->mediafile->count();
           
           foreach($post->mediafile as $mediaFile){
                $mediaFile->media_file_name = URL::to('media_file_post/'.$post->user->id.'/'.$mediaFile->media_file_name);
           }
        }
        return response()->json($lstPost,200);
    }
}