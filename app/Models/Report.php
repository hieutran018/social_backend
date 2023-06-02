<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'object_type',
        'object_id',
        'conent_report',
        'isProcessed'

    ];
    public $timestamp = false;
    protected $table = 'reports';
}
