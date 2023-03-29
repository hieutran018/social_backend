<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendShipController;

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

Route::get('fetch-post',[PostController::class,'fetchPost']);
Route::POST('fetch-post-by-id',[PostController::class,'fetchPostById']);
Route::post('fetch-comment-by-post',[CommentController::class,'fetchCommentByPost']);
Route::post('profile-user',[UserController::class,'profileUser']);

//* DANH SÁCH GỢI Ý KẾT BẠN
Route::get('fetch-friend-suggestion',[FriendShipController::class,'fetchFriendSuggestion']);



Route::group(['middleware' => 'jwt.auth','prefix'=>'v1'],function(){
    //* BÌNH LUẬN BÀI VIẾT
    Route::post('create-comment-post',[CommentController::class,'createCommentPost']);
    //* TẠO BÀI VIẾT
    Route::post('create-post',[PostController::class,'createPost']);
    //* CHIA SẺ BÀI VIẾT VỀ TRANG CÁ NHÂN
    Route::post('share-post-to-profile',[PostController::class,'sharePost']);
    //* CẬP NHẬT THÔNG TIN NGƯỜI DÙNG HIỆN TẠI
    Route::post('edit-information-user',[UserController::class,'editUserInformation']);
});


Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});