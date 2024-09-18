<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'name',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_collections');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'collection_users');
    }

}
