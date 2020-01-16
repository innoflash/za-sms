## ZoomConnect Setup

Provider name is ```zoomconnect```


Setup the ```.env``` file
```.env
ZA_SMS_PROVIDER=zoomconnect
ZOOMCONNECT_EMAIL=
ZOOMCONNECT_API_TOKEN=
```

Create ```zoomconnect``` entry in the ```config/services.php```
```php
    'zoomconnect' => [
        'email' => env('ZOOMCONNECT_EMAIL', null),
        'api_token' => env('ZOOMCONNECT_API_TOKEN', null),
        'base_url' => 'https://www.zoomconnect.com/app/'
    ]
```

## Happy Coding