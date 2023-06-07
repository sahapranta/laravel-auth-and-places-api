<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Services\GooglePlaceProvider;
use App\Services\PlaceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceTest extends TestCase
{
    public function test_get_places_api()
    {
        $lat = 40.7128;
        $long = -74.0060;

        $places = [
            'results' => [
                ['name' => 'Place 1'],
                ['name' => 'Place 2'],
            ],
        ];

        // $mockedProvider = $this->mock(GooglePlaceProvider::class);

        PlaceProvider::shouldReceive('getPlaces')
            ->once()
            ->with($lat, $long, 5000)
            ->andReturn($places);

        $response = $this->getJson("/api/places?lat={$lat}&long={$long}");

        $response->assertStatus(200)
            ->assertJson(['results' => ['Place 1', 'Place 2']]);
    }
}
