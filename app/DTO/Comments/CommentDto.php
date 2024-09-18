<?php

namespace App\DTO\Comments;

use App\Http\Requests\Comments\CommentRequest;
use App\Models\User;

class CommentDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly string $content,
    )
    {
    }

    public static function comment(CommentRequest $request): CommentDto
    {
        return new self(
            id: $request->bookId,
            user: $request->user(),
            content: $request->comment
        );
    }
}
