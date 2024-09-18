<?php

namespace App\DTO\BookMark;

use App\Http\Requests\Progress\BookMark\showBookMarkRequest;
use App\Models\User;

class showBookMarkDto
{
    public function __construct(
        public readonly int $book_id,
        public readonly User $user,
        public readonly string $book_mark,
    )
    {
    }

    public static function bookMark(showBookMarkRequest $request): showBookMarkDto
    {
        return new self(
            book_id: $request->book_id,
            user: $request->user(),
            book_mark: $request->book_mark,
        );
    }
}
