<?php

namespace IMSExport\Application\Entities;
use PDO;
use PDOException;
use IMSExport\Core\Connection\Conexion;

/** 
 * App/src/Application/Entities/webContents.php
 *
 * @author Ricardo Alzaga
 * @version	1.0.0, 08-sep-2022
 * 
 */

class WebContents
{

    function generaContent(string $type, int $id)
    {
        if (!isset($id))
            die("Parámetro id Inválido");

        $pdo = new Conexion();

        switch ($type) {
            case "Evidence":
                $sql = $pdo->prepare("SELECT post.titulo AS title, post.contenido AS description FROM post INNER JOIN tarea ON post.idPost = tarea.fk_idPost WHERE post.idPost = :id;");
                $sql->bindValue(':id', $id, PDO::PARAM_INT);
                break;
            case "Blog":
                $sql = $pdo->prepare("SELECT blog.idBlog, blog.titulo AS title, bloglog.contenido AS description FROM blog INNER JOIN bloglog ON blog.idBlog = bloglog.fk_idBlog WHERE blog.estado=1 AND bloglog.estado=1 AND blog.idBlog = :id;");
                $sql->bindValue(':id', $id, PDO::PARAM_INT);
                break;
            case "Wiki": //Problemas de conversión en Título por contenido en él
                $sql = $pdo->prepare("SELECT wiki.idWiki, wikilog.titulo AS title, wikilog.contenido AS description FROM wiki INNER JOIN wikilog ON wiki.idWiki = wikilog.fk_idWiki WHERE wiki.idWiki = :id;");
                $sql->bindValue(':id', $id, PDO::PARAM_INT);
                break;
            default:
                $pdo = null;
                die("Contenido solicitado Inválido");
        }

        try {
            $sql->execute();
            $error = $sql->errorInfo(); //$error[0]=00000; todo bien.
            if ($error[0] != "00000") {
                print_r($error);
                exit();
            }
            //header("HTTP/1.1 200 OK");
            //echo "\nRegistros: " . $sql->rowCount() . "<br />\n";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage() . "<br />\n";
            //header("HTTP/1.1 400 Bad Request"); //405 Method Not Allowed
            exit();
        }

        $pdo = null;

        if ($sql->rowCount() == 0)
            return false;

        while ($row = $sql->fetch(PDO::FETCH_ASSOC))
            $salida = $this->Plantilla($row['title'], $row['description']);

        return $salida;
    }

    function Plantilla($title, $description)
    {
        $plantilla = "
    <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
    <html>
        <head>
            <title>{$title}</title>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <style type='text/css'>
                div.ccbb-attachments table {
                    margin: 0;
                    padding: 0;
                    border: 0;
                    outline: 0;
                    display: table;
                }
    
                div.ccbb-attachments th {
                    color: #555;
                    vertical-align: top;
                    font: 300 .78em 'Lucida Grande', Arial, sans-serif;
                }
    
                div.ccbb-attachments td {
                    vertical-align: top;
                    font: 300 .78em 'Lucida Grande', Arial, sans-serif;
                }
    
                div.ccbb-attachments ol,
                ul,
                li {
                    list-style: none;
                    margin: 0;
                    padding: 0;
                    border: 0;
                    outline: 0;
                }
    
                div.ccbb-attachments a {
                    color: #128FA8;
                    text-decoration: none;
                }
            </style>
        </head>
    
        <body>
            <!-- content body -->
            {$description}
            <!-- end of content body -->
        </body>
    </html>        
    ";
        return $plantilla;
    }

    function grabaContent($dir, $salida)
    {
        $file = $dir . ".html";
        if (file_exists($dir)) {
            unlink($dir . DIRECTORY_SEPARATOR . $file);
            rmDir($dir);
        }

        if (!mkdir($dir, 0777, true))
            die('Fallo al crear las carpetas...');

        $fp = fopen($dir . DIRECTORY_SEPARATOR . $file, "w");
        fwrite($fp, $salida);
        fclose($fp);
    }


    function contentGrupo(string $type, int $idgrupo, int &$record)
    {
        if (!isset($idgrupo))
            die("Parámetro id Inválido");

        $pdo = new Conexion();

        switch ($type) {
            case "Blog":
                $sql = $pdo->prepare("SELECT fk_idGrupo, blog.idBlog 
            FROM (grupo INNER JOIN blog ON grupo.idgrupo = blog.fk_idGrupo) INNER JOIN bloglog ON blog.idBlog = bloglog.fk_idBlog
            WHERE blog.estado = 1 AND bloglog.estado = 1 AND blog.fk_idGrupo = :id");
                $sql->bindValue(':id', $idgrupo, PDO::PARAM_INT);
                break;
            case "Wiki": //Problemas de conversión en Título por contenido en él
                $sql = $pdo->prepare("SELECT categoriaswiki.idGrupo, wiki.idWiki 
            FROM ((grupo INNER JOIN categoriaswiki ON grupo.idgrupo = categoriaswiki.idGrupo) INNER JOIN wiki ON categoriaswiki.idCategoria = wiki.fk_idCategoria) INNER JOIN wikilog ON wiki.idWiki = wikilog.fk_idWiki
            WHERE categoriaswiki.idGrupo = :id");
                $sql->bindValue(':id', $idgrupo, PDO::PARAM_INT);
                break;
            default:
                $pdo = null;
                die("Contenido solicitado Inválido");
        }

        $sql->execute();
        $pdo = null;

        if ($sql->rowCount() == 0)
            die("No hay {$type} en éste Grupo");

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            if ($type == "Blog")
                $salida = $this->generaContent("Blog", $row['idBlog']); //Identificador de Blog
            else //Wiki
                $salida = $this->generaContent("Wiki", $row['idWiki']); //Identificador de Wiki

            $record++;
            $dir = "web_content_" . $record;
            $this->grabaContent($dir, $salida);
        }

        return true;
    }
}

// --------------------------------------------------------------------------------
/**
 * 
 * $registro es el registro que sigue para generar web_content_$registro
 * 
 * Para obtener individualmente Evidence, Blog o Wiki, utilizar
 *    generaContent("Evidence", Id); Donde Id es post.idPost o tarea.fk_idPost ej. 101357095
 *    generaContent("Blog", Id); Donde Id es blog.idBlog ej. 120624
 *    generaContent("Wiki", Id); Donde Id es wiki.idWiki ej. 78410
 * Posteriormente indicar:
 *    $dir = "web_content_{$registro}";
 *    grabaContent($dir, $salida);
 * 
 * En el caso de Blogs y Wiki, si se tiene grupo.idgrupo, se pueden obtener en rafaga mediante:
 *    contentGrupo("Blog", $idgrupo, $registro) o 
 *    contentGrupo("Wiki", $idgrupo, $registro)
 * Donde $idgrupo es grupo.idgrupo al que pertenecen
 * 
 */
