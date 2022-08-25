<?php

namespace IMSExport\Application\Exporter;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\IdentifierInterface;
use IMSExport\Application\IMS\IMSFormat;
use IMSExport\Application\IMS\IMSIdentifier;
use Imsexport\Application\IMS\IMSIdentifierRef;
use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Collection;
use function IMSExport\Helpers\createCollection;

class Cartridge extends IMSFormat
{
    protected IdentifierInterface $identifierCreator;
    protected IdentifierInterface $identifierRefCreator;
    protected Collection $resources;
    protected array $queue = [];

    public function __construct(public Group $group)
    {
        $this->identifierCreator = new IMSIdentifier();
        $this->identifierRefCreator = new IMSIdentifierRef();
        $this->resources = createCollection($this->group->resources);
        parent::__construct();
    }

    public function export(): void
    {
        try {
            $self = $this;
            $this->createManifest(function () use ($self) {
                $self
                    ->createMetadata($self->group->title, $self->group->description)
                    ->createOrganizationsStructure();

            });
        } catch (Exception $exception) {

        }
    }

    protected function createOrganizationsStructure(): void
    {
        $roots = $this->resources
            ->where('parent_id', 0)
            ->toArray();
        foreach ($roots as $root) {
            $self = $this;
            $this->createOrganizations(function () use ($self, $root) {
                $identifier = $this->identifierCreator->getIdentifier('organization');
                $self->createOrganization($identifier, function () use ($self, $root) {
                    $self->createItemResource($root);
                });
            });
        }
    }

    protected function createItemResource($parent): void
    {
        $resources = $this
            ->resources
            ->where('parent_id', $parent['id'])
            ->toArray();
        if (count($resources)) {
            foreach ($resources as $resource) {
                $identifier = $this->identifierCreator->getIdentifier('item');
                $identifierRef = $this->identifierRefCreator->getIdentifier('item');
                $resource = array_merge($resource, compact('identifier', 'identifierRef'));
                $self = $this;
                $this->XMLGenerator->createElement(
                    'item',
                    [
                        'identifier' => $identifier,
                        'identifierref' => $identifierRef
                    ],
                    null,
                    static function (Generator $generator) use ($resource, $self) {
                        $generator->createElement(
                            'title',
                            null,
                            $resource['title']
                        );
                        $self->createItemResource($resource);
                    }
                );
            }
        } else {
            $this->queue[] = $parent;
        }
    }


}