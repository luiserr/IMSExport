<?php

namespace IMSExport\Application\ExportIMS\Scripts;

use Carbon\Carbon;
use Exception;
use IMSExport\Application\ExportIMS\Repository\Export as Model;
use IMSExport\Application\ExportIMS\Services\ExportExecutor;
use IMSExport\Core\Script;

class ExecuteExport extends Script
{
    protected Model $model;

    public function __construct(Carbon $now)
    {
        parent::__construct($now);
        $this->model = new Model();
    }

    public function run()
    {

        self::log('*************************');
        self::log('*** Inicio el proceso ***');
        self::log('*************************');
        $this->model->init();
        $inProgress = $this->model->getInProgress();
        if ($inProgress) {
            foreach ($inProgress as $item) {
                try {
                    self::log("Ejecutando {$item['id']}");
                    (new ExportExecutor($item))
                        ->export();
                } catch (Exception $exception) {
                    self::log($exception->getMessage());
                }
            }
        }
    }

}