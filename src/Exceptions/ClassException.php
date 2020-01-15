<?php

namespace Innoflash\ZaSms\Exceptions;

use Exception;

class ClassException extends Exception
{
    static function exception($class, string $message): self
    {
        return new static($class . ': ' . $message);
    }
}
