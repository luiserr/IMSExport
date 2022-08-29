<?php

namespace IMSExport\Application\IMS\Services\Formats;

interface Format
{
    public function export();

    public function getName(): string;

    public function getFolderName(): string;

    public function getType(): string;
}