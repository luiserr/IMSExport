<?php

namespace IMSExport\Application\IMS\Services\Identifier;

interface IdentifierInterface
{
    public function getIdentifier($type);

    public function createIdentifier($prefix, &$counter);
}