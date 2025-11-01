<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shortcut;

class ShortcutEdit extends Component
{
    public Shortcut $shortcut;
    public $description = "Enter a description";
    public $short = "";

    public function mount()
    {
        $this->description = $this->shortcut->markdown;
        $this->short = $this->shortcut->short;
    }

    public function save()
    {
        $this->validate([
            "short" => ["min:3", "max:100", "string", "required"],
            "description" => ["required", "min:20", "max:65000", "string"],
        ]);
        $this->shortcut->markdown = $this->description;
        $this->shortcut->short = $this->short;
        $this->shortcut->save();
    }

    public function render()
    {
        return view("livewire.shortcut-edit");
    }
}
