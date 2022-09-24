<?php

namespace IMSExport\Core\Connection;

class PDOResultArray extends PDOResult
{
    private $index;

    public function __construct($result, $debug)
    {
        parent::__construct($result, $debug);
        $this->index = -1;
    }

    public function next()
    {
        $this->index++;
        if ($this->index < $this->count())
            return $this->result[$this->index];
        else
            return FALSE;
    }

    public function count()
    {
        if (is_array($this->result))
            return count($this->result);
        else
            return 0;
    }

    public function close()
    {
        $this->result = array();
    }
}