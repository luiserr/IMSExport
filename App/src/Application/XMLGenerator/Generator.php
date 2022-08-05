<?php

namespace IMSexport\Application\XMLGenerator;

use XMLWriter;

class Generator
{
    protected XMLWriter $xml;

    public function __construct()
    {
        $this->xml = new XMLWriter();
        $this->init();
    }

    protected function init()
    {
        $this->xml->openMemory();
        $this->xml->setIndent(true);
        $this->xml->setIndentString(' ');
        $this->xml->startDocument('1.0', 'UTF-8');
    }

    public function createElement(
        string   $key,
        array    $attributes = null,
        string   $text = null,
        callable $children = null
    ): Generator
    {
        $this->xml->startElement($key);
        $this
            ->createAttributes($attributes)
            ->addText($text);
        if ($children) {
            $children($this);
        }
        $this->xml->endElement();
        return $this;
    }

    public function addText(string $text = null): static
    {
        if ($text) {
            $this->xml->text($text);
        }
        return $this;
    }

    protected function createAttributes(array $attributes = null): static
    {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->xml->writeAttribute($key, $value);
            }
        }
        return $this;
    }

    public function finish()
    {
        $this->xml->endDocument();
        $content = $this->xml->outputMemory();
//        ob_end_clean();
//        ob_start();
        header('Content-Type: application/xml; charset=UTF-8');
        header('Content-Encoding: UTF-8');
        header("Content-Disposition: attachment;filename=ejemplo.xml");
        header('Expires: 0');
        header('Pragma: cache');
        header('Cache-Control: private');
        echo $content;
    }
}