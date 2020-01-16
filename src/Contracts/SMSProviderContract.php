<?php

namespace Innoflash\ZaSms\Contracts;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Innoflash\ZaSms\Utils\Config;
use Innoflash\ZaSms\Exceptions\ClassException;
use Innoflash\ZaSms\Exceptions\ServiceConfigException;

abstract class SMSProviderContract
{
    /**
     * The name of the provider of SMS same as in the Providers
     */
    protected $provider;

    /**
     * This sets defaults for guzzlehttp client 
     */
    private $guzzleDefaults = [
        'timeout' => 5.0
    ];

    private $recipientNumber;
    private $message;
    protected $messageData;

    /**
     * The link ypu use to send a single SMS
     */
    abstract function getSMSUrl(): string;

    /**
     * This returns the fields you have to validate for this providers
     * config
     * 
     * @return array an array of fields to validate
     */
    abstract function getConfigValidationFields(): array;

    /**
     * Gets the headers to use when making the SMS call
     */
    abstract function getHeaders();

    /**
     * Gets the data you wanna send to the HTTP endpoint of the SMS Provider
     */
    abstract function getMessageData();

    function validateConfig()
    {
        if (!$this->provider)
            throw ClassException::exception(get_class($this), 'You need to set the $provider for this class');

        if (!config('services.' . $this->provider))
            throw ServiceConfigException::missingConfig($this->provider);

        if (!is_array($this->getConfigValidationFields()))
            throw new InvalidArgumentException('Validation fields must be an array');

        foreach ($this->getConfigValidationFields() as $field) {
            $field = $this->provider . '.' . $field;
            Config::findConfig($field, 'services');
        }
    }

    function validateUrl()
    {
        if (!$this->getSMSUrl())
            throw ClassException::exception(get_class($this), 'You need to overide the getSMSUrl method');
    }

    /**
     * Sets the recipient number
     */
    function setRecipientNumber(string $recipientNumber)
    {
        $this->recipientNumber = $recipientNumber;
    }

    function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Gets the number set for this message to be created
     */
    function getRecipientNumber(): string
    {
        if (!$this->recipientNumber)
            throw new InvalidArgumentException('You need to set the recipient number');

        return $this->recipientNumber;
    }

    function getMessage(): string
    {
        if (!$this->message)
            throw new InvalidArgumentException('You need to set the message for this SMS');

        return $this->message;
    }

    function getGuzzleDefaults(): array
    {
        return $this->guzzleDefaults;
    }


    function setMessageData(array $messageData)
    {
        $this->messageData = $messageData;
    }

    function sendMessage()
    {
        $this->validateConfig();
        $this->validateUrl();

        $clientConfig = array_merge($this->getGuzzleDefaults(), [
            'headers' => $this->getHeaders()
        ]);

        $client = new Client($clientConfig);
        if (is_string($this->messageData ?: $this->getMessageData()))
            $format = 'body';
        else $format = 'json';

        return $client->post($this->getSMSUrl(), [
            $format => $this->messageData ?: $this->getMessageData()
        ]);
    }
}
