<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Evidence extends BaseModel
{ 
    public function evidenceByPost($id): array|null
    {
        $sql = "SELECT post.titulo AS title, post.contenido AS description 
                FROM post INNER JOIN tarea ON post.idPost = tarea.fk_idPost 
                WHERE post.idPost = :id;";
        return $this->query($sql, ['id' => $id]);
    }

    public function evidenceFile($id): array|null
    {
        $sql = "SELECT filepath AS attach FROM archivo WHERE post_idPost = :id;";
        return $this->query($sql, ['id' => $id]);
    }
}
