<?php

namespace App\DTO\Collection;

use App\Http\Requests\Collection\CreateCollectionRequest;
use App\Models\User;

class CreateCollectionDto
{
    public function __construct(
        public readonly User $user,
        public readonly string $name
    )
    {
    }
    public static function create(CreateCollectionRequest $request): CreateCollectionDto
    {
        return new self(
            user: $request->user(),
            name: $request->name,
        );
    }
}
