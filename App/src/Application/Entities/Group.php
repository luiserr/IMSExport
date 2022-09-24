<?php

namespace IMSExport\Application\Entities;

use Exception;
use IMSExport\Application\Constants\Activities;
use IMSExport\Application\Repositories\Group as GroupModel;
use IMSExport\Core\BaseEntity;

/**
 * @property mixed|null $title
 * @property mixed|null $description
 * @property array|null $resources
 */
class Group extends BaseEntity
{
    public $seedId;
    protected $typeId;
    /**
     * @throws Exception
     */
    public function __construct($seedId, $typeId = 'groupId')
    {
        $this->seedId = $seedId;
        $this->typeId = $typeId;
        $this->repository = new GroupModel();
        $this->find();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function find()
    {
        if ($this->typeId === 'seedId') {
            $this->findBySeedId();
        } else {
            $this->findGroupId();
        }
    }

    /**
     * @throws Exception
     */
    public function findBySeedId()
    {
        $group = $this->repository->firstElement(
            $this->repository->findBySeedId($this->seedId)
        );
        if ($group) {
            $this->setData($group);
            return $this;
        }
        throw new Exception('Grupo no encontrado');
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function findGroupId()
    {
        $group = $this->repository->firstElement(
            $this->repository->findGroupId($this->seedId)
        );
        if ($group) {
            $this->setData($group);
            return $this;
        }
        throw new Exception('Grupo no encontrado');
    }

    public function resources()
    {
        return [
            ['id' => 1, 'parent_id' => 0, 'typeActivity' => null, 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => '152228607', 'parent_id' => 1, 'typeActivity' => 'exam', 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description'],
            ['id' => '336570223', 'parent_id' => 1, 'typeActivity' => 'exam', 'type' => 'assets', 'title' => 'Test Exam', 'description' => 'Test Description']
        ];
    }

    public function scaffolding()
    {
        if (!$this->getAttribute('scaffolding')) {
            $scaffolding = $this
                ->getScaffolding();
            $this
                ->setAttribute('scaffolding', $scaffolding)
                ->getAttribute('scaffolding');
        }
        return $this->getAttribute('scaffolding');
    }

    protected function getScaffolding()
    {
        $folders = $this->repository->getData(
            $this->repository->getFolders($this->getAttribute('id'))
        );
        $post = $this->repository->getData(
            $this->repository->getPost($this->getAttribute('id'))
        );
        $blogs = $this->repository->getData(
            $this->repository->getBlogs($this->getAttribute('id'))
        );
        $wikis = $this->repository->getData(
            $this->repository->getWikis($this->getAttribute('id'))
        );
        return array_merge($folders, $post, $wikis, $blogs);
    }
}
