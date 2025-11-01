<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;

class LocaleSwitcher extends Component
{
    public $locale;

    public function mount()
    {
        $this->locale = App::getLocale();
    }

    public function updatedLocale($value)
    {
        $this->locale = $value;
        App::setLocale($value);
    }

    public function render()
    {
        return view("livewire.locale-switcher");
    }
}
