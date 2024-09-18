<?php

namespace App\DTO\Comments;

use App\Http\Requests\Comments\ReplyRequest;
use App\Models\User;

class ReplyDto
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly string $content
    )
    {
    }

    public static function reply(ReplyRequest $request): ReplyDto
    {
        return new self(
            id: $request->commentId,
            user: $request->user(),
            content: $request->reply
        );
    }
}
