<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shortcut;

class ShortcutEdit extends Component
{
    public Shortcut $shortcut;
    public $description = "Enter a description";
    public $short = "";
    public $saved = false;

    public function mount()
    {
        $this->description = $this->shortcut->markdown;
        $this->short = $this->shortcut->short;
    }

    public function save()
    {
        $this->saved = false;
        $this->validate([
            "short" => ["min:3", "max:100", "string", "required"],
            "description" => ["required", "min:20", "max:60000", "string"],
        ]);
        $this->shortcut->markdown = $this->description;
        $this->shortcut->short = $this->short;
        $this->shortcut->save();
        $this->saved = true;
    }

    public function render()
    {
        return view("livewire.shortcut-edit");
    }
}
