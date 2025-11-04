<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
    </url>
    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <url>
            <loc>{{ LaravelLocalization::getURLFromRouteNameTranslated($localeCode, 'routes.privacy-policy') }}</loc>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{ LaravelLocalization::getURLFromRouteNameTranslated($localeCode, 'routes.tos') }}</loc>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{ LaravelLocalization::getURLFromRouteNameTranslated($localeCode, 'routes.how-to-delete') }}</loc>
            <priority>1.0</priority>
        </url>

    @endforeach

    @foreach ($shortcuts as $shortcut)
        <url>
            <loc>{{ LaravelLocalization::getURLFromRouteNameTranslated('en', 'routes.shortcut.detail', compact('shortcut')) }}</loc>
            <lastmod>{{ $shortcut->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
</urlset>
