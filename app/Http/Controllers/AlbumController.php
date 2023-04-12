<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Post;
use App\Models\MediaFilePost;
use URL;
use Carbon\Carbon;
use Illuminate\Support\Str;
use JWTAuth;

class AlbumController extends Controller
{
    public function fetcAlbumByIdUser($userId){
        $lstAlbum = Album::WHERE('user_id',$userId)->get();
        foreach($lstAlbum as $album){
            if($album->mediaFiles->count() === 0){
                $album->thumnail =null;
            }else{
                $album->thumnail = URL::to('media_file_post/'.$userId.'/'.$album->mediaFiles[$album->mediaFiles->count()-1]->media_file_name);
            }
            $album->totalImage = $album->mediaFiles->count();
        }
        return response()->json($lstAlbum,200);
    }
    public function createAlbum(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        $newAlbum = new Album();

        $newAlbum->album_name = $request->albumName === null? 'Chưa đặt tên' : $request->albumName;
        $newAlbum->privacy = $request->privacy;
        $newAlbum->user_id = $userId;
        $newAlbum->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newAlbum->save();

        if($request->hasFile('files')){
            $crPost = new Post();
            $crPost->user_id = $userId;
            $crPost->post_content = 'Đã tạo một album ảnh mới.';
            $crPost->privacy = $request->privacy;
            $crPost->parent_post = null;
            $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $crPost->status = 1;
            $crPost->save();
            foreach($request->file('files') as $key => $file)
            {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time().$random.'.'.$fileExtentsion;
                $file->move('media_file_post/'.$userId, $fileName);
                $media = new MediaFilePost();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                $media->album_id = $newAlbum->id;
                $media->user_id = $userId;
                $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $media->status = 1;
                $media->save();
            }
        }

        if($newAlbum->mediaFiles->count() > 0){
            $newAlbum->thumnail = URL::to('media_file_post/'.$userId.'/'.$newAlbum->mediaFiles[$newAlbum->mediaFiles->count()-1]->media_file_name);
        }else{
            $newAlbum->thumnail = null;
        }
        $newAlbum->totalImage = $newAlbum->mediaFiles->count();
        
        return response()->json($newAlbum,200);
    }

    public function fetchImageByAlbumId($albumId){
        $lstImage = MEdiaFilePost::WHERE('album_id',$albumId)->get();

        foreach ($lstImage as $image){
            $image->media_file_name = URL::to('media_file_post/'.$image->user_id.'/'.$image->media_file_name);
        }

        return response()->json($lstImage,200);
    }
}