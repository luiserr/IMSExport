<?php

namespace IMSExport\Core;


use Carbon\Carbon;
use DateTime;

abstract class Script
{

    /**
     * @param Carbon $now
     */
    public function __construct(protected Carbon $now)
    {
    }

    public static function log($message)
    {
        $datetime = (new DateTime())->format('d-m-Y H:i:s');
        echo "[{$datetime}]   : $message \n";
    }

    public function atMinute(int $minute): static
    {
        $currentMinute = $this->now->minute;
        if ($currentMinute === $minute) {
            $this->run();
        }
        return $this;
    }

    public abstract function run();

    public function atHour(int $hour): static
    {
        $currentHour = $this->now->hour;
        self::log($currentHour . '=' . $hour);
        if ($currentHour === $hour) {
            $this->run();
        }
        return $this;
    }

    public function everyMinute()
    {
        $this->run();
    }

}