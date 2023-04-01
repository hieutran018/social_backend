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
        $crPost->post_content = $request->postContent;
        $crPost->privacy = $request->privacy;
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

    public function sharePost(Request $request){
        $isShared = Post::WHERE('id',$request->postId)->first();
        $postShare = new Post();
        if($isShared->parent_post){
            $postShare->user_id = JWTAuth::toUser($request->token)->id;
            $postShare->privacy = 1;
            $postShare->parent_post = $isShared->parent_post;
            $postShare->post_content = $request->postContent;
            $postShare->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $postShare->status = 1;
        }else{
            $postShare->user_id = JWTAuth::toUser($request->token)->id;
            $postShare->privacy = 1;
            $postShare->parent_post = $request->postId;
            $postShare->post_content = $request->postContent;
            $postShare->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $postShare->status = 1;
        }
        
        $postShare->save();
        return response()->json($postShare,200);
    }

    public function fetchPost(){
        $lstPost = Post::orderBy('created_at','DESC')->get();
        
        foreach($lstPost as $post){
            if($post->parent_post){
                $post->parent_post = Post::find($post->parent_post);
                $post->parent_post->username = $post->parent_post->user->first_name. ' ' . $post->parent_post->user->last_name;
                $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');
                $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ? 
                                    ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                                    URL::to('user/person/'.$post->parent_post->user->id.'/'.$post->parent_post->user->avatar);
                $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                $post->parent_post->totalComment = $post->parent_post->comment->count();
                foreach($post->parent_post->mediafile as $mediaFile){
                        $mediaFile->media_file_name = URL::to('media_file_post/'.$post->parent_post->user->id.'/'.$mediaFile->media_file_name);
                }
            }
            
           $post->username = $post->user->first_name. ' ' . $post->user->last_name;

           $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');
           $post->avatarUser = $post->user->avatar == null ? 
                            ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
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
                            ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                            URL::to('user/person/'.$post->user->id.'/'.$post->user->avatar);
           $post->totalMediaFile = $post->mediafile->count();
           $post->totalComment = $post->comment->count();
           foreach($post->mediafile as $mediaFile){
                $mediaFile->media_file_name = URL::to('media_file_post/'.$post->user->id.'/'.$mediaFile->media_file_name);
           }
        return response()->json($post,200);
    }

    public function getPostById(){
        
    }
}