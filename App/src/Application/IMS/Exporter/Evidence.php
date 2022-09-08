<?php
//https://www.imsglobal.org/cc/ccv1p2/imscc_profilev1p2-Implementation.html#toc-8
namespace IMSExport\Application\IMS\Exporter;

use Exception;
use IMSExport\Application\Entities\Evidencia;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Services\Formats\BaseFormat;
use IMSExport\Application\IMS\Services\Formats\IMSEvidenceFormat;
use IMSExport\Helpers\Collection;

class Evidence extends IMSEvidenceFormat
{
    protected Evidencia $evidencia;
    protected Collection $archivos;

    public function __construct(protected Group $group, protected array $data)
    {
        $this->evidencia = new Evidencia($this->data['id']);
//      $this->evidencia->evidenceByPost($this->data['id']);
        $this->archivos = Collection::createCollection($this->evidencia->evidenceFile);

        parent::__construct();
    }

    public function export()
    {
        try {
            $self = $this;
            $this->createEvidence($self->group->title, $self->group->description, $self->archivos);
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
        return "{$this->data['identifierRef']}.html";
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