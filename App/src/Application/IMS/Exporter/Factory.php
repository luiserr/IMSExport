<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\FormatInterface;

class Factory
{
    public static function getDriver(Group $group, ?string $type, $data): ?FormatInterface
    {
        switch ($type) {
            case '_exam':
                return new QTI($group, $data);
        }
        return null;
    }
}