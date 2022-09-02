<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\FormatInterface;

class Factory
{
    public static function getDriver(Group $group, string $type, $data): ?FormatInterface
    {
        switch ($type) {
          /*case 'exam':
                return new QTI($group, $data);*/
            case 'forum':
                return new Discussion($group, $data); //RACH: Factory.php discussion->forum y generar o crear recurso
        }
        return null;
    }
}