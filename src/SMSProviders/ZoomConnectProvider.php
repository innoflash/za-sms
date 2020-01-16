<?php

namespace Innoflash\ZaSms\SMSProviders;

use stdClass;
use Innoflash\ZaSms\Utils\Config;
use Innoflash\ZaSms\Contracts\SMSProviderContract;

class ZoomConnectProvider extends SMSProviderContract
{
    protected $provider = 'zoomconnect';

    function getSMSUrl(): string
    {
        return 'https://www.zoomconnect.com/app/api/rest/v1/sms/send';
    }

    function getConfigValidationFields(): array
    {
        return [
            'email', 'api_token', 'base_url'
        ];
    }

    function getMessageData()
    {
        return [
            'recipientNumber' => $this->getRecipientNumber(),
            'message' => $this->getMessage(),
        ];
    }

    function getHeaders()
    {
        return [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . $this->getCredentials(),
            'Content-Length: ' . strlen(json_encode($this->getMessageData())),
            'Access-Control-Allow-Origin: *'
        ];
    }

    private function getCredentials(): string
    {
        $email = Config::getService($this->provider, 'email');
        $token = Config::getService($this->provider, 'api_token');
        // dd(base64_encode($email . ':' . $token));
        return base64_encode($email . ':' . $token);
    }

    function getGuzzleDefaults(): array
    {
        return [
            'timeout' => 5.0,
            'base_url' => Config::getService($this->provider, 'base_url'),
            // 'auth' => [
            //     Config::findConfig($this->provider . '.email', 'services'),
            //     Config::findConfig($this->provider . '.api_token', 'services')
            // ]
        ];
    }
}
