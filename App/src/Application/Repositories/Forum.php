<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Forum extends BaseModel
{ 
    public function forumByPost($id): array|null
    {
        $sql = "SELECT post.titulo AS title, post.contenido AS description 
                FROM post INNER JOIN foro_preguntas ON post.idPost = foro_preguntas.fk_idpost 
                WHERE foro_preguntas.fk_idpost = :id;";
        return $this->query($sql, ['id' => $id]);
    }

    public function forumFile($id): array|null
    {
        $sql = "SELECT filepath AS attach FROM archivo WHERE post_idPost = :id;";
        return $this->query($sql, ['id' => $id]);
    }
}
