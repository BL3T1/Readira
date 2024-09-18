<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message'
    ];
}
