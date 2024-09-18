<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'start_time',
        'end_time',
        'read_time',
        'start_page_number',
        'end_page_number',
        'ratio',
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
