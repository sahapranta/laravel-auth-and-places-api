<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\GooglePlaceProvider;
use Illuminate\Support\Facades\Config;

class GooglePlaceProviderTest extends TestCase
{
    protected $baseUrl = 'https://maps.googleapis.com/';
    protected $provider;

    public function setUp(): void
    {
        parent::setUp();
        Config::set('services.google_map.api_key', 'MAP_API_KEY');
        $this->provider = new GooglePlaceProvider();
        Http::preventStrayRequests();
    }


    public function test_get_places_success()
    {
        Http::fake([
            "*" => Http::response(['results' => ['Place 1', 'Place 2']], 200),
        ]);

        $places = $this->provider->getPlaces(...$this->getLocationInfo());

        $this->assertNotEmpty($places);
        $this->assertArrayHasKey('results', $places);
        $this->assertEquals(['Place 1', 'Place 2'], $places['results']);

        Http::assertSent(fn ($request) => $this->matchInfo($request));
    }

    public function test_get_places_failure()
    {
        Http::fake([
            "*" => Http::response([], 500),
        ]);


        $places = $this->provider->getPlaces(...$this->getLocationInfo());

        Log::shouldReceive('error')->zeroOrMoreTimes();

        $this->assertEmpty($places);

        Http::assertSent(fn ($request) => $this->matchInfo($request));
    }

    protected function getLocationInfo(): Collection
    {
        return collect([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'radius' => 5000,
            'language' => 'en',
        ]);
    }

    protected function matchInfo($request): bool
    {
        $url = "{$this->baseUrl}maps/api/place/nearbysearch/json";

        $locationInfo = $this->getLocationInfo()
            ->only('latitude', 'longitude')
            ->implode(',');

        return str_contains($request->url(), $url) &&
            $request['location'] === $locationInfo &&
            $request['key'] === config('services.google_map.api_key');
    }
}
