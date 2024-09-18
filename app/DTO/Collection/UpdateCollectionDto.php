<?php

namespace App\DTO\Collection;

use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Models\User;

class UpdateCollectionDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly string $name
    )
    {
    }

    public static function update(UpdateCollectionRequest $request): UpdateCollectionDto
    {
        return new self(
            id: $request->bookId,
            user: $request->user(),
            name: $request->name,
        );
    }
}
