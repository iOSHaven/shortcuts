<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleSwitcher extends Component
{
    public $locale;
    public $currentRoute;
    public $currentParams;

    public function mount()
    {
        $this->locale = App::getLocale();
        $this->currentRoute = Route::currentRouteName();
        $this->currentParams = request()->route()->parameters();
        session()->forget("backLabel");
    }

    public function updatedLocale($value)
    {
        $uri =
            LaravelLocalization::getURLFromRouteNameTranslated(
                $this->locale,
                "routes." . $this->currentRoute,
                $this->currentParams,
            ) ?:
            LaravelLocalization::getURLFromRouteNameTranslated(
                $this->locale,
                "routes.home",
            );

        $url = LaravelLocalization::getLocalizedURL(
            $this->locale,
            $uri,
            [],
            true,
        );

        $backUrl = LaravelLocalization::getURLFromRouteNameTranslated(
            $this->locale,
            "routes.home",
        );

        session()->put("backLabel", trans("Home", [], $this->locale));

        // return redirect($url);
        $this->dispatch("replace-location", url: $url, back: $backUrl);
    }

    public function render()
    {
        return view("livewire.locale-switcher");
    }
}
