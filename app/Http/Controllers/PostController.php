<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CommentPost;
use App\Models\MediaFilePost;
use Carbon\Carbon;
use URL;
use JWTAuth;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function createPost(Request $request){
        $crPost = new Post();
        $crPost->user_id = JWTAuth::toUser($request->token)->id;
        $crPost->post_content = nl2br($request->postContent);
        $crPost->privacy = 1;
        $crPost->parent_post = null;
        $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $crPost->status = 1;
        $crPost->save();

        //* Upload Files
        if($request->hasFile('files')){
            foreach($request->file('files') as $key => $file)
            {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time().$random.'.'.$fileExtentsion;
                $file->move('media_file_post/'.JWTAuth::toUser($request->token)->id, $fileName);
                $media = new MediaFilePost();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                $media->user_id = JWTAuth::toUser($request->token)->id;
                $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $media->status = 1;
                $media->save();
            }
        }

        return response()->json($crPost->mediafile,200);
        
    }

    public function fetchPost(){
        $lstPost = Post::orderBy('created_at','DESC')->paginate(10);
        
        foreach($lstPost as $post){
           $post->username = $post->user->first_name. ' ' . $post->user->last_name;

           $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');
           $post->avatarUser = $post->user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$post->user->id.'/'.$post->user->avatar);
           $post->totalMediaFile = $post->mediafile->count();
           $post->totalComment = $post->comment->count();
           foreach($post->mediafile as $mediaFile){
                $mediaFile->media_file_name = URL::to('media_file_post/'.$post->user->id.'/'.$mediaFile->media_file_name);
           }
        }
        return response()->json($lstPost,200);
    }

    public function fetchPostById(Request $request){
        $post = Post::find($request->postId);
        $post->username = $post->user->first_name. ' ' . $post->user->last_name;
           $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d h:m:s');
           $post->avatarUser = $post->user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$post->user->id.'/'.$post->user->avatar);
           $post->totalMediaFile = $post->mediafile->count();
           $post->totalComment = $post->comment->count();
           foreach($post->mediafile as $mediaFile){
                $mediaFile->media_file_name = URL::to('media_file_post/'.$post->user->id.'/'.$mediaFile->media_file_name);
           }
        return response()->json($post,200);
    }
}