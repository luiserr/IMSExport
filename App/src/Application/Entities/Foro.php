<?php
namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Forum as ForumModel;
use IMSExport\Core\BaseEntity;

class Foro extends BaseEntity
{
    /**
     * @var mixed|null
     */
    private mixed $forumFile;

    public function __construct(public string $id)
    {
        $this->repository = new ForumModel();
        $this->forumByPost();
        $this->forumFile();
    }

    public function forumByPost()
    {
        $data = $this->repository->firstElement($this->repository->forumByPost($this->id));
        $this->setData($data);
    }

    public function forumFile(): ?array
    {
        $files = $this->repository->getData($this->repository->forumFile($this->id));
        if($files) {
            $this->setAttribute('forumFile', $files);
            return $files;
        }
        return [];
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