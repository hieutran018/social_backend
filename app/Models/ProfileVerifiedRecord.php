<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVerifiedRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'ocument_type',
        'verified_image_front',
        'verified_image_backside',
        'outstanding_type',
        'county',
        'quote_one',
        'quote_two',
        'quote_three',
        'quote_four',
        'quote_five',
        'status'
    ];
    protected $table = 'profile_verified_records';
    public $timestamps = false;
}
