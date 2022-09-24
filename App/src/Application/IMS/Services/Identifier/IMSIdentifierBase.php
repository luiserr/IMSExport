<?php

namespace IMSExport\Application\IMS\Services\Identifier;

abstract class IMSIdentifierBase implements IdentifierInterface
{
    public function createIdentifier($prefix, &$counter)
    {
        ++$counter;
        return "{$prefix}_{$counter}";
    }
}