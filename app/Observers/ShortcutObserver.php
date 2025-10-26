<?php

namespace App\Observers;

use App\Models\Shortcut;
use Illuminate\Support\Str;
use Parsedown;

class ShortcutObserver
{
    /**
     * Handle the Shortcut "created" event.
     */
    public function creating(Shortcut $shortcut): void
    {
        $shortcut->slug = Str::slug($shortcut->name) ?: Str::random(5);
    }

    public function saving(Shortcut $shortcut): void
    {
        $parsedown = new Parsedown();
        $shortcut->html = $parsedown->text($shortcut->markdown);
    }

    /**
     * Handle the Shortcut "updated" event.
     */
    public function updated(Shortcut $shortcut): void
    {
        //
    }

    /**
     * Handle the Shortcut "deleted" event.
     */
    public function deleted(Shortcut $shortcut): void
    {
        //
    }

    /**
     * Handle the Shortcut "restored" event.
     */
    public function restored(Shortcut $shortcut): void
    {
        //
    }

    /**
     * Handle the Shortcut "force deleted" event.
     */
    public function forceDeleted(Shortcut $shortcut): void
    {
        //
    }
}
