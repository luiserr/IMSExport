<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\IMS\Services\Formats\WebContents;

class Tasks extends WebContents
{

    public function find()
    {
        return $this->repository->firstElement(
            $this->repository->getTask($this->data['id'])
        );
    }
}