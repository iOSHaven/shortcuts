<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shortcut;

class ShortcutEdit extends Component
{
    public Shortcut $shortcut;
    public $description = "Enter a description";

    public function mount()
    {
        $this->description = $this->shortcut->markdown;
    }

    public function save()
    {
        $this->shortcut->markdown = $this->description;
        $this->shortcut->save();
    }

    public function render()
    {
        return view("livewire.shortcut-edit");
    }
}
