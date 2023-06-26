<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostHistoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendShipController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FeelAndActivityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\StoriesController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFeelAndActivityController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\VerifiedProfleController;
use App\Models\MediaFilePost;

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



Route::GET('/fetch-post-by-userId/userId={userId}', [PostController::class, 'fetchPostByUserId']);


Route::group(
    ['middleware' => 'jwt.auth', 'prefix' => 'v1/admin'],
    function () {
        Route::GET('/admin-dashboard-statistics', [AdminDashboardController::class, 'adminDashboardStatistics']);
        Route::GET('/fetch-list-post', [AdminPostController::class, 'fetchListPost']);
        Route::GET('/fetch-post-by-id/postId={postId}', [AdminPostController::class, 'fetchPostById']);
        Route::GET('/fetch-list-user', [AdminUserController::class, 'fetchListUser']);
        Route::GET('/fetch-list-group', [AdminGroupController::class, 'fetchListGroup']);
        Route::GET('/fetch-list-feel-and-activity', [AdminFeelAndActivityController::class, 'fetchListFeelAndActivity']);
        Route::POST('/create-feel-and-activity', [AdminFeelAndActivityController::class, 'createFeelAndActivity']);
        Route::GET('/fetch-list-report', [AdminReportController::class, 'fetchReport']);
        Route::GET('/fetch-report-by-id/reportId={reportId}', [AdminReportController::class, 'fetchReportById']);
        Route::POST('/check-report', [AdminReportController::class, 'checkTheReport']);
    }
);


