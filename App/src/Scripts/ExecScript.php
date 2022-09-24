<?php

namespace IMSExport\Scripts;

use Carbon\Carbon;
use IMSExport\Core\Script;

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

    public function atMinute(int $minute, Script $script)
    {
        $currentMinute = $this->now->minute;
        if ($currentMinute === $minute) {
            $script->run();
        }
        return $this;
    }

    public function atHour(int $hour, Script $script): static
    {
        $currentHour = $this->now->hour;
        if ($currentHour === $hour) {
            $script->run();
        }
        return $this;
    }
}