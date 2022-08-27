<?php

namespace IMSExport\Core\Connection;

interface PDOResultInterface
{
    public function next();

    public function close();

    public function count();
}