Route::group(['middleware' => 'jwt.auth', 'prefix' => 'v1'], function () {
    //* XÁC MINH HỒ SƠ NGƯỜI DÙNG CHÍNH CHỦ HOẶC NỔI BẬT
    Route::POST('/verified-profile', [VerifiedProfleController::class, 'verifiedProfile']);
    //* TRANG CÁ NHÂN NGƯỜI DÙNG
    Route::GET('/profile-user/userId={userId}', [UserController::class, 'profileUser']);
    //* DANH SÁCH GỢI Ý KẾT BẠN
    Route::GET('/fetch-friends-suggestion', [FriendShipController::class, 'fetchFriendSuggestion']);
    Route::GET('/fetch-comment-by-post/postId={postId}', [CommentController::class, 'fetchCommentByPost']);
    Route::GET('/fetch-reply-comment/commentId={commentId}', [CommentController::class, 'fetchReplyComment']);
    //* BÌNH LUẬN BÀI VIẾT
    Route::post('create-comment-post', [CommentController::class, 'createCommentPost']);
    //*PHẢN HỒI BÌNH LUẬN
    Route::post('reply-comment', [CommentController::class, 'commentReply']);
    //* DANH SÁCH BÀI VIẾT
    Route::get('fetch-post', [PostController::class, 'fetchPost']);
    Route::GET('fetch-post-by-id/postId={postId}', [PostController::class, 'fetchPostById']);
    //* TẠO BÀI VIẾT
    Route::post('create-post', [PostController::class, 'createPost']);
    //* CHIA SẺ BÀI VIẾT VỀ TRANG CÁ NHÂN
    Route::post('share-post-to-profile', [PostController::class, 'sharePost']);
    //* CHỈNH SỬA BÀI VIẾT
    Route::POST('update-post', [PostController::class, 'updatePost']);
    Route::POST('delete-post', [PostController::class, 'deletePost']);
    //* LỊCH SỬ CHỈNH SỬA BÀI VIẾT
    Route::GET('fetch-history-edit-post/postId={idPost}', [PostHistoryController::class, 'fetchPostHistoryByIdPost']);
    //* CẬP NHẬT THÔNG TIN NGƯỜI DÙNG HIỆN TẠI
    Route::post('edit-information-user', [UserController::class, 'editUserInformation']);
    //* GỬI LỜI MỜI KẾT BẠN
    Route::post('request-add-friend', [FriendShipController::class, 'requestAddFriend']);
    //* DANH SÁCH LỜI MỚI KẾT BẠN
    Route::post('fetch-friend-request-list', [FriendShipController::class, 'fetchFriendRequestList']);
    //*CHẤP NHẬN LỜI MỜI KẾT BẠN
    Route::post('accept-friend-request', [FriendShipController::class, 'acceptFriendRequest']);
    //* HỦY KẾT BẠN
    Route::post('unfriend', [FriendShipController::class, 'unFriend']);
    //* HOÀN TÁC YÊU CẦU KẾT BẠN
    Route::post('cancle-add-friend', [FriendShipController::class, 'cancelAddFriend']);
    //* DANH SÁCH BẠN BÈ THEO ID NGƯỜI DÙNG
    Route::get('fetch-friend-by-user-id/{userId}/{limit?}', [FriendShipController::class, 'fetchListFriendByUser']);
    //*DANH SÁCH HÌNH ẢNH ĐÃ ĐĂNG TẢI
    Route::get('fetch-image-uploaded/userId={userId}/{limit?}', [MediaFileController::class, 'photoByUploaded']);
    //* CẬP NHẬT ẢNH ĐẠI DIỆN
    Route::post('upload-avatar', [UserController::class, 'uploadAvatar']);
    //* CẬP NHẬT ẢNH BÌA
    Route::post('upload-cover-image', [UserController::class, 'uploadCoverImage']);
    //* Lưu Device Token để push notification
    Route::post('save-device-token', [UserController::class, 'saveDeviceToken']);
    //* THÍCH BÀI VIẾT
    Route::post('post/like-post', [PostLikeController::class, 'like']);
    //*  DANH SÁCH ALBUM ẢNH NGƯỜI DÙNG
    Route::get('fetch-album-by-userid/userId={userId}', [AlbumController::class, 'fetcAlbumByIdUser']);
    //* TẠO ALBUM ẢNH
    Route::post('create-album', [AlbumController::class, 'createAlbum']);
    //* XEM CHI TIẾT ALBUM
    Route::get('fetch-image-album/{userId}/{albumId}', [AlbumController::class, 'fetchImageByAlbumId']);
    //* CẬP NHẬT CHI TIẾT ALBUM
    Route::post('edit-album', [AlbumController::class, 'editAlbum']);
    //* XÓA ALBUM
    Route::post('delete-album', [AlbumController::class, 'deleteAlbum']);
    //* DANH SÁC ẢNH NGƯỜI DÙNG ĐƯỢC TAG TỪ BÀI VIẾT
    Route::GET('/fetch-image-from-post-tag/userId={userId}', [AlbumController::class, 'fetchImagePostTag']);
    Route::GET('/fetch-image-avatar/userId={userId}', [MediaFileController::class, 'fetchImagesAvatar']);
    //* TẠP NHÓM MỚI
    Route::post('create-group', [GroupController::class, 'createGroup']);
    //*DANH SÁCH CÁC GROUP ĐÃ THAM GIA->TÍNH LUÔN CẢ GROUP ĐÃ TẠO
    Route::get('fetch-group-joined', [GroupController::class, 'fetchGroupJoined']);
    //*XEM CHI TIẾT VỀ NHÓM
    Route::get('fetch-group-by-id/{groupId}', [GroupController::class, 'fetchGroupById']);
    //* DANH SÁCH TIN TỨC VIDEO
    Route::get('fetch-reels-video', [MediaFileController::class, 'fetchMediaFileVieo']);
    //* DANH SÁCH BẠN BÈ CHƯA THAM GIA NHÓM
    Route::get('fetch-friend-to-invite-group/{groupId}', [FriendShipController::class, 'fetchFriendToInviteGroup']);
    //* GỬI LỜI MỜI BẠN BÈ THAM GIA NHÓM
    Route::post('send-invite-to-group', [GroupController::class, 'sendInviteFriendToGroup']);
    //* HOÀN TÁC LỜI MỜI THAM GIA NHÓM
    Route::post('cancel-invite-to-group', [GroupController::class, 'cancelSendInvite']);
    //* DANH SÁCH CÁC NHÓM ĐƯỢC MỜI THAM GIA
    Route::get('fetch-invite-to-group', [GroupController::class, 'fetchInviteToGroup']);
    //* CHẤP NHẬN LỜI MỜI THAM GIA NHÓM
    Route::post('accept-invite-to-group', [GroupController::class, 'acceptInviteGroup']);
    //* CẬP NHẬT CÁC THÔNG TIN CỦA NHÓM
    Route::post('edit-information-group', [GroupController::class, 'editGroupByAdmin']);
    //* DANH SÁCH BÀI VIẾT CỦA NHÓM
    Route::get('fetch-post-by-group-id/{groupId}', [PostController::class, 'fetchPostByGroupId']);
    //* DANH SACH THÀNH VIÊN TRONG NHÓM
    Route::get('fetch-member-group/{groupId}', [GroupController::class, 'fetchMemberGroup']);
    //* THÊM QUẢN TRỊ VIÊN CHO NHÓM
    Route::post('add-admin-group', [GroupController::class, 'addMemberToAdmin']);
    //* XÓA QUYỀN QUẢN TRỊ VIÊN TRONG GROUP
    Route::post('remove-admin-to-group', [GroupController::class, 'removeAdminToGroup']);
    //* XÓA THÀNH VIÊN KHỎI NHÓM
    Route::post('remove-member-from-group', [GroupController::class, 'removeMemberFromGroup']);
    //* LẤY DANH SÁCH ẢNH CỦA NHÓM
    Route::get('fetch-group-photo-list/groupId={groupId}&limit={limit?}', [MediaFileController::class, 'fetchGroupPhotoList']);
    //* DANH SÁCH BÀI VIẾT TẤT CẢ CÁC NHÓM
    Route::get('fetch-post-group', [PostController::class, 'fetchPostGroup']);
    //* CẬP NHẬT TÊN NGƯỜI DÙNG
    Route::post('update-displayname-user', [UserController::class, 'updateDisplayName']);
    //* CẬP NHẬT SỐ ĐIỆN THOẠI NGƯỜI DÙNG
    Route::post('update-phone-user', [UserController::class, 'updatePhone']);
    //* CẬP NHẬT MẬT KHẨU NGƯỜI DÙNG
    Route::post('update-password-user', [UserController::class, 'updatePasswordUser']);
    //* TÌM KIẾM NGƯỜI DÙNG VÀ NHÓM
    Route::get('search-users-and-groups/input={input?}', [SearchController::class, 'searchData']);
    //* LẤY DANH SÁCH CẢM XÚC VÀ HOẠT ĐỘNG KHI TẠO BÀI VIẾT
    Route::get('fetch-fell-and-activity-posts', [FeelAndActivityController::class, 'fetchFeelAndActivity']);
    Route::get('search-feel-and-activity-posts/search={input}', [FeelAndActivityController::class, 'searchFeelAnActivity']);
    //* LẤY DANH SÁCH THÔNG BÁO CỦA NGƯỜI DÙNG
    Route::get('fetch-notifications', [NotificationController::class, 'fetchNotifications']);
    //* ĐĂNG BẢNG TIN
    Route::post('/stories/create-story', [StoriesController::class, 'creatStroies']);
    Route::get('/stories', [StoriesController::class, 'fetchStories']);

    Route::POST('/create-report', [ReportController::class, 'createReport']);
    Route::POST('/chats', [ChatController::class, 'chatOneToOne']);
    Route::POST('/chats/create-chat', [ChatController::class, 'isChatOneToOne']);
    Route::POST('/chats/send-message', [ChatController::class, 'sendMessage']);
    Route::GET('/fetch-list-chats', [ChatController::class, 'fetchChats']);
    Route::GET('/fetch-message/userId={userId}', [ChatController::class, 'fetchMessage']);
    //? NotificationController
    // Route::prefix('notification')->group(function () {
    //     Route::get('send-notifi-to-friends', [NotificationController::class, 'sendNotifiToFriends']);
    // });
    //* GỬI FILE
    Route::POST('/chats/sent-message-file', [ChatController::class, 'sendMessageHaveMediaFile']);

    //viết tạm để upload file cho message
    Route::post('message/upload-file', function (Request $request) {
        //api/v1/message/upload-file
        $user = JWTAuth::toUser($request->token);
        $data = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move("media_file_post/$user->id", $fileName);

                $data[] = URL::to("media_file_post/$user->id/$fileName");
            }
        }
        return response()->json($data);
    });
});



Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::post('completed-forgot-password', 'AuthController@verificationForgotPassword');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('login-with-google', 'AuthController@loginWithGoogle');
});

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'auth/admin'
    ],
    function ($router) {
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('refresh', [AdminAuthController::class, 'refresh']);
        Route::post('me', [AdminAuthController::class, 'me']);
    }
);
