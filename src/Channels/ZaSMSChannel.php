<?php

namespace Innoflash\ZaSms\Channels;

use Innoflash\ZaSms\Utils\Helper;
use Innoflash\ZaSms\Message\ZaSMS;
use Illuminate\Notifications\Notification;
use Innoflash\ZaSms\Exceptions\ConfigException;
use Innoflash\ZaSms\Contracts\SMSProviderContract;

class ZaSMSChannel
{
    protected $zaSMS;
    private $smsProvider;

    public function __construct()
    {
        $this->smsProvider = resolve(SMSProviderContract::class);
    }


    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('zasms', $notification))
            throw ConfigException::missingNumber();

        $message = $notification->toZaSMS($notifiable);

        if (is_string($message))
            $message = new ZaSMS($message);

        $this->smsProvider->setMessageData(Helper::makeSMSData($to, $message));

        return $this->smsProvider->sendMessage();
    }
}
