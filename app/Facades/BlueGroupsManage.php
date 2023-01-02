<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\BlueGroupsManageService;
use App\Services\Contracts\BlueGroupsManageServiceInterface;

class BlueGroupsManage extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BlueGroupsManageServiceInterface::class;
    }

}
