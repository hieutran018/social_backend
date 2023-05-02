<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeelAndActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'icon_name',
        'patch'
    ];
    public $timestamps = false;
    protected $table = 'feeling_and_activity_posts';
}
