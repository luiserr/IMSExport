<?php
namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Evidence as EvidenceModel;
use IMSExport\Core\BaseEntity;

class Evidencia extends BaseEntity
{
    public function __construct(public string $id)
    {
        $this->repository = new EvidenceModel();
        $this->evidenceByPost();
        $this->evidenceFile();
    }

    public function evidenceByPost()
    {
        return $this->repository->firstElement($this->repository->evidenceByPost($this->id));
    }

    public function evidenceFile()
    {
        return $this->repository->getData($this->repository->evidenceFile($this->id));
    }
}