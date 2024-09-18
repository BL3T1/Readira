<?php

namespace App\Services\Services;

use App\DTO\IdDto;
use App\Models\Book;
use App\Models\like;
use App\Models\Comment;
use App\DTO\Comments\ReplyDto;
use App\DTO\Comments\CommentDto;
use App\DTO\Comments\ChangeCommentDto;
use App\Services\Contracts\CommentContract;
use \Illuminate\Database\Eloquent\Collection;

class CommentService implements CommentContract
{

    public function comment(CommentDto $data):comment
    {
        $book = Book::where('id', $data->id)
            -> first();

        $book->comments_time += 1;

        $book
            -> save();

        $comments= Comment::create([
            'user_id' => $data->user->id,
            'book_id' => $data->id,
            'content' => $data->content,
            'likes' => 0,
        ]);

        $comment = Comment::with('users')->where('id',$comments->id)->first();
        return $comment;
    }

    public function like(IdDto $data): Array
     {
        $comment = Comment::where('user_id', $data->user->id)
            -> where('id', $data->id)
            -> first();

  

        $userLike=Like::where('user_id', $data->user->id)-> where('comment_id', $data->id)->first();
        if(!$userLike){
        $like = like::create([
            'user_id' => $data->user->id,
            'comment_id' => $data->id,
        ]);
        $comment->likes +=1;
        $comment->save();
        return [$comment,1];
    }else{
        $userLike->delete();
        $comment->likes -=1;
        $comment->save();
        return [$comment,0];

    }
    }


    public function delete(IdDto $data): void
    {
        Comment::where('user_id', $data->user->id)
            -> where('id', $data->id)
            -> delete();
    }

    public function reply(ReplyDto $data): Comment
    {
        $parent_comment = Comment::where('id', $data->id)
            -> first();

         return Comment::create([
            'user_id' => $data->user->id,
            'book_id' => $parent_comment->book_id,
            'content' => $data->content,
            'likes' => 0,
            'parent_id' => $parent_comment->id
        ]);
    }

    public function updateComment(ChangeCommentDto $data): Comment
    {
        $comment = Comment::where('user_id', $data->user->id)
            -> where('id', $data->id)
            -> first();

        $comment->content = $data->content;

        $comment
            -> save();

        return $comment;
    }

    public function getComments(IdDto $data): Collection
    {
        $comments = Comment::with('users')->where('book_id', $data->id)
            -> get();

        return $comments;
    }
}
