<?php

namespace Innoflash\ZaSms\Utils;

use Innoflash\ZaSms\Message\ZaSMS;

class Helper
{
    /**
     * Makes the data you wanna sent via your selected provider
     *
     * @param string $to The number you are senting to
     * @param ZaSMS $zaSMS The message body from the notification
     * @return array The data you are senting to via the provider
     */
    static function makeSMSData(string $to, ZaSMS $zaSMS): array
    {
        $data = [];
        switch (Config::getProvider()) {
            case 'zoomconnect';
                $data['recipientNumber'] = $to;
                $data['message'] = $zaSMS->getMessage();
                if ($zaSMS->getCampaign())
                    $data['campaign'] = $zaSMS->getCampaign();
                break;
        }
        return $data;
    }
}
