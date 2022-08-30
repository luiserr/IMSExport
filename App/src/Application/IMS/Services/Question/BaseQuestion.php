<?php 

namespace IMSExport\Application\IMS\Services\Question;

abstract class BaseQuestion 
{	
	public function __construct($data)
    {
        print_r($data);
    }

    protected abstract function export();
}