<?php

namespace App\Models;

use App\Livewire\PostDetail;
use App\Traits\HasSlug;
use DirectoryTree\Metrics\HasMetrics;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    use HasMetrics;
    use HasSlug;
    use Searchable;

    protected $fillable = [
        "show_on_feed",
        "allow_comments",
        "title",
        "markdown",
        "html",
        "slug",
        "thumbnail",
        "views_all_time",
        "views_last_24",
    ];

    public function toSearchableArray()
    {
        return [
            ...Arr::only($this->toArray(), ["title", "created_at"]),
            "author_ids" => $this->authors()->pluck("users.id")->toArray(),
            "score" => $this->score ?: 0,
        ];
    }

    public function getEditUrlAttribute()
    {
        return $this->slug ? route("post.edit", $this) : "#";
    }

    public function getDetailsUrlAttribute()
    {
        return $this->slug ? route("post.detail", $this) : "#";
    }

    public function getScoreAttribute()
    {
        $all_time = $this->views_all_time;
        $recent = $this->views_last_24;
        $max_all = Cache::remember(
            "metrics.posts.max_all_time",
            3600,
            function () {
                return static::selectRaw("MAX(views_all_time) as m")->value(
                    "m",
                ) ?:
                    1;
            },
        );
        $max_recent = $maxRecent = Cache::remember(
            "metrics.posts.max_recent",
            3600,
            function () {
                return static::selectRaw("MAX(views_last_24) as m")->value(
                    "m",
                ) ?:
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

    public static function renderDetail($slug)
    {
        $post = static::whereSlug($slug)->firstOrFail();
        request()->route()->setParameter("post", $post);
        return app()->call(PostDetail::class . "@__invoke");
    }
}
