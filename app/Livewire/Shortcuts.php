<?php

namespace App\Livewire;

use App\Models\Shortcut;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Shortcuts extends Component
{
    use WithPagination;

    #[Url]
    public $sort = "popular";

    #[Url]
    public $search = "";

    public function updatedSearch()
    {
        $this->gotoPage(1);
    }

    public function setSort($value)
    {
        $this->sort = $value;
    }

    public function render()
    {
        return view("livewire.shortcuts");
    }

    public function shortcuts()
    {
        $query = Shortcut::search($this->search);
        $query = match ($this->sort) {
            "newest" => $query->orderBy("created_at", "desc"),
            "oldest" => $query->orderBy("created_at", "asc"),
            "recent" => $query->orderBy("updated_at", "desc"),
            default => $query->orderByDesc("downloads"),
        };
        return $query->paginate(36);
    }
}
