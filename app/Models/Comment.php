<?php

namespace App\Models;

use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy(CommentObserver::class)]
class Comment extends Model
{
    protected $fillable = ["markdown", "model_type", "model_id"];

    public function parent()
    {
        return $this->belongsTo(Comment::class, "parent_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "parent_id");
    }

    public function authors(): MorphToMany
    {
        return $this->morphToMany(User::class, "model", table: "authorables");
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function reply(array $attributes): Comment
    {
        return $this->comments()->create(
            array_merge($attributes, [
                "model_type" => $this->model_type,
                "model_id" => $this->model_id,
            ]),
        );
    }
}
