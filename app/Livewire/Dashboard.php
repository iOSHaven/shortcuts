<?php

namespace App\Livewire;

use App\Models\Shortcut;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class Dashboard extends Component
{
    #[Url]
    public $search;

    public function render()
    {
        return view("livewire.dashboard");
    }

    public function shortcuts()
    {
        return Shortcut::search($this->search, function (
            $meilisearch,
            $query,
            $options,
        ) {
            $options["filter"] = "author_ids = " . auth()->id();
            return $meilisearch->search($query, $options);
        })->paginate(36);
    }
}
