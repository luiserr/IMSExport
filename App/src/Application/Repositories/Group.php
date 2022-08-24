<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Group extends BaseModel
{
    public function find($id): array|null
    {
        $sql = "select 
                g.idgrupo as groupId,
                g.nombre as name,
                g.fic_id as fichaId                               
                from grupo g                
                where g.idgrupo = :id;";
        return $this->query($sql, ['id' => $id]);
    }

    public function searchFolders(int $groupId): array|null
    {
        $sql = "
            select * from temas_clase where idclase = :groupId
        ";
        return $this->query($sql, compact('groupId'));
    }

}
