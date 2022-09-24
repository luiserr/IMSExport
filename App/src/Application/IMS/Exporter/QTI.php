<?php

namespace IMSExport\Application\IMS\Exporter;

use Exception;
use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSQTIFormat;
use IMSExport\Application\IMS\Services\Question\Factory;
use IMSExport\Helpers\Collection;

class QTI extends IMSQTIFormat
{
    protected $exam;
    protected $configurate;
    protected $section;
    protected $question;
    protected $group;
    protected $data;

    public function __construct($group, $data)
    {
        $this->group = $group;
        $this->data = $data;
        $this->exam = new Exam($this->data['id']);
        $this->section = Collection::create($this->exam->getSection);
        $this->question = Collection::create($this->exam->getQuestion);
        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createQuestestinterop(function () use ($self) {
                $self
                    ->createAssessment($this->data['identifierRef'], $this->data['title'], function () use ($self) {
                        $self
                            ->qtimetadata($this->exam->intentos)
                            ->createInitPresentationMaterial($this->exam->instrucciones)
                            ->createAllSection();
                    });
            })
                ->finish();
            return true;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public function finish()
    {
        $this->XMLGenerator->finish();
        return $this;
    }

    protected function createAllSection()
    {
        $sections = $this
            ->section
            ->toArray();
        if ($sections && count($sections)) {
            foreach ($sections as $section) {
                $identifier = $this
                    ->identifierCreator
                    ->getIdentifier('section');
                $self = $this;

                $identifierall = "{$this->data['identifierRef']}_{$identifier}";

                $this->XMLGenerator->createElement(
                    'section',
                    [
                        'ident' => $identifierall
                    ],
                    null,
                    function () use ($section, $self, $identifierall) {
                        $self
                            ->qtimetadataSection($section['numero_preguntas'], $section['ponderacion'])
                            ->createItemSection($section['idExamenSeccion'], $identifierall);
                    }
                );
            }
        }
    }

    protected function createItemSection($id, $identifierall)
    {
        $questions = $this
            ->question
            ->where('fk_idExamenSeccion', $id)
            ->toArray();

        $identifier = $identifierall;

        if ($questions && count($questions)) {
            $root = $this;
            foreach ($questions as $question) {
                $question = array_merge($question, compact('identifier'));

                $driver = Factory::getDriver(
                    $question['tipo'],
                    $question,
                    $root
                );
                $driver->export();
            }
        }
    }

    public function getName()
    {
        return "{$this->data['identifierRef']}.xml";
    }

    public function getFolderName()
    {
        return "{$this->group->seedId}/{$this->data['identifierRef']}";
    }

    public function getType()
    {
        return 'imsqti_xmlv1p2/imscc_xmlv1p1/assessment';
    }
}