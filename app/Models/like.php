<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class like extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'comment_id',
    ];



    public function book():BelongsToMany
    {
        return $this->belongsToMany(Comment::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}



