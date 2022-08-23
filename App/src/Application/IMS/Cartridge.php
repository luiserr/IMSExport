<?php

namespace IMSExportS\Application\IMS;

use IMSExport\Application\IMS\IdentifierInterface;
use IMSExport\Application\IMS\IMSFormat;
use IMSExport\Application\IMS\IMSIdentifier;
use Imsexport\Application\IMS\IMSIdentifierRef;

class Cartridge extends IMSFormat
{
    protected IdentifierInterface $identifierCreator;
    protected IdentifierInterface $identifierRefCreator;

    public function __construct()
    {
        $this->identifierCreator = new IMSIdentifier();
        $this->identifierRefCreator = new IMSIdentifierRef();
    }


}