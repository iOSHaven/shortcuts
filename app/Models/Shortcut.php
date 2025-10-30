<?php

namespace App\Models;

use App\Observers\ShortcutObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

#[ObservedBy(ShortcutObserver::class)]
class Shortcut extends Model
{
    use HasSlug;
    use Searchable;

    protected $hidden = ["scrape_id"];

    protected $fillable = [
        "icon",
        "link",
        "name",
        "markdown",
        "html",
        "short",
        "scrape_id",
        "slug",
    ];

    public function toSearchableArray()
    {
        return [
            ...Arr::only($this->toArray(), [
                "name",
                "short",
                "created_at",
                "downloads",
            ]),
            "author_ids" => $this->authors()->pluck("users.id")->toArray(),
        ];
    }

    public function getDetailsUrlAttribute()
    {
        return $this->slug ? route("shortcut", $this) : "#";
    }

    public function getDownloadUrlAttribute()
    {
        return $this->slug ? route("shortcut.download", $this) : "#";
    }

    public function getEditUrlAttribute()
    {
        return $this->slug ? route("shortcut.edit", $this) : "#";
    }

    public function authors(): MorphToMany
    {
        return $this->morphToMany(User::class, "model", table: "authorables");
    }
}
