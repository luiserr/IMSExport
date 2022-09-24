<?php

$currentDir = __DIR__;

$dirSplit = explode('src', $currentDir);

$sourceDir = $dirSplit[0];

require_once $sourceDir . '/paths.php';
require_once VENDOR . 'autoload.php';

use Carbon\Carbon;
use IMSExport\Application\ExportIMS\Scripts\ExecuteExport;

$now = Carbon::now();

(new ExecuteExport($now))
    ->everyMinute();