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

    /**
     * Validates your provider configuration
     *
     * @return void
     */
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

    /**
     * Checks whether or not a URL is set for sending the message
     *
     * @return void
     */
    function validateUrl()
    {
        if (!$this->getSMSUrl())
            throw ClassException::exception(get_class($this), 'You need to overide the getSMSUrl method');
    }

    /**
     * Sets the recipient number
     *
     * @param string $recipientNumber The number you are senting an SMS to
     * @return void
     */
    function setRecipientNumber(string $recipientNumber): self
    {
        $this->recipientNumber = $recipientNumber;
        return $this;
    }

    /**
     * Undocumented function
     * The message you wanna sent
     *
     * @param string $message
     * @return self
     */
    function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Gets the number set for this message to be created
     *
     * @return string phone number
     */
    function getRecipientNumber(): string
    {
        if (!$this->recipientNumber)
            throw new InvalidArgumentException('You need to set the recipient number');

        return $this->recipientNumber;
    }

    /**
     * Gets the message you wanna sent
     *
     * @return string message
     */
    function getMessage(): string
    {
        if (!$this->message)
            throw new InvalidArgumentException('You need to set the message for this SMS');

        return $this->message;
    }

    /**
     * Default config for GuzzleHttp/Client
     *
     * @return array
     */
    function getGuzzleDefaults(): array
    {
        return $this->guzzleDefaults;
    }


    /**
     * This sets the data you wanna send over the URL
     *
     * @param array $messageData message and the recipient and your extra data
     * @return void
     */
    function setMessageData(array $messageData): self
    {
        $this->messageData = $messageData;
        return $this;
    }

    /**
     * This sends your message via the selected provider
     *
     * @return void
     */
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
