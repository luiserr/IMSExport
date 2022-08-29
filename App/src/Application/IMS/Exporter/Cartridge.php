<?php

namespace IMSExport\Application\IMS\Exporter;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\Cartridge as Format;
use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Collection;

class Cartridge extends Format
{
    protected Collection $resources;
    protected array $queue = [];

    public function __construct(public Group $group)
    {
        $this->resources = Collection::createCollection($this->group->resources);
        parent::__construct();
    }

    public function getName(): string
    {
        return 'imsmanifest.xml';
    }

    public function getFolderName(): string
    {
        return $this->group->groupId;
    }

    protected function createResources(): self
    {
        foreach ($this->queue as $resource) {
            $driver = Factory::getDriver($this->group, $resource['typeActivity'], $resource);
            $driver->export();
            $href = "{$resource['identifier']}/{$driver->getName()}";
            $this->createResourceTag($resource['identifier'], $driver->getType(), $href);
        }
        return $this;
    }

    public function export(): void
    {
        try {
            $self = $this;
            $this->createManifest(function () use ($self) {
                $self
                    ->createMetadata($self->group->title, $self->group->description)
                    ->createOrganizationsStructure()
                    ->createResources();

            })
                ->finish();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    protected function createOrganizationsStructure(): self
    {
        $roots = $this->resources
            ->where('parent_id', 0)
            ->toArray();
        foreach ($roots as $root) {
            $self = $this;
            $this->createOrganizations(function () use ($self, $root) {
                $identifier = $this
                    ->identifierCreator
                    ->getIdentifier('organization');
                $self->createOrganization($identifier, function () use ($self, $root) {
                    $self->createItemResource($root);
                });
            });
        }
        return $this;
    }

    protected function createItemResource($parent): void
    {
        $resources = $this
            ->resources
            ->where('parent_id', $parent['id'])
            ->toArray();
        if ($resources && count($resources)) {
            foreach ($resources as $resource) {
                $identifier = $this
                    ->identifierCreator
                    ->getIdentifier('item');
                $identifierRef = $this
                    ->identifierRefCreator
                    ->getIdentifier($resource['type']);
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

    public function getType(): string
    {
        return 'ims_cartridge';
    }
}