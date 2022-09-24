<?php

namespace IMSExport\Application\IMS\Services\Formats;

use IMSexport\Application\XMLGenerator\Generator;

abstract class Cartridge extends BaseFormat
{

    protected function createManifest($children)
    {
        $this->XMLGenerator->createElement('manifest', [
            'identifier' => 'man00001',
            'xmlns' => 'http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1',
            'xmlns:lom' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/resource",
            'xmlns:lomimscc' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/manifest",
            'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance"
        ], null,
            $children
        );
        return $this;
    }

    protected function createMetadata(string $title, string $description)
    {
        $this->XMLGenerator
            ->createElement(
                'metadata',
                null,
                null,
                function (Generator $generator) use ($title, $description) {
                    $generator
                        ->createElement('schema', null, 'IMS Common Cartridge')
                        ->createElement('schemaversion', null, '1.0.0', null)
                        ->createElement('lom', null, null, function (Generator $generator) use ($title, $description) {
                            $generator->createElement('general', null, null, function (Generator $generator) use ($title, $description) {
                                $generator->createElement('title', null, null, function (Generator $generator) use ($title) {
                                    $generator->createElement('string', null, $title, null);
                                })
                                    ->createElement('description', null, null, function (Generator $generator) use ($description) {
                                        $generator->createElement('string', null, $description, null);
                                    });
                            });
                        });
                }
            );
        return $this;
    }

    protected function createOrganization(string $identifier, callable $children)
    {
        $this->XMLGenerator->createElement(
            'organization',
            [
                'identifier' => $identifier,
                'structure' => 'rooted-hierarchy'
            ],
            null,
            function (Generator $generator) use ($children) {
                $generator->createElement(
                    'item',
                    [
                        'identifier' => time()
                    ],
                    null,
                    $children
                );
            }
        );
        return $this;
    }

    protected function createOrganizations(callable $children)
    {
        $this->XMLGenerator->createElement(
            'organizations',
            null,
            null,
            $children
        );
        return $this;
    }

    protected function createResourceTag($identifier, $type, $href)
    {
        $this->XMLGenerator->createElement(
            'resource',
            compact('identifier', $type),
            null,
            function (Generator $generator) use ($href) {
                $generator->createElement(
                    'file',
                    compact('href')
                );
            }
        );
        return $this;
    }
}