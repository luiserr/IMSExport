<?php

namespace IMSExport\Application\Exporter;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\IMS\Services\Formats\IMSQTIFormat;

class QTI extends IMSQTIFormat
{
    protected Exam $exam;

    public function __construct()
    {
//        find exam
        $this->exam->find();
    }

    public function export()
    {
        // TODO: Implement export() method.
    }

    public function getName(): string
    {

    }

    public function getFolderName(): string
    {
        // TODO: Implement getFolderName() method.
    }

    public function getType(): string
    {
        // TODO: Implement getType() method.
    }
}