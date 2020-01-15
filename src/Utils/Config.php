<?php

namespace Innoflash\ZaSms\Utils;

use Innoflash\ZaSms\Exceptions\ConfigException;

class Config
{
    static function getProvider()
    {
        $provider =  self::findConfig('provider');
        return self::validateOption('provider', $provider, array_keys(SMSProviders::$smsProviders));
    }

    /**
     * Searches the config file for the given key
     */
    static function findConfig(string $configName, string $file = 'za-sms')
    {
        $configName = $file . '.' . $configName;
        //  dd($configName);
        if (!config($configName))
            throw ConfigException::missingConfig($configName, $file);
        return config($configName);
    }

    static function getService(string $provider, $field)
    {
        return self::findConfig($provider . '.' . $field, 'services');
    }

    /**
     * Validates the option for the possible values
     */
    static function validateOption(string $configName, string $value, array $options, string $file = 'za-sms')
    {
        $configName = $file . '.' . $configName;
        if (!in_array($value, $options))
            throw ConfigException::optionOutOfBounds($configName, $value, $options);
        return $value;
    }
}
