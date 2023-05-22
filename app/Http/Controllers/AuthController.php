<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ForgotPassword;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Validator;
use URL;
use Mail;
use Redirect;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verificationUser', 'forgotPassword', 'verificationForgotPassword', 'loginWithGoogle']]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    //TODO: đang hoàn thành
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'displayName' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|string|min:6|same:password',
        ], [
            'displayName.required' => 'Họ tên không được bỏ trống!',
            'email.required' => 'Email không được bỏ trống!',
            'email.unique' => 'Email đã được sử dụng!',
            'password.required' => 'Mật khẩu không được bỏ trống!',
            'password.min' => 'Mật khẩu phải nhiều hơn 6 ký tự!',
            'password.same' => 'Xác nhận mật khẩu và mật khẩu không khớp'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = new User();
        $user->displayName = $request->displayName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->isAdmin = 0;
        $user->token = Str::random(10);
        $user->save();

        Mail::send('email', compact('user'), function ($email) use ($user) {
            $email->subject('Xác nhận đăng ký tài khoản');
            $email->to($user->email, 'CKC Social network');
        });

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->email;

        $check = SocialAccount::WHERE('email', $email)->first();

        if (empty($check)) {
            $user = User::WHERE('email', $email)->first();
            if (empty($user)) {
                return response()->json(['error' => 'Không tìm thấy địa chỉ email này!'], 404);
            } else {
                $reset = new ForgotPassword();
                $reset->email = $email;
                $reset->token = Str::upper(Str::random(8));
                $reset->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $reset->save();
                Mail::send('forgot_password', compact('user', 'reset'), function ($email) use ($user, $reset) {
                    $email->subject('Xác nhận đặt lại mật khẩu');
                    $email->to($user->email, 'CKC Social network');
                });
                return response()->json('Mã xác nhận đã được gửi đến địa chỉ email của bạn!', 201);
            }
        } else {
            return response()->json(['error' => 'Không tìm thấy tài khoản!'], 404);
        }
    }
    public function verificationForgotPassword(Request $request)
    {
        $check = ForgotPassword::WHERE('token', $request->tokenReset)->first();

        if (empty($check)) {
            return response()->json('Không tìm thấy tài khoản của Email này!', 400);
        } else {

            $pass = Str::upper(Str::random(6));
            $updatePass = User::WHERE('email', $check->email)->first();

            $updatePass->password = bcrypt($pass);
            $updatePass->update();
            Mail::send('complete_forgot_password', compact('updatePass', 'pass'), function ($email) use ($updatePass, $pass) {
                $email->subject('Đặt lại mật khẩu');
                $email->to($updatePass->email, 'CKC Social network');
            });
        }
    }

    public function verificationUser(User $user, $token)
    {
        if ($user->token == null) {
            return Redirect::to('/')->with('verified', 'Bạn đã hoàn tất xác minh trước đó rồi !');
        }

        if ($user->token === $token) {
            $user->update(['status' => 1, 'token' => null, 'email_verified_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
            return Redirect::to('/')->with('success_verify', 'Xác minh thành công !');
        } else {
            return Redirect::to('/')->with('failed_verify', 'Xác minh thẩ bại, vui lòng thử lại !');
        }
    }



    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            if ($this->guard()->user()->email_verified_at != null)
                return $this->respondWithToken($token);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function loginWithGoogle(Request $request)
    {

        $data = $request->all();
        $check = SocialAccount::WHERE('email', $data['email'])->first();
        if (empty($check)) {

            $user = User::WHERE('email', $data['email'])->first();
            if (empty($user)) {
                $new = new User();
                $new->displayName = $data['displayName'];
                $new->email = $data['email'];
                $new->email_verified_at = Carbon::now('Asia/Ho_Chi_Minh');
                $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $new->isAdmin = 0;
                $new->save();

                $cr = new SocialAccount();
                $cr->provider = $data['provider'];
                $cr->provider_id = $data['uid'];
                $cr->email = $data['email'];
                $cr->user_id = $new->id;
                $cr->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $cr->save();
                if ($token = Auth::login($new)) {
                    return $this->respondWithToken($token);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                return response()->json('Email này đã được đăng ký bởi một tài khoản khác!', 402);
            }
        } else {
            $user = User::WHERE('email', $check->email)->first();
            if ($token = Auth::login($user)) {
                return $this->respondWithToken($token);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $this->guard()->user()->renameAvatarUserFromUser();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => $this->guard()->user()

        ], 200);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}