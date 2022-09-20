<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class WebContents extends BaseModel
{
    public function getTask($id): ?array
    {
        $sql = "
            SELECT 
                   p.idPost as id,
                   p.titulo AS title, 
                   p.contenido AS description 
                   FROM post p
                   WHERE p.idPost = :id;
        ";
        return $this->query($sql, compact('id'));
    }

    public function getBlog($id)
    {
        $sql = "
            SELECT 
                   blog.idBlog as id, 
                   blog.titulo AS title, 
                   bloglog.contenido AS description 
                   FROM blog 
                   INNER JOIN bloglog ON blog.idBlog = bloglog.fk_idBlog 
                   WHERE blog.estado=1 
                   AND bloglog.estado=1 
                   AND blog.idBlog = :id;
        ";
        return $this->query($sql, compact('id'));
    }

    public function getWiki($id): ?array
    {
        $sql = "
            SELECT 
                   wiki.idWiki as id, 
                   wikilog.titulo AS title, 
                   wikilog.contenido AS description 
            FROM wiki 
            INNER JOIN wikilog ON wiki.idWiki = wikilog.fk_idWiki 
            WHERE wiki.idWiki = :id;
        ";
        return $this->query($sql, compact('id'));
    }
}