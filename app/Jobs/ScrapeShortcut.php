<?php

namespace App\Jobs;

use App\Models\Shortcut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Parsedown;
use Symfony\Component\DomCrawler\Crawler;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use League\HTMLToMarkdown\Converter\TableConverter;

class ScrapeShortcut implements ShouldQueue
{
    use Queueable;

    public $url;
    public $downloadUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $href)
    {
        $this->url = "https://routinehub.co{$this->href}";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = Http::withHeaders([
            "User-Agent" =>
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) " .
                "AppleWebKit/537.36 (KHTML, like Gecko) " .
                "Chrome/118.0.0.0 Safari/537.36",
            "Accept" =>
                "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language" => "en-US,en;q=0.9",
            "Referer" => "https://routinehub.co/",
        ]);
        $response = $client->get($this->url);
        $html = $response->body();
        $crawler = new Crawler($html);
        $downloadLink = $crawler->filter(".actions a")->first()->attr("href");
        $this->downloadUrl = "https://routinehub.co$downloadLink";
        $shortcutUrl = URL::resolve($this->downloadUrl);

        $description = $crawler
            ->filter(".description .content")
            ->first()
            ->html();

        $subtitle = $crawler->filter(".titles .subtitle")->first()->html();

        $converter = new HtmlConverter();
        $converter->getEnvironment()->addConverter(new TableConverter());
        $markdown = $converter->convert($description);

        $shortcutData = $this->scrapeApplePage($shortcutUrl["final"]);

        $response = Http::get($shortcutData["icon"]);
        $filename = "img/" . md5(basename($shortcutData["icon"])) . ".png";
        Storage::disk("public")->put($filename, $response->body());

        // todo save icon image to public storage
        $data = [
            "icon" => Storage::url($filename),
            "link" => $shortcutUrl["final"],
            "name" => $shortcutData["name"],
            "markdown" => $markdown,
            "short" => $subtitle,
        ];

        $id = Str::between($this->href, "/shortcut/", "/");

        /** @var \App\Models\Shortcut $shortcut */
        $shortcut = Shortcut::updateOrCreate(["scrape_id" => $id], $data);
        $shortcut->authors()->syncWithoutDetaching([1]);
    }

    public function scrapeApplePage($url)
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch();
        $page = $browser->newPage();
        $page->goto($url);
        usleep(1000 * 1000);
        $shortcutData = $page->evaluate(
            JsFunction::createWithBody("
                return {
                icon: document.querySelector('#shortcut-icon').src,
                name: document.querySelector('#shortcut-name').innerHTML
                };
            "),
        );
        $browser->close();
        return $shortcutData;
    }
}
