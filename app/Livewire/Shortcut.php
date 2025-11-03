<?php

namespace App\Livewire;

use Livewire\Component;

class Shortcut extends Component
{
    public \App\Models\Shortcut $shortcut;

    public function mount()
    {
        metric("views")->measurable($this->shortcut)->hourly()->record();
    }

    public function render()
    {
        return view("livewire.shortcut");
    }
}
