<?php

namespace App\Services;

use App\Services\Contracts\TestServiceInterface;

class TestService implements TestServiceInterface {

    public function myTest()
    {
        dump(__METHOD__);
    }
}
