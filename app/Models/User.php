<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Group;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'displayName',
        'email',
        'password',
        'avatar',
        'cover_image',
        'date_of_birth',
        'address',
        'token',
        'device_token',
        'email_verified_at',
        'isAdmin',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'isAdmin',
        'email_verified_at',
        'updated_at',
        'deleted_at'

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'member_groups', 'user_id', 'group_id');
    }

    public function stories()
    {
        return $this->hasMany(Stories::class);
    }

    public function isVerified()
    {
        return $this->hasOne(VerifiedProfile::class, 'user_id', 'id');
    }

    public function renameAvatarUserFromUser(): void //nên return string
    {
        if ($this->avatar == null) {
            $this->avatar = ($this->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'));
        } else {
            //check if user has avatar is link http
            $isHttp = !empty(parse_url($this->avatar, PHP_URL_SCHEME));
            if ($isHttp) {
                $this->avatar = $this->avatar;
            } else {
                $this->avatar = URL::to('media_file_post/' . $this->id . '/' . $this->avatar);
            }
        }
    }
}
