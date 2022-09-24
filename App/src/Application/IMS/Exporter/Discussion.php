<?php

namespace IMSExport\Application\IMS\Exporter;

use Exception;
use IMSExport\Application\Entities\Foro;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSDiscussionFormat;
use IMSExport\Helpers\Collection;

class Discussion extends IMSDiscussionFormat
{
    protected $foro;
    protected $archivos;
    protected $group;
    protected $data;

    public function __construct($group, $data)
    {
        $this->group = $group;
        $this->data = $data;
//      find Foro
        $this->foro = new Foro($this->data['id']);
//      $this->foro->forumByPost($this->data['id']);
        $this->archivos = Collection::create($this->foro->forumFile);

        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createDiscussion(function () use ($self) {
                $self
                    ->createDetail($self->foro->title, $self->foro->description, $self->archivos);
            });
            $this->finish();
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    protected function finish()
    {
        $this->XMLGenerator->finish();
        return $this;
    }

    public function getName()
    {
        return "{$this->data['identifierRef']}.xml";
    }

    public function getFolderName()
    {
        return "{$this->group->seedId}/{$this->data['identifierRef']}";
    }

    public function getType()
    {
        return 'imsdt_xmlv1p1';
    }
}