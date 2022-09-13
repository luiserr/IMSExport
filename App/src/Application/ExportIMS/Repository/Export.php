<?php

namespace IMSExport\Application\ExportIMS\Repository;

use Exception;
use IMSExport\Core\Connection\BaseModel;

class Export extends BaseModel
{
    /**
     * @param string $groupId
     * @param string $typeId
     * @param string $status
     * @return array
     * @throws Exception
     */
    public function init(string $groupId, string $typeId, string $status): array
    {
        $sql = "             
           insert into group_exports (groupId, typeId, status) values (:groupId, :typeId, :status);
        ";
        return $this->executeOrFail($sql, compact('groupId', 'typeId', 'status'));
    }

    /**
     * @param int $processId
     * @param string $status
     * @return array
     * @throws Exception
     */
    public function finish(int $processId, string $status)
    {
        $sql = "
            update group_exports set finishedAt = current_timestamp() , status = :status where id = :processId ;
        ";
        return $this->executeOrFail($sql, compact('status', 'processId'));
    }

    public function getInProgress(): ?array
    {
        $sql = "
            select 
			ge.id,
			ge.groupId,
			ge.createdAt,
			ge.typeId,
			ge.sourceType			
			from group_exports ge where ge.status = 'inProgress';
        ";
        return $this->query($sql);
    }
}