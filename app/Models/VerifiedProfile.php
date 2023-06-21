<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifiedProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'start_timestamp',
        'expiration_timestamp'
    ];

    public $timeStamp = false;
    protected $table = 'verified_profiles';
}
