<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\IMS\Services\Formats\WebContents;

class Blogs extends WebContents
{

    public function find()
    {
        return $this->repository->firstElement(
            $this->repository->getBlog($this->data['id'])
        );
    }
}