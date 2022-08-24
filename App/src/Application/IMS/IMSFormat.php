<?php

namespace IMSExport\Application\IMS;

use IMSexport\Application\XMLGenerator\Generator;

class IMSFormat
{
    public Generator $XMLGenerator;

    public function __construct()
    {
        $this->XMLGenerator = new Generator();
    }

    public function createMetadata(string $title, string $description): self
    {
        $this->XMLGenerator->createElement(
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

    public function createOrganization()
    {

    }

    public function createOrganizations()
    {

    }

    public function createItem(string $title, string $identifier, string $identifierRef)
    {

    }

    public function createResource()
    {

    }

    public function export()
    {

    }
}