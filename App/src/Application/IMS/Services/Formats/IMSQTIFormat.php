<?php

namespace IMSExport\Application\IMS\Services\Formats;
use IMSexport\Application\XMLGenerator\Generator;

abstract class IMSQTIFormat extends BaseFormat
{

    protected function createQuestestinterop($children)
    {
        $this->XMLGenerator->createElement('questestinterop', [
            'xmlns' => 'http://www.imsglobal.org/xsd/ims_qtiasiv1p2',
        ], null,
            $children
        );
        return $this;
    }

    protected function createAssessment(string $identifier, string $title, callable $children)
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

    protected function qtimetadata($attempt)
    {
        $this->XMLGenerator
            ->createElement(
            'qtimetadata',
            null,
            null,
            function (Generator $generator) use ($attempt) {
                $generator
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) {
                            $generator->createElement('fieldlabel', null, 'cc_profile', null);
                            $generator->createElement('fieldentry', null, 'cc.exam.v0p1', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) {
                            $generator->createElement('fieldlabel', null, 'qmd_scoretype', null);
                            $generator->createElement('fieldentry', null, 'Percentage', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ($attempt) {
                            $generator->createElement('fieldlabel', null, 'cc_maxattempts', null);
                            $generator->createElement('fieldentry', null, $attempt, null);                
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) {
                            $generator->createElement('fieldlabel', null, 'qmd_assessmenttype', null);
                            $generator->createElement('fieldentry', null, 'Examination', null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) {
                            $generator->createElement('fieldlabel', null, 'qmd_feedbackpermitted', null);
                            $generator->createElement('fieldentry', null, 'No', null);
                        }
                    );
            }
        );
        return $this;
    }

    protected function createInitPresentationMaterial($instrucciones)
    {

        $this->XMLGenerator
            ->createElement(
            'presentation_material',
            null,
            null,
            function (Generator $generator) use ( $instrucciones ) {
                $generator
                    ->createElement('flow_mat', null, null, 
                        function (Generator $generator) use ( $instrucciones ) {
                            $generator->createElement('material', null, null, 
                                function (Generator $generator) use ( $instrucciones ) {
                                    $generator->createElement(
                                        "mattext", 
                                        [
                                            "texttype" => "TEXT/HTML",
                                            "xml:space" => "preserve"
                                        ], 
                                        "<![CDATA[{$instrucciones}]]>"
                                    );
                                }
                            );
                        }
                    );  
            }
        );
        return $this;
    }

    protected function qtimetadataSection( $numberofitems, $weighting )
    {

        $this->XMLGenerator
            ->createElement(
            'qtimetadata',
            null,
            null,
            function (Generator $generator) use ( $numberofitems, $weighting ) { 
                $generator
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ( $numberofitems ) {
                            $generator->createElement('fieldlabel', null, 'qmd_numberofitems', null);
                            $generator->createElement('fieldentry', null, $numberofitems, null);
                        }
                    )
                    ->createElement('qtimetadatafield', null, null, 
                        function (Generator $generator) use ( $weighting ) {
                            $generator->createElement('fieldlabel', null, 'cc_weighting', null);
                            $generator->createElement('fieldentry', null, $weighting, null);
                        }
                    );
            }
        );

        return $this;

    }

    public function createDummy()
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