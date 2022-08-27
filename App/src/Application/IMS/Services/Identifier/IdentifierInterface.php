<?php

namespace IMSExport\Application\IMS\Services\Identifier;

interface IdentifierInterface
{
    public function getIdentifier(string $type): string;

    public function createIdentifier(string $prefix, int &$counter): string;
}