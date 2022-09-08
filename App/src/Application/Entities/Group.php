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
          /*['id' => 1, 'parent_id' => 0, 'typeActivity' => null, 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => 152228607, 'parent_id' => 1, 'typeActivity' => 'exam', 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => 2, 'parent_id' => 0, 'typeActivity' => null, 'type' => 'discussion', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => 101357094, 'parent_id' => 2, 'typeActivity' => 'forum', 'type' => 'discussion', 'title' => 'S1: Foro de consultas', 'description' => 'TEXTO HTML'] 
//101357054 0 Attach
//101357092 1 Attach
//101357094 2 Attach
            */
            ['id' => 2, 'parent_id' => 0, 'typeActivity' => null, 'type' => 'web_content', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => 101357095, 'parent_id' => 2, 'typeActivity' => 'evidence', 'type' => 'web_content', 'title' => 'Evidencia 1', 'description' => 'Algo de Texto'] 
        ];
    }

    public function getFolders()
    {
        return $this->$this->repository->searchFolders();
    }
}
