<?php

namespace App\DTO\BookMark;

use App\Http\Requests\Progress\BookMark\getBookMarksRequest;
use App\Models\User;

class getBookMarksDto
{
    public function __construct(
        public readonly int $book_id,
        public readonly User $user,
    )
    {
    }

    public static function bookMark(getBookMarksRequest $request): getBookMarksDto
    {
        return new self(
            book_id: $request->book_id,
            user: $request->user(),
        );
    }
}
