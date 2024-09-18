<?php

namespace App\DTO;

use App\Http\Requests\IdRequest;
use App\Models\User;

class IdDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user
    )
    {
    }

    public static function id(IdRequest $request): IdDto
    {
        return new self(
            id: $request->id,
            user: $request->user()
        );
    }
}
