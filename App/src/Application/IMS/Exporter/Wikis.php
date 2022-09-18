<?php

namespace IMSExport\Application\IMS\Exporter;

use IMSExport\Application\IMS\Services\Formats\WebContents;

class Wikis extends WebContents
{

    public function find()
    {
        return $this->repository->firstElement(
            $this->repository->getWiki($this->data['id'])
        );
    }
}