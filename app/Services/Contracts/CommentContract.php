<?php

namespace App\Services\Contracts;

use App\DTO\Comments\ChangeCommentDto;
use App\DTO\Comments\CommentDto;
use App\DTO\Comments\ReplyDto;
use App\DTO\IdDto;
use App\Models\Comment;
use \Illuminate\Database\Eloquent\Collection;

interface CommentContract
{
    public function comment(CommentDto $data): Comment;

    public function like(IdDto $data): array;

    public function delete(IdDto $data): void;

    public function reply(ReplyDto $data): Comment;

    public function updateComment(ChangeCommentDto $data): Comment;

    public function getComments(IdDto $data): Collection;
}
