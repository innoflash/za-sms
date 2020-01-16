<?php

namespace Innoflash\ZaSms\Contracts;

interface BulkSMSProviderContract
{
    function setRecipients(array $recipients);
    function mapMessage(): array;
}
