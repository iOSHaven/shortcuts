<?php

namespace Database\Seeders;

use App\Jobs\ScrapeShortcut;
use DOMDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class RoutineHubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < env("ROUTINEHUB_PAGES", 10); $i++) {
            $response = Http::withHeaders([
                "User-Agent" =>
                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) " .
                    "AppleWebKit/537.36 (KHTML, like Gecko) " .
                    "Chrome/118.0.0.0 Safari/537.36",
                "Accept" =>
                    "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language" => "en-US,en;q=0.9",
                "Referer" => "https://routinehub.co/",
            ])->get("https://routinehub.co/shortcuts/?page={$i}&sort=top");

            $html = $response->body();

            $crawler = new Crawler($html);

            $links = $crawler->filter(
                ".column.is-6.is-4-widescreen.is-3-widescreen a",
            );

            // dump($links);
            foreach ($links as $link) {
                $href = $link->attributes->getNamedItem("href")->nodeValue;
                ScrapeShortcut::dispatch($href);
            }
        }
    }
}
