<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function users()
    {
        return $this->hasMany(Author::class);
    }
}
