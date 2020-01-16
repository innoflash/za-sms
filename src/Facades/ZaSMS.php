<?php

namespace Innoflash\ZaSms\Facades;

use Illuminate\Support\Facades\Facade;

class ZaSMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'za-sms';
    }
}
