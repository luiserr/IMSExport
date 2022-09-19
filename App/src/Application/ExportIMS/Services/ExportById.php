<?php

namespace IMSExport\Application\ExportIMS\Services;

class ExportById extends BaseExport
{
    public function export()
    {
        $seedId = $this->data['seedId'];
        $group = $this->createGroup($seedId);
        $processId = $this->registerProcess($group);
        //print_r("<br />2 Services/ExportById export <br />seedId: ") . var_dump($seedId) . "<br />" . print_r("<br />group: ") . var_dump($group) . "<br />";exit;
        echo "<br />2 Services/ExportById export seedId: <pre>";
        print_r($seedId);
        echo "<br /></pre><br />";
        echo "<br />2 Services/ExportById export group: <pre>";
        print_r($group);
        echo "<br /></pre><br />";exit;

        $this->init($group);
        $this->finishProcess($processId);
        print_r(['success' => true, 'message' => 'curso exportado con éxito']);
    }
}
