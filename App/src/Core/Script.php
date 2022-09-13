<?php

namespace IMSExport\Core;


use DateTime;

abstract class Script
{

    public static function log($message)
    {
        $datetime = (new DateTime())->format('d-m-Y H:i:s');
        echo "[{$datetime}]   : $message \n";
    }

    public abstract function run();
}