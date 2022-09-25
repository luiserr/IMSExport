<?php

namespace IMSExport\Application\ExportIMS\Handlers;

use Exception;
use IMSExport\Application\ExportIMS\Repository\Export as Model;
use IMSExport\Application\ExportIMS\Services\ExportExecutor;
use IMSExport\Core\BaseHandler;

class ExportIMS extends BaseHandler
{
    protected $model;

    public function __construct($params = [], $body = [])
    {
        parent::__construct($params, $body);
        $this->model = new Model();
    }

    public function create()
    {
        try {
            $this->model->beginTransaction();
            if ($this->body['sourceType'] === 'simple') {
                $this->simple();
            } else {
                $this->csv();
            }
            $this->model->commit();
            return self::response(
                true,
                $this->body,
                self::SUCCESS
            );
        } catch (Exception $exception) {
            $this->model->rollback();
            return self::response(
                false,
                null,
                $exception->getMessage()
            );
        }
    }

    public function simple()
    {
        $this->model->create($this->body['payload'], $this->body['typeId'], ExportExecutor::ready);
    }

    public function csv()
    {
        foreach ($this->body['payload'] as $item) {
            $this->model->create($item, $this->body['typeId'], ExportExecutor::ready);
        }
    }

    public function getReady()
    {
        $exports = $this->model->getData(
            $this->model->getInProgress()
        );
        return self::response(
            true,
            $exports
        );
    }

    public function getInProgress()
    {
        $exports = $this->model->getData(
            $this->model->getInProgress(ExportExecutor::inProgress)
        );
        return self::response(
            true,
            $exports
        );
    }

    public function getFinished()
    {
        $exports = $this->model->getData(
            $this->model->getInProgress(ExportExecutor::finished)
        );
        return self::response(
            true,
            $exports
        );
    }

    public function delete()
    {
        $this->model->delete($this->body['id']);
        return self::response(
            true,
            $this->body,
            self::SUCCESS
        );
    }

    public function download()
    {
        $export = $this->model->firstElement(
            $this->model->find($this->params['exportId'])
        );
        if ($export) {
            $attachment_location = $export['exportPath'];
            if (file_exists($attachment_location)) {
                header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
                header("Cache-Control: public"); // needed for internet explorer
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: Binary");
                header("Content-Length:" . filesize($attachment_location));
                header("Content-Disposition: attachment; filename={$export['groupId']}.zip");
                readfile($attachment_location);
                die();
            } else {
                die("Error: File not found.");
            }
        }
        return self::response(
            false,
            null,
            'No hay datos para descargar'
        );
    }
}