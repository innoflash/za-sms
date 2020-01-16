<?php

namespace Innoflash\ZaSms\Utils;

use Carbon\Carbon;
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
        $data['message'] = $zaSMS->getMessage();

        switch (Config::getProvider()) {
            case 'zoomconnect';
                $data['recipientNumber'] = $to;
                if ($zaSMS->getCampaign())
                    $data['campaign'] = $zaSMS->getCampaign();
                break;
            case 'winsms':
                $data['recipients'] = [
                    [
                        'mobileNumber' => $to
                    ]
                ];

                if ($zaSMS->getSentAt())
                    $data['scheduledTime'] = $zaSMS->getSentAt()->format('YmdHi');
                if ($zaSMS->getMaxSegments())
                    $data['maxSegments'] = $zaSMS->getMaxSegments();
                break;
            default:
                $data['recipientNumber'] = $to;
                break;

                //add cases here
        }
        return $data;
    }
}
