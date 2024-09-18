<?php

namespace App\DTO\Book;

use App\Models\User;
use App\Http\Requests\Books\RateRequest;

class RateDto
{
    public function __construct(
        public readonly int $bookId,
        public readonly float $rate,
        public readonly User $user,
    )
    {
    }

    public static function rate(RateRequest $request)
    {
        return new self(
            bookId: $request->bookId,
            rate: $request->rate,
            user: $request->user(),
        );
    }
}
