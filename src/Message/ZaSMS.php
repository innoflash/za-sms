<?php

namespace Innoflash\ZaSms\Message;

use Carbon\Carbon;

class ZaSMS
{
    /**
     * The message to send
     */
    protected $message;


    /**
     * The number to receive the message
     */
    protected $recipient;


    /**
     * The campaign you are SMSing for
     */
    protected $campaign;

    /**
     * Schedules a time when the message should be send
     */
    protected $sendAt;

    function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    function recipient(string $recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    function campaign(string $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    function sendAt(Carbon $sendAt)
    {
        $this->sendAt = $sendAt;
        return $this;
    }

    function getMessage(): string
    {
        return $this->message;
    }

    function getRecipient()
    {
        return $this->recipient;
    }

    function getCampaign()
    {
        return $this->campaign;
    }

    function getSentAt()
    {
        return $this->sendAt;
    }
}
