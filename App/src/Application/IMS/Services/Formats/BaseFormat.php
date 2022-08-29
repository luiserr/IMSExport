<?php

namespace IMSExport\Application\IMS\Services\Formats;

use IMSExport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Zip;

abstract class BaseFormat implements Format
{
    const PATH = './storage/export/IMS/';

    public Generator $XMLGenerator;

    public function __construct()
    {
        $this->XMLGenerator = new Generator();
        $this->createDirectory()
            ->XMLGenerator
            ->init($this->getFullPath());
    }

    public function createDirectory(): self
    {
        mkdir(
            self::PATH . $this->getFolderName(),
            0777,
            true
        );
        return $this;
    }

    protected function getFullPath(): string
    {
        return self::PATH . "{$this->getFolderName()}/{$this->getName()}";
    }

    protected function finish(): self
    {
        $this->XMLGenerator->finish();
        Zip::zip(self::PATH . $this->getFolderName(), self::PATH . $this->getFolderName() . '.zip');
        return $this;
    }
}