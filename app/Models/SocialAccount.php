<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'provider_id',
        'email',
        'user_id'
    ];
    
    protected $timestamp = false;

    protected $table = 'social_account';
}