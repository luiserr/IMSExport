<?php

namespace IMSExport\Application\IMS;

interface IdentifierInterface
{
    public function getIdentifier(string $type): string;

    public function createIdentifier(string $prefix, int &$counter): string;
}