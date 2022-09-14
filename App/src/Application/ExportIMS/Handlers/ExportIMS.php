<?php

namespace IMSExport\Application\ExportIMS\Handlers;

use Exception;
use IMSExport\Application\ExportIMS\Repository\Export as Model;
use IMSExport\Application\ExportIMS\Services\ExportExecutor;
use IMSExport\Core\BaseHandler;

class ExportIMS extends BaseHandler
{
    protected Model $model;

    public function __construct(?array $params = [], ?array $body = [])
    {
        parent::__construct($params, $body);
        $this->model = new Model();
    }

    public function run(): bool|string
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
        $this->model->init($this->body['payload'], $this->body['typeId'], ExportExecutor::ready);
    }

    public function csv()
    {
        foreach ($this->body['payload'] as $item) {
            $this->model->init($item, $this->body['typeId'], ExportExecutor::ready);
        }
    }
}