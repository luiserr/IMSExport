<?php

namespace IMSExport\Core\Connection;

use Exception;
use PDO;

class PDOResultRecord extends PDOResult
{
    public function next()
    {
        return $this->result->fetch(PDO::FETCH_ASSOC);
    }

    public function close()
    {
        try {
            if (!is_null($this->result)) {
                $this->result->closeCursor();
                $this->result = NULL;
            }
        } catch (Exception $ex) {
            if ($this->debug) error_log($ex->getMessage());
        }
    }

    public function count()
    {
        if (!is_null($this->result))
            return $this->result->rowCount();
        else
            return 0;
    }
}
