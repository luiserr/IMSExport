<?php

namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Exam as ExamModel;
use IMSExport\Core\BaseEntity;

class Answer extends BaseEntity
{
    public function __construct(public string $id)
    {
        $this->repository = new ExamModel();
    }

    public function find()
    {
        return $this->repository->getData($this->repository->getAnswer($this->id));
    }
}