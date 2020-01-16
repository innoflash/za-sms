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
        return 'https://www.zoomconnect.com/app/api/rest/v1/sms/send.json';
    }

    function getConfigValidationFields(): array
    {
        return [
            'email', 'api_token', 'base_url'
        ];
    }

    function getMessageData()
    {
        return $this->messageData ?: [
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

    function sendMessage()
    {
        $this->validateConfig();
        $this->validateUrl();
        // dd(json_encode($this->getMessageData()), $this->getSMSUrl());
        return file_get_contents($this->getSMSUrl(), null, stream_context_create(array(
            'http' => array(
                'method'           => 'POST',
                'header'           => "Content-type: application/json\r\n" .
                    "Connection: close\r\n" .
                    "Content-length: " . strlen(json_encode($this->getMessageData())) . "\r\n" .
                    "Authorization: Basic " . $this->getCredentials() . "\r\n",
                'content'          => json_encode($this->getMessageData()),
            ),
        )));
    }
}
