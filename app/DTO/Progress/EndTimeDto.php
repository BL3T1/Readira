<?php

namespace App\DTO\Progress;

use App\Http\Requests\Progress\EndTimeRequest;
use App\Models\User;

class EndTimeDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly int $endPage,
        public readonly string $endTime,
    )
    {
    }

    public static function endTime(EndTimeRequest $request): EndTimeDto
    {
        return new self(
            id: $request->bookId,
            user: $request->user(),
            endPage: $request->endPage,
            endTime: $request->endTime,
        );
    }
}
