<?php

namespace IMSExport\Application\ExportIMS\Scripts;

use Exception;
use IMSExport\Application\ExportIMS\Repository\Export as Model;
use IMSExport\Application\ExportIMS\Services\ExportExecutor;
use IMSExport\Core\Script;

class ExecuteExport extends Script
{
    protected Model $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function run()
    {
        $inProgress = $this->model->getInProgress();
        self::log('*************************');
        self::log('*** Inicio el proceso ***');
        self::log('*************************');
        if ($inProgress) {
            foreach ($inProgress as $item) {
                try {
                    self::log("Ejecutendo {$item['id']}");
                    (new ExportExecutor($item))
                        ->export();
                } catch (Exception $exception) {
                    self::log($exception->getMessage());
                }
            }
        }
    }

}