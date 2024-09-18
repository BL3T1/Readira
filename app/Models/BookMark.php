<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'page_number',
        'book_mark',
        'note',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_marks', 'book_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_marks', 'user_id');
    }
}
