<?php

namespace IMSExport\Core;


use Carbon\Carbon;
use DateTime;

abstract class Script
{
    protected $now;

    /**
     * @param Carbon $now
     */
    public function __construct($now)
    {
        $this->now = $now;
    }

    public function atMinute($minute)
    {
        $currentMinute = $this->now->minute;
        if ($currentMinute === $minute) {
            $this->run();
        }
        return $this;
    }

    public abstract function run();

    public function atHour($hour)
    {
        $currentHour = $this->now->hour;
        self::log($currentHour . '=' . $hour);
        if ($currentHour === $hour) {
            $this->run();
        }
        return $this;
    }

    public static function log($message)
    {
        $datetime = (new DateTime())->format('d-m-Y H:i:s');
        echo "[{$datetime}]   : $message \n";
    }

    public function everyMinute()
    {
        $this->run();
    }

}