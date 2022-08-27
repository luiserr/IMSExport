<?php

namespace IMSExport\Application\IMS\Services\Formats;

use IMSexport\Application\XMLGenerator\Generator;

abstract class BaseFormat implements Format
{
    const PATH = './storage/export/IMS/';

    public Generator $XMLGenerator;

    public function __construct()
    {
        $this->XMLGenerator = new Generator();
        $this->XMLGenerator->init($this->getFullPath());
    }

    protected function createDirectory(): void
    {
        mkdir(
            self::PATH . $this->getFolderName(),
            0777,
            true
        );
    }

    protected function getFullPath(): string
    {
        return self::PATH . "{$this->getFolderName()}/{$this->getName()}";
    }

    protected function finish(): self
    {
        $this->XMLGenerator->finish();
        return $this;
    }
}