<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'book_file',
        'author_id',
        'user_id',
        'publisher_id',
        'ISBN',
        'book_description',
        'publication_date',
        'quantity',
        'price',
        'visits_time',
        'downloads_time',
        'comments_time',
        'pages_number',
        'chapters_number',
        'download_size',
        'rating',
        'rater_number',
        'book_image',
    ];
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookMark::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'book_collections');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Favorite::class, 'favorites');
    }

    public function progress(): BelongsToMany
    {
        return $this->belongsToMany(Progress::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_users');
    }
}
