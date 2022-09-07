<?php
namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Forum as ForumModel;
use IMSExport\Core\BaseEntity;

class Foro extends BaseEntity
{
    public function __construct(public string $id)
    {
        $this->repository = new ForumModel();
        $this->forumByPost();
        $this->forumFile();
    }

    public function forumByPost()
    {
        return $this->repository->firstElement($this->repository->forumByPost($this->id));
    }

    public function forumFile()
    {
        return $this->repository->getData($this->repository->forumFile($this->id));
    }
/*
    public function getQuestion()
    {
        return $this->repository->getData($this->repository->getQuestion($this->id));
    }

    public function getAnswer()
    {
        return $this->repository->getData($this->repository->getAnswer($this->id));
    }
*/
}