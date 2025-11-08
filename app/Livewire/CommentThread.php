<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use App\Contracts\Commentable;
use Livewire\WithPagination;

class CommentThread extends Component
{
    use WithPagination;

    public Commentable $model;
    public $perPage = 10;
    public $comment;
    public $replyId;
    public $reply;

    public function comments()
    {
        return $this->model
            ->comments()
            ->with(["authors.social", "parent.authors.social"])
            ->orderBy("created_at", "desc")
            ->orderBy("id", "desc")
            ->paginate($this->perPage);
    }

    public function jumpToComment($commentId)
    {
        $index = $this->model
            ->comments()
            ->where("id", ">=", $commentId)
            ->orderBy("created_at", "desc")
            ->orderBy("id", "desc")
            ->count();

        $page = (int) ceil($index / $this->perPage);

        $this->setPage($page);

        $this->dispatch("highlight-comment", [
            "commentId" => $commentId,
        ]);
    }

    public function postComment()
    {
        $comment = $this->model->comments()->create([
            "markdown" => $this->comment,
        ]);

        $comment->authors()->syncWithoutDetaching(auth()->user()->id);
        $this->comment = "";
        $this->gotoPage(1, "page");
    }

    public function postReply()
    {
        $comment = Comment::findOrFail($this->replyId);
        $reply = $comment->reply([
            "markdown" => $this->reply,
        ]);
        $reply->authors()->syncWithoutDetaching(auth()->user()->id);
        $this->reply = "";
        $this->replyId = null;
        $this->gotoPage(1, "page");
    }

    public function render()
    {
        return view("livewire.comment-thread");
    }
}
