<?php

namespace App\DTO;

use App\Models\User;
use Illuminate\Http\Request;

class UserDto
{
    public function __construct(
        public readonly User $user,
    )
    {
    }

    public static function user(Request $request): UserDto
    {
        return new self(
            user: $request->user(),
        );
    }
}
