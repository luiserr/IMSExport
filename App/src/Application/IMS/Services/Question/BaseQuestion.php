<?php

namespace IMSExport\Application\IMS\Services\Question;

use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Application\Entities\Answer;
use IMSExport\Helpers\Collection;

abstract class BaseQuestion
{
    public $data;
    public $root;
    protected $answer;
    protected $answerCollection;

    public function __construct($data, $root)
    {
        $this->data = $data;
        $this->root = $root;
        $this->answer = new Answer($this->data['idPreguntas']);
        $this->answerCollection = Collection::create($this->answer->find());
    }

    protected function createItem($children)
    {
        $this->root->XMLGenerator->createElement(
            'item',
            [
                'ident' => "{$this->data['identifier']}_{$this->data['idPreguntas']}"
            ],
            null,
            $children
        );
        return $this;
    }

    protected function createRenderChoice($rcardinality, $children)
    {
        $this->root->XMLGenerator->createElement(
            'response_lid',
            [
                "ident" => "response_{$this->data['idPreguntas']}",
                "rcardinality" => $rcardinality
            ],
            null,
            function (Generator $generator) use ($children) {

                $generator->createElement(
                    "render_choice",
                    null,
                    null,
                    $children
                );

            }
        );

        return $this;
    }

    protected function createAnswerChoice()
    {
        $answers = $this
            ->answerCollection
            ->toArray();

        $self = $this;
        if ($answers && count($answers)) {
            foreach ($answers as $key => $value) {

                $ident = "response_{$this->data['idPreguntas']}_{$value['idRespuesta']}";

                $response = $value['Respuesta'];
                $textoEnriquecido = $value['textoEnriquecido'];
                $this->root->XMLGenerator->createElement(
                    'response_label',
                    [
                        "ident" => $ident
                    ],
                    null,
                    function (Generator $generator) use ($response, $textoEnriquecido, $self) {

                        $self->createMaterial($response, $textoEnriquecido);

                    }
                );

            }
        }
    }

    protected function createMaterial($text, $textoEnriquecido = 0)
    {

        $this->root->XMLGenerator->createElement(
            'material',
            null,
            null,
            function (Generator $generator) use ($text, $textoEnriquecido) {

                $generator->createElement(
                    "mattext",
                    $textoEnriquecido ? [
                        "texttype" => "TEXT/HTML",
                        "xml:space" => "preserve"
                    ] : null,
                    $textoEnriquecido ? "<![CDATA[{$text}]]>" : "{$text}"
                );

            }
        );

        return $this;
    }

    protected function decvar($varname, $vartype, $defaultval = 0, $maxvalue = 1, $minvalue = 0)
    {
        $this->root->XMLGenerator->createElement(
            'decvar',
            [
                "varname" => $varname,
                "vartype" => $vartype,
                "defaultval" => $defaultval,
                "maxvalue" => $maxvalue,
                "minvalue" => $minvalue
            ],
            null,
            null
        );

        return $this;
    }

    protected function tagParent($tag, $children)
    {
        $this->root->XMLGenerator->createElement(
            $tag,
            null,
            null,
            $children
        );

        return $this;
    }

    protected function varequal($respident, $value)
    {
        $this->root->XMLGenerator->createElement(
            'varequal',
            [
                "respident" => $respident
            ],
            $value,
            null
        );
    }

    protected function setvar($action, $value)
    {
        $this->root->XMLGenerator->createElement(
            'setvar',
            [
                "action" => $action
            ],
            $value,
            null
        );
    }

    protected function displayfeedback($feedbacktype, $linkrefid)
    {
        $this->root->XMLGenerator->createElement(
            'setvar',
            [
                "feedbacktype" => $feedbacktype,
                "linkrefid" => $linkrefid
            ],
            null,
            null
        );
    }

    protected function itemfeedback($ident, $children)
    {
        $this->root->XMLGenerator->createElement(
            'itemfeedback',
            [
                "ident" => $ident
            ],
            null,
            $children
        );

        return $this;
    }

    protected function response_str($ident, $rcardinality, $maxchars)
    {
        $attribute = ["fibtype" => "String", "prompt" => "Dashline"];
        if ($maxchars) {
            $attribute["maxchars"] = $maxchars;
        }

        $this->root->XMLGenerator->createElement(
            'response_str',
            [
                "ident" => $ident,
                "rcardinality" => $rcardinality
            ],
            null,
            function () use ($attribute) {

                $this->root->XMLGenerator->createElement(
                    'render_fib',
                    $attribute,
                    null,
                    function () {
                        $this->root->XMLGenerator->createElement('response_label', [
                            "ident" => "A"], null, null);
                    }
                );

            }
        );
    }

    protected function getText()
    {
        return $this->data['Pregunta'];
    }

    protected function getType()
    {
        return $this->data['tipo'];
    }

    protected abstract function export();

    protected abstract function answersCorrect();
}