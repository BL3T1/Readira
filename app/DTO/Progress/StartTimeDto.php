<?php

namespace App\DTO\Progress;

use App\Http\Requests\Progress\ProgressRequest;
use App\Http\Requests\Progress\StartTimeRequest;
use App\Models\Book;
use App\Models\User;
use phpseclib3\File\ASN1\Maps\Time;

class StartTimeDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly int $startPage,
        public readonly string $startTime,
    )
    {
    }

    public static function startTime(StartTimeRequest $request): StartTimeDto
    {
        return new self(
            id: $request->bookId,
            user: $request->user(),
            startPage: $request->startPage,
            startTime: $request->startTime
        );
    }
}
