<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'note',
        'payment_object',
        'price',
        'status'
    ];

    public $timeStamp = false;
    protected $table = 'payments';
}
