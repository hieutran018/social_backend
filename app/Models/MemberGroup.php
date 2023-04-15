<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class MemberGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'group_id',
        'isAdminGroup'
    ];
    protected $table = 'member_group';
    public $timestamps = false;
    
}