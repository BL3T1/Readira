<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'book_id',
        'content',
        'likes',
        'parent_id',
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function likes(): HasMany
    {
        return $this->hasMany(like::class);
    }
}
