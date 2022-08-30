<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSQTIFormat;
use IMSExport\Helpers\Collection;

class QTI extends IMSQTIFormat
{
    protected Exam $exam;
    protected $configurate;
    protected Collection $section;
    protected Collection $question;
    protected Collection $answer;

    public function __construct(protected Group $group, protected array $data)
    {
//        find exam
        $this->exam = new Exam($this->data['id']);
        $this->configurate = $this->exam->find();
        $this->section = Collection::createCollection($this->exam->getSection);
        $this->question = Collection::createCollection($this->exam->getQuestion);
        $this->answer = Collection::createCollection($this->exam->getAnswer);
        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createQuestestinterop(function () use ($self) {
                $self
                    ->createAssessment($this->data['identifier'], $this->data['title'], function () use ($self){
                        $self->qtimetadata($this->configurate['intentos']);
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
        return "{$this->data['identifierRef']}.xml";
    }

    public function getFolderName(): string
    {
        return "{$this->group->groupId}/{$this->data['identifierRef']}";
    }

    public function getType(): string
    {
        return 'imsqti_xmlv1p2/imscc_xmlv1p1/assessment';
    }
}