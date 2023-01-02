<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\BluePagesService;
use App\Services\Contracts\BluePagesServiceInterface;

class BluePages extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BluePagesServiceInterface::class;
    }

}
