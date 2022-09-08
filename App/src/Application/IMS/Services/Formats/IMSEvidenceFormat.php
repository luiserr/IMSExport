<?php

namespace IMSExport\Application\IMS\Services\Formats;
use IMSexport\Application\XMLGenerator\Generator;

abstract class IMSEvidenceFormat extends BaseFormat
{

    public function createEvidence(string $title, string $description, $attach): self
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
    print_r($plantilla);
        $this->XMLGenerator->createElement('html', null, html_entity_decode($plantilla),null);

        return $this;
    }
}