<?php

namespace IMSExport\Application\IMS\Services\Formats;

interface FormatInterface
{
    public function export();

    public function getName();

    public function getFolderName();

    public function getType();
}