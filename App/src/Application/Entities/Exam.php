<?php

namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Exam as ExamModel;
use IMSExport\Core\BaseEntity;

class Exam extends BaseEntity
{
    public function __construct(public string $id)
    {
        $this->repository = new ExamModel();
        $this->find();
    }

    public function find()
    {
        return $this->repository->firstElement($this->repository->find($this->id));
    }

    public function getSection()
    {
        return $this->repository->getData($this->repository->getSection($this->id));
    }

    public function getQuestion()
    {
        return $this->repository->getData($this->repository->getQuestion($this->id));
    }

    public function getAnswer()
    {
        return $this->repository->getData($this->repository->getAnswer($this->id));
    }
}