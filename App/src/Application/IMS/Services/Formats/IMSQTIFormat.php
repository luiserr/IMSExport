<?php

namespace IMSExport\Application\IMS\Services\Formats;
use IMSexport\Application\XMLGenerator\Generator;

abstract class IMSQTIFormat extends BaseFormat
{

    protected function createQuestestinterop($children): self
    {
        $this->XMLGenerator->createElement('questestinterop', [
            'xmlns' => 'http://www.imsglobal.org/xsd/ims_qtiasiv1p2',
        ], null,
            $children
        );
        return $this;
    }

    protected function createAssessment(string $identifier, string $title, callable $children): self
    {
        $this->XMLGenerator->createElement(
            'assessment',
            [
                'ident' => $identifier,
                'title' => $title
            ],
            null,
            $children
        );
        return $this;
    }

    protected function qtimetadata(string $attempt): self
    {
        $this->XMLGenerator
            ->createElement(
            'qtimetadata',
            null,
            null,
            function (Generator $generator) use ($attempt) {
                $generator
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'cc_profile', null);
                            $generator->createElement('fieldentry', null, 'cc.exam.v0p1', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'qmd_scoretype', null);
                            $generator->createElement('fieldentry', null, 'Percentage', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'cc_maxattempts', null);
                            $generator->createElement('fieldentry', null, '5', null);                
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'qmd_assessmenttype', null);
                            $generator->createElement('fieldentry', null, 'Examination', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'qmd_feedbackpermitted', null);
                            $generator->createElement('fieldentry', null, 'No', null);
                        }
                    );
            }
        );
        return $this;
    }

    public function createDummy(): self
    {
        $this->XMLGenerator->createElement(
            'Dummy',
            [
                'test' => '0001'
            ],
            'Hello world'
        );
        return $this;
    }
}