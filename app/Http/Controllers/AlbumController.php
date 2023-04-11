<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use URL;

class AlbumController extends Controller
{
    public function fetcAlbumByIdUser($userId){
        $lstAlbum = Album::WHERE('user_id',$userId)->get();
        foreach($lstAlbum as $album){
            $album->thumnail = URL::to('media_file_post/'.$userId.'/'.$album->mediaFiles[$album->mediaFiles->count()-1]->media_file_name);
        }
        return response()->json($lstAlbum,200);
    }
}