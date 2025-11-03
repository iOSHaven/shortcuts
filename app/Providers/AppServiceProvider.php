<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro("resolve", function ($url) {
            $client = new \GuzzleHttp\Client([
                "allow_redirects" => false, // don't follow automatically
                "timeout" => 10,
                "verify" => false, // ignore SSL issues if needed
                "headers" => [
                    "User-Agent" =>
                        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) " .
                        "AppleWebKit/537.36 (KHTML, like Gecko) " .
                        "Chrome/118.0.0.0 Safari/537.36",
                    "Accept" =>
                        "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                    "Accept-Language" => "en-US,en;q=0.9",
                    "Referer" => $url,
                ],
            ]);

            $redirectChain = [];
            $currentUrl = $url;

            try {
                while (true) {
                    $response = $client->head($currentUrl);
                    $status = $response->getStatusCode();

                    if ($status >= 300 && $status < 400) {
                        $nextUrl = $response->getHeaderLine("Location");

                        if (!$nextUrl) {
                            break;
                        }

                        // Resolve relative redirects
                        $nextUrl = \GuzzleHttp\Psr7\UriResolver::resolve(
                            new \GuzzleHttp\Psr7\Uri($currentUrl),
                            new \GuzzleHttp\Psr7\Uri($nextUrl),
                        )->__toString();

                        $redirectChain[] = $nextUrl;
                        $currentUrl = $nextUrl;
                    } else {
                        break;
                    }
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return ["error" => $e->getMessage(), "chain" => $redirectChain];
            }

            return [
                "original" => $url,
                "final" => $currentUrl,
                "chain" => $redirectChain,
            ];
        });

        URL::macro("paginatorWindow", function ($paginator, $window = 4) {
            $last = $paginator->lastPage();
            $current = min($paginator->currentPage(), $last);
            $elements = [];
            $elements[] = [1 => $paginator->url(1)];
            if ($current > 1) {
                $elements[] = "...";
            }
            $middle = [];

            if ($current === 1) {
                $current = 2;
            }

            for ($i = $current; $i < $current + $window && $i <= $last; $i++) {
                $middle[$i] = $paginator->url($i);
            }

            for ($i = count($middle); $i < $window; $i++) {
                if ($i > 0) {
                    $j = max(array_keys($middle)) - $i;
                    if ($j > 1) {
                        $middle[$j] = $paginator->url($j);
                    }
                }
            }
            ksort($middle);
            $elements[] = $middle;
            return $elements;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define("modify-slugs", function ($user) {
            return $user->can_modify_slugs;
        });

        Gate::define("crud-posts", function ($user) {
            return $user->can_crud_posts;
        });

        RouteServiceProvider::loadCachedRoutesUsing(
            fn() => $this->loadCachedRoutes(),
        );

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post("/livewire/update", $handle)
                ->middleware("web")
                ->prefix(LaravelLocalization::setLocale());
        });

        Event::listen(function (
            \SocialiteProviders\Manager\SocialiteWasCalled $event,
        ) {
            $event->extendSocialite(
                "google",
                \SocialiteProviders\Google\Provider::class,
            );
            $event->extendSocialite(
                "facebook",
                \SocialiteProviders\Facebook\Provider::class,
            );
            $event->extendSocialite(
                "twitter",
                \SocialiteProviders\Twitter\Provider::class,
                \SocialiteProviders\Twitter\Server::class,
            );
        });
    }
}
