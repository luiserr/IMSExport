<?php

namespace IMSExport\Application\Repositories;

use IMSExport\Core\Connection\BaseModel;

class Exam extends BaseModel
{
    public function find(int $id): array|null
    {
        $sql = "SELECT e.*, g.idgrupo FROM examen e
            INNER JOIN post p ON (p.idpost = e.idpost)
            INNER JOIN grupo g ON (p.fk_usuarioSocial_destino = g.fk_idusuarioSocial)
            WHERE e.idpost = :id";
        return $this->query($sql, compact('id'));
    }

    public function getSection(int $id): array|null
    {
    	$sql = "SELECT * FROM examen_seccion WHERE idExamen = :id";
        return $this->query($sql, compact('id'));
    }

    public function getQuestion(int $id): array|null
    {
    	$sql = "SELECT * FROM preguntas WHERE idPost = :id";
        return $this->query($sql, compact('id'));
    }

    public function getAnswer(int $id): array|null
    {
    	$sql = "SELECT * FROM respuestas WHERE idPreguntas = :id";
        return $this->query($sql, compact('id'));
    }
}