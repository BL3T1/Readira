<?php

namespace App\DTO\Collection;

use App\Http\Requests\Collection\RemoveCollectionRequest;
use App\Models\User;

class RemoveCollectionDto
{
    public function __construct(
        public readonly string $name,
        public readonly User $user,
    )
    {
    }

    public static function remove(RemoveCollectionRequest $request): RemoveCollectionDto
    {
        return new self(
            name: $request->name,
            user: $request->user(),
        );
    }
}
