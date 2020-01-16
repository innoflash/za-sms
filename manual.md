# Adding provider
## Table of contents
* [Introduction](#introduction)
* [Set up](#set-up)
    * [Create provider](#create-provider)
    * [Register provider](#register-provider)
    * [Override Contract](#override-contract)
        * [Mandatory overrides](#mandatory-overrides)
        * [Optional overrides](#optional-overrides)

## Introduction
Per adventure you are missing your provider from the list of ```providers```, feel free to fork and add yours or better, you can add the provider on this repository

## Set up
### Create provider
* You will need to create a provider class that extends ```SMSProviderContract```
* Its highly advisable to create the class in the ```src/SMSProviders/``` directory

```php
use Innoflash\ZaSms\Contracts\SMSProviderContract;

class ZoomConnectProvider extends SMSProviderContract
{
    #code
}
```

### Register provider
* You will need to register the provider the ```za-sms.php``` config file
* ```keynames``` are supposed to be lowercase and one word

```php
    //za-sms.php

    'providers' => [
        'zoomconnect' => ZoomConnectProvider::class,
        'winsms' => WinSMSProvider::class,
    ]
```
* When you register the ```provider``` you will then have to add its ```service```
* In the ```config/services.php``` register the provider and its credentials you will need for sending the SMS

```php
    // config/services.php

    'zoomconnect' => [
        'email' => env('ZOOMCONNECT_EMAIL', null),
        'api_token' => env('ZOOMCONNECT_API_TOKEN', null),
        'base_url' => 'https://www.zoomconnect.com/app/'
    ]
```

### Override Contract
The ```SMSProviderContract``` is an abstract class with a bunch of mandatory methods an fields. Lets list them and see how we sould override them

#### Mandatory overrides
```php
    /**
     * The name of the provider of SMS same as in the Providers
     * 
     * It should match with the name you used to register the provider
     */
    protected $provider;
```
```php
    /**
     * The link you use to send a single SMS
     */
    abstract function getSMSUrl(): string;
```
```php
    /**
     * This returns the fields you have to validate for this provider`s
     * config
     * 
     * @return array an array of fields to validate
     */
    abstract function getConfigValidationFields(): array;
```
```php
    /**
     * Gets the headers to use when making the SMS call
     * 
     * An empty array can be used used if no headers are to be set
     */
    abstract function getHeaders();
```
```php
    /**
     * Gets the data you wanna send to the HTTP endpoint 
     * of the SMS Provider
     * 
     * Can be an array or string
     */
    abstract function getMessageData();
```
#### Optional Overrides
* The rest of the functions can be overriden but the one we can talk about is the ```sendMessage```
* This package uses GuzzleHttp to make the requests so for some reason you do not want to use that one or you have some specific logic to do before sending the SMS you should override it
```php
function sendMessage(){
    #code
}
```
# Happy coding