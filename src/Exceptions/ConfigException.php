<?php

namespace Innoflash\ZaSms\Exceptions;

use Exception;
use Innoflash\ZaSms\Utils\Config;

class ConfigException extends Exception
{
    static function missingConfig(string $missingPart, string $file): self
    {
        return new static("$missingPart is missing in the config/$file.php or .ENV");
    }

    static function optionOutOfBounds(string $key, string $value, array $options): self
    {
        return new static("$value is not a valid input for $key, you should use one of [" . implode(', ', $options) . "]");
    }

    static function serviceConfigError(string $missingPart): self
    {
        return new static(Config::getProvider() . $missingPart . " is not set in the config/services.php");
    }
}
