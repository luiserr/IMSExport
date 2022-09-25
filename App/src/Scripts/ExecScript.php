<?php

namespace IMSExport\Scripts;

use IMSExport\Helpers\Carbon\Carbon;

class ExecScript
{
    protected $now;

    /**
     * @param Carbon $now
     */
    public function __construct($now)
    {
        $this->now = $now;
        $this->now = Carbon::now();
    }

    public function atMinute($minute, $script)
    {
        $currentMinute = $this->now->minute;
        if ($currentMinute === $minute) {
            $script->run();
        }
        return $this;
    }

    public function atHour($hour, $script)
    {
        $currentHour = $this->now->hour;
        if ($currentHour === $hour) {
            $script->run();
        }
        return $this;
    }
}