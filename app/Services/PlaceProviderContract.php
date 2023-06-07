<?php

namespace App\Services;

interface PlaceProviderContract
{
    public function getPlaces($latitude, $longitude, $radius, $language = 'null');
}
