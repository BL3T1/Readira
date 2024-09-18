<?php

namespace App\Http\Controllers\User;

use App\DTO\Comments\ChangeCommentDto;
use App\DTO\Comments\CommentDto;
use App\DTO\Comments\ReplyDto;
use App\DTO\IdDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\ChangeCommentRequest;
use App\Http\Requests\Comments\CommentRequest;
use App\Http\Requests\Comments\ReplyRequest;
use App\Http\Requests\IdRequest;
use App\Models\Comment;
use App\Models\Reply;
use App\Services\Facades\CommentFacade;
use App\Traits\GeneralTraits;
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    use GeneralTraits;
    public function comment(CommentRequest $request): JsonResponse
    {
        $dto = CommentDto::comment($request);

        $comment = CommentFacade::comment($dto);

        return $this -> returnData('comment', $comment);
    }
    public function like(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $comment = CommentFacade::like($dto);
        
        if($comment[1]==1){
        return $this -> returnData('comment', $comment,'added');
        }else{
            return $this -> returnData('comment', $comment,'deleted');
        }
    }
    public function delete(IdRequest $request): void
    {
        $dto = IdDto::id($request);

        CommentFacade::delete($dto);
    }
    public function reply(ReplyRequest $request): JsonResponse
    {
        $dto = ReplyDto::reply($request);

        $reply = CommentFacade::reply($dto);

        return $this -> returnData('reply', $reply);
    }
    public function update(ChangeCommentRequest $request): JsonResponse
    {
        $dto = ChangeCommentDto::update($request);

        $updated_comment = CommentFacade::updateComment($dto);

        return $this -> returnData('update_comment', $updated_comment);
    }
    public function getComments(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $comments = CommentFacade::getComments($dto);

        return $this -> returnData(200, 'comments', $comments);
    }
}
