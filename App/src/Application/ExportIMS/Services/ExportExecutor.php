<?php

namespace IMSExport\Application\ExportIMS\Services;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\ExportIMS\Repository\Export;
use IMSExport\Application\IMS\Exporter\Cartridge;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;

class ExportExecutor
{
    const ready = 'ready';
    const inProgress = 'inProgress';
    const finished = 'finished';
    const error = 'error';
    protected Group $group;
    protected Export $repository;

    public function __construct(public array $data)
    {
        $this->repository = new Export();
    }

    /**
     * @throws Exception
     */
    public function export()
    {
        $group = $this->createGroup($this->data['groupId'], $this->data['typeId']);
        $cartridge = new Cartridge($group);
        $export = $cartridge->export();
        if ($export) {
            $path = $cartridge::PATH . $cartridge->getFolderName() . '.zip';
            if ($this->data['id']) {
                $this->finishProcess($this->data['id'], $path);
            }
        }
    }

    /**
     * @param string $groupId
     * @param string $typeId
     * @return Group
     * @throws Exception
     */
    protected function createGroup(string $groupId, string $typeId): Group
    {
        return new Group($groupId, $typeId);
    }

    /**
     * @param $processId
     * @param $path
     * @return void
     * @throws Exception
     */
    protected function finishProcess($processId, $path)
    {

        $this->repository->finish($processId, self::finished, $path);
    }
}