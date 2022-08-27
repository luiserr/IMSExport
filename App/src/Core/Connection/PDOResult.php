<?php

namespace IMSExport\Core\Connection;

abstract class PDOResult implements PDOResultInterface {
    protected $debug;
    public $result;

    function __construct($result, $debug) {
        $this->debug = $debug;
        $this->result = $result;
    }
}