<?php

use Innoflash\ZaSms\SMSProviders\WinSMSProvider;
use Innoflash\ZaSms\SMSProviders\ZoomConnectProvider;

return [
    /**
     * This selects an SMS API provider for the 
     * 
     * Available options are [zoomconnect, winsms, smsworx]
     */
    'provider' => env('ZA_SMS_PROVIDER', null),

    /**
     * This is a list of enabled SMS providers,
     * 
     * Register a new one into this array
     */
    'providers' => [
        'zoomconnect' => ZoomConnectProvider::class,
        'winsms' => WinSMSProvider::class,
    ]
];
