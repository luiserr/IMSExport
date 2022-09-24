<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Exam extends BaseModel
{
    public function find($id)
    {
        $sql = "SELECT e.*, g.idgrupo FROM examen e
            INNER JOIN post p ON (p.idpost = e.idpost)
            INNER JOIN grupo g ON (p.fk_usuarioSocial_destino = g.fk_idusuarioSocial)
            WHERE e.idpost = :id";
        return $this->query($sql, compact('id'));
    }

    public function getSection($id)
    {
    	$sql = "SELECT * FROM examen_seccion WHERE idExamen = :id";
        return $this->query($sql, compact('id'));
    }

    public function getQuestion($id)
    {
    	$sql = "SELECT * FROM preguntas WHERE idPost = :id";
        return $this->query($sql, compact('id'));
    }

    public function getAnswer($id)
    {
    	$sql = "SELECT * FROM respuestas WHERE idPreguntas = :id";
        return $this->query($sql, compact('id'));
    }
}