<?php

namespace IMSExport\Application\IMS;

class IMSIdentifier extends IMSIdentifierBase
{
    protected int $organizationId = 0;
    protected int $itemId = 0;

    public function getIdentifier(string $type): string
    {
        return match ($type) {
            'organization' => $this->createIdentifier('toc', $this->organizationId),
            'item' => $this->createIdentifier('itm', $this->itemId),
            default => '',
        };
    }
}