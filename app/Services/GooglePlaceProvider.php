<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GooglePlaceProvider implements PlaceProviderContract
{
    const RADIUS = 5000;
    const LANG = 'en';

    public function getPlaces($latitude, $longitude, $radius, $language = 'en')
    {
        try {
            $response = Http::acceptJson()
                ->get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
                    'location' => "{$latitude},{$longitude}",
                    'radius' => $radius ?? self::RADIUS,
                    'language' => $language ?? self::LANG,
                    'key' => config('services.google_map.api_key')
                ]);

            if (!$response->ok()) {
                return [];
            };

            return $response->json();
        } catch (\Throwable $th) {
            Log::error('Error fetching places from Google Maps API: ' . $th->getMessage(), [$th]);
            return [];
        }
    }
}
