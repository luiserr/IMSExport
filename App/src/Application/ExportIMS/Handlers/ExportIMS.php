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
}