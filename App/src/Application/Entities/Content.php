<?php

namespace IMSExport\Application\Entities;

use IMSExport\Application\Repositories\Content as ContentModel;
use IMSExport\Core\BaseEntity;

class Content extends BaseEntity
{
    public function __construct(protected array $data, protected int $counter)
    {
        $this->repository = new ContentModel();
    }

    public function generaContent(string $type, int $id)
    {
        $contenido = $this->repository->getData($this->repository->generaContent($type, $id));
        $salida = $this->Plantilla($contenido[0]['title'], $contenido[0]['description']);
        $this->grabaContent($salida);
    }

    /**
     * Funcion solo para obtener, mediante el idGrupo, los Blogs y Wikis contenidos en el
     */
    public function contentGrupo(string $type, int $idgrupo)
    {
        $contenidos = $this->repository->getData($this->repository->contentGrupo($type, $idgrupo));

        foreach ($contenidos as $contenido) {
            $this->generaContent($type, $contenido['Id']);
        }
    }

    const PATH = './storage/export/IMS/';
    function grabaContent($salida)
    {
        $this->counter++;
        $file = "web_content_{$this->counter}";
        $dirName = self::PATH . $this->data['seedId'] . DIRECTORY_SEPARATOR . $file;
        $fileName = $dirName . DIRECTORY_SEPARATOR . $file . ".html";

        if (file_exists($dirName)) {
            unlink($fileName);
            rmDir($dirName);
        }

        if (!mkdir($dirName, 0777, true))
            die('Fallo al crear las carpetas...'); //Quizas por falta de permisos

        $fp = fopen($fileName, "w");
        fwrite($fp, $salida);
        fclose($fp);
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
}
