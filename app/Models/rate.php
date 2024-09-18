<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rate extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'userRate'
    ];
    use HasFactory;



    public function books():BelongsTo
    {
        return $this->BelongTo(Book::class,'book_id');
    }
    public function users():BelongsTo
    {
        return $this->BelongTo(User::class,'user_id');
    }

}
