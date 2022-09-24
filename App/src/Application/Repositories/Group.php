<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Group extends BaseModel
{
    public function findBySeedId($id)
    {
        $sql = "select 
			g.idgrupo as id,
			g.nombre as title,
			g.nombre as description,
			g.siglas as seedId,
			g.fk_idusuarioSocial as socialId
			from grupo g where siglas = :id;";
        return $this->query($sql, ['id' => $id]);
    }

    public function findGroupId($id)
    {
        $sql = "select 
			g.idgrupo as id,
			g.nombre as title,
			g.nombre as description,
			g.siglas as seedId,
			g.fk_idusuarioSocial as socialId
			from grupo g where g.idgrupo = :id;";
        return $this->query($sql, ['id' => $id]);
    }

    public function searchFolders(int $groupId)
    {
        $sql = "
            select * from temas_clase where idclase = :groupId
        ";
        return $this->query($sql, compact('groupId'));
    }

    public function getFolders($groupId)
    {
        $sql = "
           SELECT 
			idTema as id, 
			nombre as title, 
			if(idPadre = 0, null, idPadre) as parentId,
			'folder' as resourceType
            FROM temas_clase
            WHERE idClase = :groupId        
        ";
        return $this->query($sql, compact('groupId'));
    }

    public function getPost($groupId){
        $sql = "
            SELECT 
			p.idPost as id,
			if(p.titulo != '', p.titulo, p.contenido) as title,
			p.contenido as content, 
			if (
				p.fk_idTema is not null and p.fk_idTema != 0, 
				p.fk_idTema,
				(
				select tc2.idContenido from tcu_modulo tm
				inner join tcu_contenido tc2 on tc2.idContenido = tm.fk_idContenido
				where tm.fk_idPost = p.idPost 
				limit 1
				)
			) as parentId,
			(SELECT
					IF(t.fk_idPost IS NOT NULL, 'task',
					IF(ex.idPost IS NOT NULL,
					IF(STRCMP(ex.tipoExamen, 'exams')=0,'exam', 'probe'),
					IF(sco.fk_idPost IS NOT NULL, 'scorm', 
					IF(tcu.idContenido IS NOT NULL, 'tcu','resource')))) as tipo
					FROM post p2
					LEFT JOIN tarea t ON (t.fk_idpost = p2.idpost)
					LEFT JOIN examen ex ON (ex.idPost = p2.idPost)
					LEFT JOIN scorm sco ON (sco.fk_idPost = p2.idPost)
					LEFT JOIN tcu_contenido tcu ON (tcu.idContenido = p2.idpost)
					WHERE p2.idPost = p.idPost
					limit 1
			) as resourceType 
            FROM post as p
            left JOIN tcu_contenido tc ON (tc.idContenido = p.idpost)                                   
            WHERE 
            fk_usuarioSocial_destino = (Select fk_idusuarioSocial From grupo where idgrupo = :groupId limit 1)                        
            order by idPost desc
        ";
        return $this->query($sql, compact('groupId'));
    }

    public function getBlogs($groupId)
    {
        $sql = "
            SELECT
            b.idBlog as id,
            b.titulo as title,   
            b.titulo as content,   
            null as parentId,
            'blog' as `resourceType`                
            FROM blog b            
            WHERE b.fk_idGrupo = :groupId
            AND b.estado = 1 
        ";
        return $this->query($sql, compact('groupId'));
    }

    public function getWikis($groupId)
    {
        $sql = "
            SELECT
                w.idWiki as id,                                
                wl.titulo as title,   
                w.descripcion as content,
                null as parentId,
                'wiki' as `resourceType`                
                FROM wiki w
                LEFT JOIN categoriaswiki cw on cw.idCategoria = w.fk_idCategoria
                INNER JOIN grupo g on g.idgrupo = cw.idGrupo
                INNER JOIN wikilog wl on wl.fk_idWiki = w.idWiki                             
                WHERE w.wiki_disponible = 1 and wl.fk_idWiki is not null
                and g.idgrupo = :groupId
                GROUP BY w.idWiki
        ";
        return $this->query($sql, compact('groupId'));
    }

}
