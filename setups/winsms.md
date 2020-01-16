## WinSMS Setup

Provider name is ```winsms```


Setup the ```.env``` file
```.env
ZA_SMS_PROVIDER=winsms
WINSMS_API_KEY=
```

Create ```winsms``` entry in the ```config/services.php```
```php
    'winsms' => [
        'base_url' => 'www.winsms.co.za/api/rest/',
        'api_key' => env('WINSMS_API_KEY', null)
    ]
```

## Happy Coding