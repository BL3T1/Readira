<?php

namespace App\DTO\Progress;

use App\Http\Requests\Progress\ProgressRequest;
use App\Models\User;

class ProgressDto
{

    public function __construct(
        public readonly User $user,
    )
    {
    }

    public static function progress(ProgressRequest $request): ProgressDto
    {
        return new self(
            user: $request->user(),
        );
    }
}
