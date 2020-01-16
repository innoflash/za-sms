# za-sms

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/innoflash/za-sms.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/innoflash/za-sms.svg?style=flat-square)](https://packagist.org/packages/innoflash/za-sms)
## Table of contents
* [Introduction](#introduction)
* [Installation](#install)

## Introduction
This package is aimed at creating a South African SMS package for for local SMS providers using their REST APIs.
Below is a list of providers we currently integrated: 
* [ZoomConnect](https://www.zoomconnect.com/)

## Install
`composer require innoflash/za-sms`

## Usage
Once the package is installed you will need to set the provider in the ```.ENV``` file as follows:
```env
ZA_SMS_PROVIDER={provider}
```

Available providers:

* [zoomconnect](./setups/zoomconnect.md)

### Use as a notification
za-sms supports being a driver for [Laravel Notification](https://laravel.com/docs/6.x/notifications)

* In the ```Notifiable``` class set your model phone number field by overriding this
```php
    function routeNotificationForZasms($notification)
    {
        return $this->phone_number;
    }
```

* In the ```Notification``` class use the za-sms as follows
```php
    public function via($notifiable)
    {
        return [ZaSMSChannel::class];
    }
```

* Then create the notification body as follows
```php
    function toZaSMS($notifiable)
    {
        return (new ZaSMS)
            ->message('This is my message')  
            ->sendAt(now()->addDays(2)) // for scheduling messegaes 
            ->campaign('my campain'); //for message campaining
    }
```

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security-related issues, please email innocentmazando@gmail.com instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.