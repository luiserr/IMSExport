<?php

$currentDir = __DIR__;

$dirSplit = explode('src', $currentDir);

$sourceDir = $dirSplit[0];

require_once $sourceDir . 'vendor/autoload.php';

use Carbon\Carbon;
use IMSExport\Application\ExportIMS\Scripts\ExecuteExport;

$now = Carbon::now();

(new ExecuteExport($now))
    ->atHour(15)
    ->atHour(16)
    ->atHour(20)
    ->atHour(21);