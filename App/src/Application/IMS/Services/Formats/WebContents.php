<?php

namespace IMSExport\Application\IMS\Services\Formats;

use Exception;
use IMSExport\Application\Entities\Group;
use IMSExport\Application\Repositories\WebContents as Repository;

abstract class WebContents extends BaseFormat
{
    protected Repository $repository;

    public function __construct(protected Group $group, protected array $data)
    {
        $this->repository = new Repository();
        parent::__construct();
    }

    public function getName(): string
    {
        return "{$this->data['identifierRef']}.html";
    }

    public function getFolderName(): string
    {
        return "{$this->group->seedId}/{$this->data['identifierRef']}";
    }

    public function getType(): string
    {
        return '';
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function export(): bool
    {
        $content = $this->find();
        if (!$content) {
            throw new Exception('No se encontró el contenido');
        }
        $template = $this->template($content['title'], $content['description']);
        return $this->record($template);
    }

    protected abstract function find();

    protected function template($title, $description): string
    {
        return "
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
    }

    function record($salida)
    {
        $fileName = $this->getFullPath();
//        if (file_exists($dirName)) {
//            unlink($fileName);
//            rmDir($dirName);
//        }
//        if (!mkdir($dirName, 0777, true))
//            die('Fallo al crear las carpetas...'); //Quizas por falta de permisos

        $fp = fopen($fileName, "w");
        fwrite($fp, $salida);
        fclose($fp);
        return true;
    }
}