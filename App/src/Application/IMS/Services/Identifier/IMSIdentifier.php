<?php

namespace IMSExport\Application\IMS\Services\Identifier;

class IMSIdentifier extends IMSIdentifierBase
{
    protected int $organizationId = 0;
    protected int $itemId = 0;

    public function getIdentifier(string $type): string
    {
        switch ($type) {
            case 'organization':
                return $this->createIdentifier('toc', $this->organizationId);
            case 'item':
                return $this->createIdentifier('item', $this->itemId);
            default:
                return '';
        }
    }
}