<?php

namespace IMSExport\Application\XMLGenerator;

use XMLWriter;

class Generator
{
    protected $xml;

    public function __construct($memory = false)
    {
        $this->xml = new XMLWriter();
    }

    public function createElement(
        string   $key,
        array    $attributes = null,
        string   $text = null,
        callable $children = null
    )
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

    public function addText(string $text = null)
    {
        if ($text) {
            $this->xml->text($text);
        }
        return $this;
    }

    protected function createAttributes(array $attributes = null)
    {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                if($value) {
                    $this->xml->writeAttribute($key, $value);
                }
            }
        }
        return $this;
    }

    public function finish()
    {
        $this->xml->endDocument();
        $content = $this->xml->flush();
    }

    public function init(string $path = null)
    {
        print_r($path);
        if ($this->memory) {
            $this->xml->openMemory();
        } else {
            $this->xml->openUri($path);
        }
        echo $path;
        $this->xml->setIndent(true);
        $this->xml->setIndentString(' ');
        $this->xml->startDocument('1.0', 'UTF-8');
        return $this;
    }
}