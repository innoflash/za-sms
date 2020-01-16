<?php

namespace Innoflash\ZaSms\Exceptions;

use Exception;

class ClassException extends Exception
{
    static function exception($class, string $message): self
    {
        return new static($class . ': ' . $message);
    }

    static function bulkProviderException(string $provider, string $class): self
    {
        return new static("$provider does not support bulk SMS, the class $class is missing");
    }
}
