<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RESTResponse extends Facade
{
    /**
     * Get a schema builder instance for RESTResponse
     *
     * @return RESTResponse
     */
    protected static function getFacadeAccessor()
    {
        return 'RESTResponse';
    }
}
