<?php

namespace Innoflash\ZaSms\Contracts;

abstract class SMSProviderContract
{
    abstract function getSMSUrl(): string;
    abstract function validateConfig();
}
