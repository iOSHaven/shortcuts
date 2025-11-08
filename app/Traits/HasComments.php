<?php

namespace App\Traits;

use App\Models\Comment;
use App\Models\Commentable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use function Laravel\Prompts\table;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "model");
    }

    public function scopeWithCommentDepth($query, $depth)
    {
        return $query->with(implode(".", array_fill(0, $depth, "comments")));
    }
}
