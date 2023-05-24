<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MemberGroup;
use App\Models\User;
use Illuminate\Support\Facades\URL;


class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name',
        'privacy',
        'avatar',
        'cover_image',
    ];
    protected $table = 'groups';
    public $timestamps = false;
    public function users()
    {
        return $this->belongsToMany(User::class, 'member_groups', 'group_id', 'user_id');
    }

    public function renameAvatar(): void //nên return string
    {
        if ($this->avatar === null) {
            $this->avatar = URL::to('default/avatar_group_default.jpg');
        } else {
            //check if user has avatar is link http
            $isHttp = !empty(parse_url($this->avatar, PHP_URL_SCHEME));
            if ($isHttp) {
                return;
            } else {
                $this->avatar = URL::to('media_file_post/' . $this->avatar);
            }
        }
    }
}
