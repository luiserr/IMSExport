<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSQTIFormat;

class QTI extends IMSQTIFormat
{
    protected Exam $exam;

    public function __construct(protected Group $group, protected array $data)
    {
//        find exam
        $this->exam = new Exam($this->data['id']);
        $this->exam->find();
        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createQuestestinterop(function () use ($self) {
                $self
                    ->createAssessment($this->data['identifier'], $this->data['title'], function () use ($self){
                        $self->qtimetadata('5');
                    });
            })
            ->finish();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    protected function finish(): BaseFormat
    {
        $this->XMLGenerator->finish();
        return $this;
    }

    public function getName(): string
    {
        return "{$this->data['identifier']}.xml";
    }

    public function getFolderName(): string
    {
        return "{$this->group->groupId}/{$this->data['identifier']}";
    }

    public function getType(): string
    {
        return 'imsqti_xmlv1p2/imscc_xmlv1p1/assessment';
    }
}