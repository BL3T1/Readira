<?php

namespace App\DTO\BookMark;

use App\Http\Requests\Progress\BookMark\BookMarkRequest;
use App\Models\User;

class BookMarkDto
{
    public function __construct(
        public readonly int $book_id,
        public readonly int $page_number,
        public readonly User $user,
        public readonly string $book_mark,
        public readonly string $note,
    )
    {
    }

    public static function bookMark(BookMarkRequest $request): BookMarkDto
    {
        return new self(
            book_id: $request->book_id,
            page_number: $request->page_number,
            user: $request->user(),
            book_mark: $request->book_mark,
            note: $request->note,
        );
    }
}
