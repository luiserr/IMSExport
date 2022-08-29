<?php

namespace IMSExport\Application\Exporter;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSQTIFormat;

class QTI extends IMSQTIFormat
{
    protected Exam $exam;

    public function __construct(public array $data)
    {
//        find exam
        $this->exam = new Exam();
        $this->exam->find($data['id']);
    }

    public function export()
    {
        // TODO: Implement export() method.
    }

    public function getName(): string
    {
        return "{$this->data['identifier']}.xml";
    }

    public function getFolderName(): string
    {
        return $this->data['identifier'];
    }

    public function getType(): string
    {
        // TODO: Implement getType() method.
    }

    protected function finish(): \IMSExport\Application\IMS\Services\Formats\BaseFormat
    {
        $this->XMLGenerator->finish();
    }
}