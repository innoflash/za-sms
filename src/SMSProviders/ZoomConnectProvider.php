<?php

namespace Innoflash\ZaSms\SMSProviders;

use Innoflash\ZaSms\Contracts\SMSProviderContract;
use Innoflash\ZaSms\Utils\Config;

class ZoomConnectProvider extends SMSProviderContract
{
    function getSMSUrl(): string
    {
        return '';
    }

    function validateConfig()
    {
        Config::findConfig('zoomconnect.email', 'services');
    }
}
