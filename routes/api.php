<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendShipController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\AlbumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::POST('fetch-post-by-id',[PostController::class,'fetchPostById']);
Route::post('fetch-comment-by-post',[CommentController::class,'fetchCommentByPost']);
Route::post('profile-user',[UserController::class,'profileUser']);







Route::group(['middleware' => 'jwt.auth','prefix'=>'v1'],function(){
    //* DANH SÁCH GỢI Ý KẾT BẠN
    Route::GET('/fetch-friends-suggestion',[FriendShipController::class,'fetchFriendSuggestion']);
    //* BÌNH LUẬN BÀI VIẾT
    Route::post('create-comment-post',[CommentController::class,'createCommentPost']);

    //* DANH SÁCH BÀI VIẾT
    Route::get('fetch-post',[PostController::class,'fetchPost']);
    
    //* TẠO BÀI VIẾT
    Route::post('create-post',[PostController::class,'createPost']);
    //* CHIA SẺ BÀI VIẾT VỀ TRANG CÁ NHÂN
    Route::post('share-post-to-profile',[PostController::class,'sharePost']);
    //* CẬP NHẬT THÔNG TIN NGƯỜI DÙNG HIỆN TẠI
    Route::post('edit-information-user',[UserController::class,'editUserInformation']);
    //* GỬI LỜI MỜI KẾT BẠN
    Route::post('request-add-friend',[FriendShipController::class,'requestAddFriend']);

    //* DANH SÁCH LỜI MỚI KẾT BẠN
    Route::post('fetch-friend-request-list',[FriendShipController::class,'fetchFriendRequestList']);
    //*CHẤP NHẬN LỜI MỜI KẾT BẠN
    Route::post('accept-friend-request',[FriendShipController::class,'acceptFriendRequest']);

    //* HỦY KẾT BẠN
    Route::post('unfriend',[FriendShipController::class,'unFriend']);

    //* HOÀN TÁC YÊU CẦU KẾT BẠN
    Route::post('cancle-add-friend',[FriendShipController::class,'cancelAddFriend']);
    //* DANH SÁCH BẠN BÈ THEO ID NGƯỜI DÙNG
    Route::get('fetch-friend-by-user-id/{userId}/{limit?}',[FriendShipController::class,'fetchListFriendByUser']);

    //*DANH SÁCH HÌNH ẢNH ĐÃ ĐĂNG TẢI
    Route::get('fetch-image-uploaded/userId={userId}/{limit?}',[MediaFileController::class,'photoByUploaded']);
    //* CẬP NHẬT ẢNH ĐẠI DIỆN
    Route::post('upload-avatar',[UserController::class,'uploadAvatar']);
    //* CẬP NHẬT ẢNH BÌA
    Route::post('upload-cover-image',[UserController::class,'uploadCoverImage']);

    //* THÍCH BÀI VIẾT
    Route::get('post/like-post/{postId}',[PostLikeController::class,'like']);

    //*  DANH SÁCH ALBUM ẢNH NGƯỜI DÙNG
    Route::get('fetch-album-by-userid/userId={userId}',[AlbumController::class,'fetcAlbumByIdUser']);

    //* TẠO ALBUM ẢNH
    Route::post('create-album',[AlbumController::class,'createAlbum']);
    //* XEM CHI TIẾT ALBUM
    Route::get('fetch-image-album/{albumId}',[AlbumController::class,'fetchImageByAlbumId']);

});



Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('forgot-password','AuthController@forgotPassword');
    Route::post('completed-forgot-password','AuthController@verificationForgotPassword');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('login-with-google', 'AuthController@loginWithGoogle');

});