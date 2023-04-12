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
            $album->totalImage = $album->mediaFiles->count();
        }
        return response()->json($lstAlbum,200);
    }
    public function createAlbum(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        $newAlbum = new Album();

        $newAlbum->album_name = $requet->albumName;
        $newAlbum->privacy = $requet->privacy;
        $newAlbum->user_id = $userId;
        $newAlbum->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $new->save();

        


        if($newAlbum->mediaFiles->count > 0){
            $newAlbum->thumnail = URL::to('media_file_post/'.$userId.'/'.$newAlbum->mediaFiles[$album->mediaFiles->count()-1]->media_file_name);
        }else{
            $newAlbum->thumnail = null;
        }
        $newAlbum->totalImage = $album->mediaFiles->count();


        
        
        return response()->json($newAlbum,200);
    }
}