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
        return $this->
    }
}