<?php

namespace IMSExport\Application\ExportIMS\Scripts;

use Carbon\Carbon;
use Exception;
use IMSExport\Application\ExportIMS\Repository\Export as Model;
use IMSExport\Application\ExportIMS\Services\ExportExecutor;
use IMSExport\Core\Script;

class ExecuteExport extends Script
{
    protected $model;

    public function __construct($now)
    {
        parent::__construct($now);
        $this->model = new Model();
    }

    public function run()
    {
        self::log('*************************');
        self::log('*** Inicio el proceso ***');
        self::log('*************************');
        $inProgress = $this->model->getData($this->model->getInProgress());
        self::log('Exportaciones por iniciar: ' . count($inProgress));
        if ($inProgress) {
            foreach ($inProgress as $item) {
                try {
                    self::log("Ejecutando {$item['id']}");
                    $this->model->init($item['id'], ExportExecutor::inProgress);
                    (new ExportExecutor($item))
                        ->export();
                } catch (Exception $exception) {
                    self::log($exception->getMessage());
                }
            }
        }
    }

}