<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes["slug"] = $slug;
    }

    public function incrementSlug($slug)
    {
        $original = $slug;

        $count = 2;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        return $slug;
    }
}
