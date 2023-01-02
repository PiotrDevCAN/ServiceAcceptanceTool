<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\BlueGroupsService;
use App\Services\Contracts\BlueGroupsServiceInterface;

class BlueGroups extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BlueGroupsServiceInterface::class;
    }

}
