<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use App\Models\Shortcut;
use Illuminate\Support\Facades\Auth;

class ShortcutCreate extends Component
{
    public $step = 1;
    public $icloud_url;
    public $icon;
    public $name;
    public $short;
    public $description = "Enter a description.";

    public function render()
    {
        return view("livewire.shortcut-create");
    }

    public function save()
    {
        $this->validate([
            "description" => ["min:20", "string", "max:60000", "required"],
            "short" => ["min:3", "max:100", "string", "required"],
        ]);

        $shortcut = Shortcut::create([
            "name" => $this->name,
            "icon" => $this->icon,
            "markdown" => $this->description,
            "short" => $this->short,
            "link" => $this->icloud_url,
        ]);

        $shortcut->authors()->syncWithoutDetaching([Auth::user()->id]);

        return redirect(route("shortcut.edit", $shortcut));
    }

    public function next()
    {
        $this->validate([
            "icloud_url" => [
                "required",
                "url",
                'regex:/^https:\/\/www\.icloud\.com\/shortcuts\/[a-zA-Z0-9]+$/',
            ],
        ]);

        try {
            $this->scrapeShortcut();
            $this->step = 2;
        } catch (\Exception $e) {
            throw $e;
            throw ValidationException::withMessages([
                "icloud_url" =>
                    "Unable to scrape shortcut data. Make sure it’s a valid iCloud link.",
            ]);
        }
    }

    public function scrapeShortcut()
    {
        $puppeteer = new Puppeteer([
            "executable_path" => config("app.node_path"),
        ]);
        $browser = $puppeteer->launch();
        $page = $browser->newPage();
        $page->goto($this->icloud_url);
        usleep(1000 * 1000);
        $shortcutData = $page->evaluate(
            JsFunction::createWithBody("
                return {
                icon: document.querySelector('#shortcut-icon').src,
                name: document.querySelector('#shortcut-name').innerHTML,
                description: document.querySelector('#shortcut-description').innerHTML
                };
            "),
        );
        $browser->close();
        $response = Http::get($shortcutData["icon"]);
        $filename = "img/" . md5(basename($shortcutData["icon"])) . ".png";
        Storage::disk("public")->put($filename, $response->body());

        $this->icon = Storage::url($filename);
        $this->name = trim($shortcutData["name"]);
        $this->description = trim($shortcutData["description"]);
    }
}
