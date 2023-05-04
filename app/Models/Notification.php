<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillalble = [
        'to',
        'from',
        'title',
        'unread',
        'object_type',
        'object_id',
        'icon_url',
    ];
    public $timestamps = false;
    protected $table = 'notifications';
    protected $hidden = [
        'user'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
