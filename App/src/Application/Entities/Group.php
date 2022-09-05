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
        $this->find();
    }

    public function find()
    {
//        $this->repository->find($this->groupId);
        $dummyData = [
            'id' => '0001',
            'title' => 'Test Course',
            'description' => 'Test Course Description'
        ];
        $this->setData($dummyData);
    }

    public function resources(): array
    {
        return [
            ['id' => 1, 'parent_id' => 0, 'typeActivity' => null, 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => '152228607', 'parent_id' => 1, 'typeActivity' => 'exam', 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => '336570223', 'parent_id' => 1, 'typeActivity' => 'exam', 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description']
        ];
    }

    public function getFolders()
    {
        return $this->$this->repository->searchFolders();
    }
}
