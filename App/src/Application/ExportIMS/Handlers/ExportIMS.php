<?php

namespace IMSExport\Application\ExportIMS\Handlers;

use IMSExport\Application\ExportIMS\Services\ExportById;

class ExportIMS
{
    public function __construct(protected string $method, protected array $data)
    {
    }


    public function run()
    {
        print_r("1 Handlers/ExportIMS run <br />->method: "); var_dump($this->method) . print_r("<br />->data: ")  . var_dump($this->data) . "<br />";
        if($this->method == 'id') {
            (new ExportById($this->data))->export();
        }
    }


}