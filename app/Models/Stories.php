<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;
    protected $fillable = [
        'expiration_timestamp',
        'user_id',
        'viewer_count',
        'type',
        'file_name_story'

    ];
    public $timestamp = false;
    protected $hidden = [
        'user'
    ];
    protected $table = 'stories';
    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}