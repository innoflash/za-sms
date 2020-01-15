<?php

namespace Innoflash\ZaSms\Exceptions;

use Exception;

class ServiceConfigException extends Exception
{
    static function missingConfig(string $config): self
    {
        return new static("$config is missing from the config/services.php");
    }
}
