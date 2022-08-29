<?php

namespace IMSExport\Application\Entities;

use IMSExport\Core\BaseEntity;

class Exam extends BaseEntity
{
    public function __construct(public string $id)
    {
        $this->find();
    }

    public function find()
    {
        $dummyData = [
            'title' => 'esto es un examen',
            'description' => 'Examen de pruebas'
        ];
        $this->setData($dummyData);
    }
}