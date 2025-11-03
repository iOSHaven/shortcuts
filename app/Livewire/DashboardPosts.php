<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;

class DashboardPosts extends Component
{
    #[Url]
    public $search;

    public function render()
    {
        return view("livewire.dashboard-posts");
    }

    public function posts()
    {
        return Post::search($this->search, function (
            $meilisearch,
            $query,
            $options,
        ) {
            $options["filter"] = "author_ids = " . auth()->id();
            return $meilisearch->search($query, $options);
        })->paginate(36);
    }
}
