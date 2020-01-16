<?php

namespace Innoflash\ZaSms\Utils;

use Innoflash\ZaSms\Message\ZaSMS;

class Helper
{
    static function makeSMSData(string $to, ZaSMS $zaSMS)
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
