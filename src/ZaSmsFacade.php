<?php

namespace Innoflash\ZaSms;

use Illuminate\Support\Facades\Facade;

class ZaSmsFacade extends Facade
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