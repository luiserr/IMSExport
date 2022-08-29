<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Exporter\QTI;
use IMSExport\Application\IMS\Services\Formats\Format;

class Factory
{
    public static function getDriver(string $type, $data): Format
    {
        switch ($type) {
            case 'exam':
                return new QTI();
        }
    }
}