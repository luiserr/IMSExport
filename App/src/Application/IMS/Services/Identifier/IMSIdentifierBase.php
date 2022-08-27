<?php

namespace IMSExport\Application\IMS\Services\Identifier;

abstract class IMSIdentifierBase implements IdentifierInterface
{
    public function createIdentifier(string $prefix, int &$counter): string
    {
        ++$counter;
        return "";
    }
}