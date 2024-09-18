<?php

namespace App\DTO\Comments;

use App\Http\Requests\Comments\ChangeCommentRequest;
use App\Models\User;

class ChangeCommentDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly string $content,
    )
    {

    }

    public static function update(ChangeCommentRequest $request): ChangeCommentDto
    {
        return new self(
            id: $request->commentId,
            user: $request->user(),
            content: $request->comment,
        );
    }
}
