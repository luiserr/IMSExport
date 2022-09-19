<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Constants\Activities;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\FormatInterface;

class Factory
{
    public static function getDriver(Group $group, ?string $type, $data): ?FormatInterface
    {
        switch ($type) {
            case Activities::exam:
            case Activities::probe:
                return new QTI($group, $data);
            case Activities::post:
                return new Discussion($group, $data);
            case Activities::task:
            case Activities::resource:
                return new Tasks($group, $data);
            case Activities::blog:
                return new Blogs($group, $data);
            case Activities::wiki:
                return new Wikis($group, $data);
            default:
                return null;
        }
    }
}