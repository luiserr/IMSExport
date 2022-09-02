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
    protected Foro $foro;
    protected Collection $archivos;

    public function __construct(protected Group $group, protected array $data)
    {
//        find Foro
        $this->foro = new Foro($this->data['id']);
//      $this->foro->forumByPost($this->data['id']);
        $this->archivos = Collection::createCollection($this->foro->forumFile);

        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createDiscussion(function () use ($self) {
                $self
                    ->createDetail($self->group->title, $self->group->description, $self->archivos);
            });
            $this->finish();
        } catch (Exception $exception) {
    
        }
    }

    protected function finish(): BaseFormat
    {
        $this->XMLGenerator->finish();
        return $this;
    }

    public function getName(): string
    {
        return "{$this->data['identifierRef']}.xml";
    }

    public function getFolderName(): string
    {
        return "{$this->group->groupId}/{$this->data['identifierRef']}";
    }

    public function getType(): string
    {
        return 'imsdt_xmlv1p1';
    }
}