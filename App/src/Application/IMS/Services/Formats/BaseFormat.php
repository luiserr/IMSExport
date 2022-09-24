<?php

namespace IMSExport\Application\IMS\Services\Formats;

use IMSExport\Application\IMS\Services\Identifier\IMSIdentifier;
use IMSExport\Application\IMS\Services\Identifier\IMSIdentifierRef;
use IMSExport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\File;
use IMSExport\Helpers\Zip;

abstract class BaseFormat implements FormatInterface
{
    const PATH = STORAGE . 'export/IMS/';

    public Generator $XMLGenerator;

    protected IMSIdentifier $identifierCreator;
    protected IMSIdentifierRef $identifierRefCreator;

    public function __construct()
    {
        $this->identifierCreator = new IMSIdentifier();
        $this->identifierRefCreator = new IMSIdentifierRef();
        File::createDirectory(self::PATH . $this->getFolderName());
        $this->XMLGenerator = new Generator();
        $this
            ->XMLGenerator
            ->init($this->getFullPath());
    }

    protected function getFullPath(): string
    {
        return self::PATH . "{$this->getFolderName()}/{$this->getName()}";
    }

    protected function finish(): self
    {
        $this->XMLGenerator->finish();
        $folderName = self::PATH . $this->getFolderName();
        Zip::zip($folderName, self::PATH . $this->getFolderName() . '.zip');
//        File::rmDir($folderName);
        return $this;
    }
}