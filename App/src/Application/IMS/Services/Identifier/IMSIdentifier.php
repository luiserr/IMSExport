<?php

namespace IMSExport\Application\IMS\Services\Identifier;

class IMSIdentifier extends IMSIdentifierBase
{
    protected $organizationId = 0;
    protected $itemId = 0;
    protected $sectionIdQti = 0;
    protected $itemIdQti = 0;

    public function getIdentifier($type)
    {
        switch ($type) {
            case 'organization':
                return $this->createIdentifier('toc', $this->organizationId);
            case 'item':
                return $this->createIdentifier('item', $this->itemId);
            case 'section':
                return $this->createIdentifier('section', $this->sectionIdQti);
            case 'sectionItem':
                return $this->createIdentifier('item', $this->itemIdQti);
            default:
                return null;
        }
    }
}