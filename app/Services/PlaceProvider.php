<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class PlaceProvider extends Facade
{

    protected static function getFacadeAccessor()
    {
        return GooglePlaceProvider::class;
    }
}
