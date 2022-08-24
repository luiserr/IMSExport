<?php

namespace IMSExport\Application\Exporter;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\IdentifierInterface;
use IMSExport\Application\IMS\IMSFormat;
use IMSExport\Application\IMS\IMSIdentifier;
use Imsexport\Application\IMS\IMSIdentifierRef;
use IMSexport\Application\XMLGenerator\Generator;

class Cartridge extends IMSFormat
{
    protected IdentifierInterface $identifierCreator;
    protected IdentifierInterface $identifierRefCreator;

    public function __construct(public Group $group)
    {
        $this->identifierCreator = new IMSIdentifier();
        $this->identifierRefCreator = new IMSIdentifierRef();
        parent::__construct();
    }

    public function export(): void
    {
        $folders = $this->group->getFolders();
        try {
            $self = $this;
            $this->XMLGenerator->createElement('manifest', [
                'identifier' => 'man00001',
                'xmlns' => 'http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1',
                'xmlns:lom' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/resource",
                'xmlns:lomimscc' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/manifest",
                'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance"
            ], null, function (Generator $generator) use ($self) {
                $self->createMetadata($self->group->title, $self->group->description);
            });

        } catch (Exception $exception) {

        }
    }
}