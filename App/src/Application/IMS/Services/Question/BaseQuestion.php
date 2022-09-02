<?php 

namespace IMSExport\Application\IMS\Services\Question;

use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSexport\Application\XMLGenerator\Generator;

abstract class BaseQuestion extends BaseFormat
{	
	public function __construct($data)
    {
        print_r($data);
    }

    protected abstract function export();
}