<?php

namespace Innoflash\ZaSms\SMSProviders\Bulk;

use Innoflash\ZaSms\Contracts\BulkSMSProviderContract;
use Innoflash\ZaSms\SMSProviders\ZoomConnectProvider as ParentProvider;
use InvalidArgumentException;

class ZoomConnectProvider extends ParentProvider implements BulkSMSProviderContract
{
    private $recipients;
    function getSMSUrl(): string
    {
        return 'https://www.zoomconnect.com/app/api/rest/v1/sms/send-bulk';
    }

    function getMessageData()
    {
        return [
            'sendSmsRequests' => $this->mapMessage()
        ];
    }

    function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;
    }

    function mapMessage(): array
    {
        if (!$this->recipients || !is_array($this->recipients))
            throw new InvalidArgumentException('You need to set correct recipients');

        return array_map(function ($recipient) {
            return [
                'recipientNumber' => $recipient,
                'message' => $this->getMessage(),
            ];
        }, array_unique($this->recipients));
    }
}
