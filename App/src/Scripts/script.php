<?php

$currentDir = __DIR__;

$dirSplit = explode('src', $currentDir);

$sourceDir = $dirSplit[0];

require_once $sourceDir . 'vendor/autoload.php';

use Carbon\Carbon;
use IMSExport\Application\ExportIMS\Scripts\ExecuteExport;

$now = Carbon::now();

(new ExecuteExport($now))
    ->atMinute(0)
    ->atMinute(15)
    ->atMinute(30)
    ->atMinute(45);