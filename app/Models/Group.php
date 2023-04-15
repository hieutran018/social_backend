<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MemberGroup;
use App\Models\User;

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
        return $this->belongsToMany(User::class, 'member_group','group_id','user_id');
    }
}