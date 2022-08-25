<?php

namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Group as GroupModel;
use IMSExport\Core\BaseEntity;

/**
 * @property mixed|null $title
 * @property mixed|null $description
 * @property array|null $resources
 */
class Group extends BaseEntity
{

    public function __construct(public int $groupId)
    {
        $this->repository = new GroupModel();
    }

    public function find()
    {
        $this->repository->find($this->groupId);
    }

    public function getFolders()
    {
        return $this->$this->repository->searchFolders();
    }
}
