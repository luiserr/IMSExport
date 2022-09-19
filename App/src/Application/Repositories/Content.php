<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;


/** 
 * App/src/Application/Repositories/Content.php
 *
 * @author Ricardo Alzaga
 * @version	2.0.0, 08-sep-2022
 * 
 */
class Content extends BaseModel
{
    function generaContent(string $type, int $id): array|null
    {
        if (!isset($id))
            die("Parámetro id Inválido");

        switch ($type) {
            case "Evidence":
                $sql = "SELECT post.titulo AS title, post.contenido AS description FROM post INNER JOIN tarea ON post.idPost = tarea.fk_idPost WHERE post.idPost = :id;";
                break;
            case "Blog":
                $sql = "SELECT blog.idBlog, blog.titulo AS title, bloglog.contenido AS description FROM blog INNER JOIN bloglog ON blog.idBlog = bloglog.fk_idBlog WHERE blog.estado=1 AND bloglog.estado=1 AND blog.idBlog = :id;";
                break;
            case "Wiki": //Problemas de conversión en Título por contenido en él
                $sql = "SELECT wiki.idWiki, wikilog.titulo AS title, wikilog.contenido AS description FROM wiki INNER JOIN wikilog ON wiki.idWiki = wikilog.fk_idWiki WHERE wiki.idWiki = :id;";
                break;
            default:
                die("Contenido solicitado Inválido");
        }

        return $this->query($sql, ['id' => $id]);
    }

    /**
     * Funcion solo para obtener, mediante el idGrupo, los Blogs y Wikis contenidos en el
     */
    function contentGrupo(string $type, int $idgrupo): array|null
    {
        if (!isset($idgrupo))
            die("Parámetro id Inválido");

        switch ($type) {
            case "Blog":
                $sql = "SELECT fk_idGrupo, blog.idBlog AS Id FROM (grupo INNER JOIN blog ON grupo.idgrupo = blog.fk_idGrupo) INNER JOIN bloglog ON blog.idBlog = bloglog.fk_idBlog WHERE blog.estado = 1 AND bloglog.estado = 1 AND blog.fk_idGrupo = :id";
                break;
            case "Wiki": //Problemas de conversión en Título por contenido en él
                $sql = "SELECT DISTINCT categoriaswiki.idGrupo, wiki.idWiki AS Id FROM ((grupo INNER JOIN categoriaswiki ON grupo.idgrupo = categoriaswiki.idGrupo) INNER JOIN wiki ON categoriaswiki.idCategoria = wiki.fk_idCategoria) INNER JOIN wikilog ON wiki.idWiki = wikilog.fk_idWiki WHERE categoriaswiki.idGrupo = :id";
                break;
            default:
                die("Contenido solicitado InválidoOOO");
        }
    
        return $this->query($sql, ['id' => $idgrupo]);
    }
}
