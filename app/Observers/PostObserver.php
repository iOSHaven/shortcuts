<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
use Parsedown;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->slug = Str::slug($post->title) ?: Str::random(5);
    }

    public function saving(Post $post): void
    {
        $parsedown = new Parsedown();
        $post->html = $parsedown->text($post->markdown);
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
