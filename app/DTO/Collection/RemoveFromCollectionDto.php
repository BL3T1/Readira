<?php

namespace App\DTO\Collection;

use App\Http\Requests\Collection\RemoveFromCollectionRequest;
use App\Models\User;

class RemoveFromCollectionDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly string $name
    )
    {
    }

    public static function remove(RemoveFromCollectionRequest $request): RemoveFromCollectionDto
    {
        return new self(
            id: $request->bookId,
            user: $request->user(),
            name: $request->name
        );
    }
}
