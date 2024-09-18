<?php

namespace App\DTO;

use App\Http\Requests\MessageRequest;
use App\Models\User;

class MessageDto
{
    public function __construct(
        public readonly int $sender_id,
        public readonly int $receiver_id,
        public readonly string $message
    )
    {
    }

    public function message(MessageRequest $request)
    {
        return new self(
            sender_id: $request->user()->id,
            receiver_id: $request->receiver_id,
            message: $request->message
        );
    }
}
