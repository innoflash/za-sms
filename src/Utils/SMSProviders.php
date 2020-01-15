<?php

namespace Innoflash\ZaSms\Utils;

use Innoflash\ZaSms\SMSProviders\WinSMSProvider;
use Innoflash\ZaSms\SMSProviders\ZoomConnectProvider;

class SMSProviders
{
    public static $smsProviders = [
        'zoomconnect' => ZoomConnectProvider::class,
        'winsms' => WinSMSProvider::class,
    ];
}
