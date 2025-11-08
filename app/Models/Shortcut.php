<?php

namespace App\Models;

use App\Observers\ShortcutObserver;
use DirectoryTree\Metrics\HasMetrics;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use App\Contracts\Commentable;

#[ObservedBy(ShortcutObserver::class)]
class Shortcut extends Model implements Commentable
{
    use HasSlug;
    use Searchable;
    use HasMetrics;
    use HasComments;

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
        "views_all_time",
        "views_last_24",
        "downloads_all_time",
        "downloads_last_24",
    ];

    public function toSearchableArray()
    {
        return [
            ...Arr::only($this->toArray(), ["name", "short", "created_at"]),
            "author_ids" => $this->authors()->pluck("users.id")->toArray(),
            "score" => $this->score ?: 0,
        ];
    }

    public function getDetailsUrlAttribute()
    {
        return $this->slug ? route("shortcut.detail", $this) : "#";
    }

    public function getDownloadUrlAttribute()
    {
        return $this->slug ? route("shortcut.download", $this) : "#";
    }

    public function getEditUrlAttribute()
    {
        return $this->slug ? route("shortcut.edit", $this) : "#";
    }

    public function getScoreAttribute()
    {
        $all_time = $this->views_all_time + $this->downloads_all_time;
        $recent = $this->views_last_24 + $this->downloads_last_24;
        $max_all = Cache::remember("metrics.max_all_time", 3600, function () {
            return static::selectRaw(
                "MAX(views_all_time + downloads_all_time) as m",
            )->value("m") ?:
                1;
        });
        $max_recent = $maxRecent = Cache::remember(
            "metrics.max_recent",
            3600,
            function () {
                return static::selectRaw(
                    "MAX(views_last_24 + downloads_last_24) as m",
                )->value("m") ?:
                    1;
            },
        );
        $norm_all = log($all_time + 1) / log($max_all + 1);
        $norm_recent = log($recent + 1) / log($max_recent + 1);
        $w_all = 0.4;
        $w_recent = 0.6;
        $score = $w_all * $norm_all + $w_recent * $norm_recent;
        return $score;
    }

    public function authors(): MorphToMany
    {
        return $this->morphToMany(User::class, "model", table: "authorables");
    }
}
