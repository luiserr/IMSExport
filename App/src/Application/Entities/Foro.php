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
        //print_r("<br />Data: ".$data."<br />"); exit;
        $this->setData($data);
    }

    public function forumFile()//: ?array
    {
        $files = $this->repository->getData($this->repository->forumByPost($this->id));
        if ($files)
            $this->setAttribute('forumfile', $files);

        return [];

//      return $this->repository->getData($this->repository->forumFile($this->id));
    }
}