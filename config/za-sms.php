<?php

return [
    /**
     * This selects an SMS API provider for the 
     * 
     * Available options are [zoomconnect, winsms, smsworx]
     */
    'provider' => env('ZA_SMS_PROVIDER', null)
];
