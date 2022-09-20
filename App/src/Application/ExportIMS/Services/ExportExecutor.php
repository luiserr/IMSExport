<?php

namespace IMSExport\Application\ExportIMS\Services;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\ExportIMS\Repository\Export;
use IMSExport\Application\IMS\Exporter\Cartridge;

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
        $this->init($group);
        if ($this->data['id']) {
            $this->finishProcess($this->data['id']);
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
     * @param Group $group
     * @return bool
     * @throws Exception
     */
    protected function init(Group $group): bool
    {
        return (new Cartridge($group))->export();
    }

    /**
     * @param $processId
     * @return void
     * @throws Exception
     */
    protected function finishProcess($processId)
    {
        $this->repository->finish($processId, self::finished);
    }
}