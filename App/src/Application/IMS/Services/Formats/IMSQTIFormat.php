<?php

namespace IMSExport\Application\IMS\Services\Formats;

abstract class IMSQTIFormat extends BaseFormat
{
    public function createDummy()
    {
        $this->XMLGenerator->createElement(
            'Dummy',
            [
                'test' => '0001'
            ],
            'Hello world'
        );
    }
}