<?php

namespace App\Http\Controllers\Api;

use App\Services\PlaceProvider;
use App\Http\Requests\PlaceRequest;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    // invoke
    public function __invoke(PlaceRequest $request)
    {
        $places = PlaceProvider::getPlaces(
            $request->get('lat'),
            $request->get('long'),
            $request->get('radius', 5000)
        );

        $results = collect($places['results'] ?? [])
            ->map(fn ($place) => $place['name'])
            ->all();

        return response([
            'results' => $results,
        ], 200);
    }
}
