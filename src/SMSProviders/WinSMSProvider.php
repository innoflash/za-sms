<?php

namespace Innoflash\ZaSms\SMSProviders;

use Innoflash\ZaSms\Contracts\SMSProviderContract;
use Innoflash\ZaSms\Utils\Config;

class WinSMSProvider extends SMSProviderContract
{
    protected $provider = 'winsms';

    function getSMSUrl(): string
    {
        return 'sms/outgoing/send';
    }

    function getConfigValidationFields(): array
    {
        return [
            'api_key',
            'base_url'
        ];
    }

    function getGuzzleDefaults(): array
    {
        return [
            'base_uri' => Config::getService($this->provider, 'base_url')
        ];
    }

    function getHeaders()
    {
        return [
            'AUTHORIZATION' => Config::getService($this->provider, 'api_key'),
            'Content-Type' => 'application/json',
        ];
    }

    function getMessageData()
    {
        return $this->messageData ?: [
            'message' => $this->getMessage(),
            'recipients' => [
                $this->getRecipientNumber()
            ]
        ];
    }
}
