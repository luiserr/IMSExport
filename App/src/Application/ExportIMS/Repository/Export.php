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
    public function create($groupId, $typeId, $status)
    {
        $sql = "             
           insert into group_exports (groupId, typeId, status) values (:groupId, :typeId, :status);
        ";
        return $this->executeOrFail($sql, compact('groupId', 'typeId', 'status'));
    }

    /**
     * @param int $processId
     * @param string $status
     * @param $exportPath
     * @return array
     * @throws Exception
     */
    public function finish($processId, $status, $exportPath)
    {
        $sql = "
            update group_exports set finishedAt = current_timestamp() , status = :status, exportPath = :exportPath where id = :processId ;
        ";
        return $this->executeOrFail($sql, compact('status', 'exportPath', 'processId'));
    }

    /**
     * @param string $status
     * @return array
     * @throws Exception
     */
    public function init($exportId, $status = 'inProgress')
    {
        $sql = "
            update group_exports set status = :status, startedAt = current_timestamp() where id = :exportId;
        ";
        return $this->executeOrFail($sql, compact('status', 'exportId'));
    }

    public function getNext()
    {
        $sql = "
            select 
			ge.id,
			ge.groupId,
			ge.createdAt,
			ge.typeId,
			ge.sourceType			
			from group_exports ge where ge.status = 'ready' 
			order by ge.id asc;
        ";
        return $this->query($sql);
    }

    public function getInProgress($status = 'ready')
    {
        $sql = "
            select 
			ge.id,
			ge.groupId,
			ge.createdAt,
			ge.startedAt,
			ge.finishedAt,
			ge.typeId,
			ge.sourceType			
			from group_exports ge where ge.status = :status and ge.deletedAt is null
            order by ge.id asc 
        ";
        return $this->query($sql, compact('status'));
    }

    public function delete($exportId)
    {
        $sql = "
            update group_exports set deletedAt = current_timestamp() where id = :exportId;
        ";
        return $this->executeOrFail($sql, compact('exportId'));
    }

    public function find($exportId)
    {
        $sql = "
            select 
			ge.id,
			ge.groupId,
			ge.createdAt,
			ge.typeId,
			ge.sourceType,
            ge.exportPath
			from group_exports ge where ge.id = :exportId  
			order by ge.id asc;
        ";
        return $this->query($sql, compact('exportId'));
    }
}