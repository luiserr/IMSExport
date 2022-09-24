<?php

namespace IMSExport\Core\Connection;

use PDO;
use PDOException;

class MysqlPDO
{
    /**
     * @var PDO|null
     */
    public $dbLink;
    public $debug;
    protected $dbIp;
    protected $dbPort;
    protected $dbUser;
    protected $dbPassword;
    protected $dbDatabaseName;
    protected $dbDatabase;
    /**
     * @var PDOResultInterface
     */
    protected $sentencia;
    protected $fechaConexion;
    protected $ipConexion;
    protected $transaction;

    public function __construct($dbIp, $dbPort, $dbUser, $dbPassword, $dbDatabaseName, $debug = FALSE)
    {
        $this->debug = $debug;
        $this->dbIp = $dbIp;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbDatabaseName = $dbDatabaseName;
        $this->fechaConexion = date("Y-m-d H:i:s");
    }

    public function closeConnection()
    {
        $this->closeCursor();
        $this->dbLink = NULL;
    }

    public function closeCursor()
    {
        try {
            if (!is_null($this->sentencia)) {
                $this->sentencia->close();
                $this->sentencia = NULL;
            }
        } catch (Exception $ex) {
            if ($this->debug) error_log($ex->getMessage());
        }
    }

    public function beginTransaction()
    {
        $this->dbLink->beginTransaction();
        return TRUE;
    }

    public function commit()
    {
        $this->dbLink->commit();
        return TRUE;
    }

    public function rollback()
    {
        $this->dbLink->rollBack();
        return TRUE;
    }

    public function getNext()
    {
        return $this->sentencia->next();
    }

    public function __sleep()
    {
        return array('dsn', 'username', 'password');
    }

    public function __wakeup()
    {
        $this->openConection();
    }

    public function openConection($charset = "latin1")
    {
        //$charset="utf8"
        //Abrimos la conexion
        if ($this->dbLink = new PDO('mysql:dbname=' . $this->dbDatabaseName . ';host=' . $this->dbIp . "; port=" . $this->dbPort . ';charset=' . $charset, $this->dbUser, $this->dbPassword)) {
            $this->dbLink->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $this->dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbLink->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $this->dbLink->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
            $this->dbLink->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            if ($this->debug) error_log($this->dbIp);
            return TRUE;
        } else {
            if ($this->debug) error_log($this->dbIp);
            return FALSE;
        }
    }

    public function runQuery($preparedString, $preparedValues, $fetch_all = FALSE)
    {
        try {
            $sentencia = $this->dbLink->prepare($preparedString);
            $sentencia->execute($preparedValues);

            if ($fetch_all) {
                $arrResult = $sentencia->fetchAll();
                $result = new PDOResultArray($arrResult, $this->debug);
                $this->sentencia = $result;
            } else {
                $result = new PDOResultRecord($sentencia, $this->debug);
                $this->sentencia = $result;
            }

            return array(
                "resultados" => $result,
                "afectedRows" => $result->count(),
                "affectedRows" => $result->count(),
                "numRows" => $result->count(),
                "errorInfo" => "",
                "success" => true,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        } catch (PDOException $e) {
            return array(
                "resultados" => NULL,
                "afectedRows" => 0,
                "affectedRows" => 0,
                "numRows" => 0,
                "errorInfo" => $this->debug ? $e->getMessage() : "",
                "success" => false,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        }
    }

    public function executeQuery($preparedString, $preparedValues)
    {
        try {
            $sentencia = $this->dbLink->prepare($preparedString);
            $sentencia->execute($preparedValues);

            return array(
                "afectedRows" => $sentencia->rowCount(),
                "affectedRows" => $sentencia->rowCount(),
                "insertId" => $this->dbLink->lastInsertId(),
                "errorInfo" => "",
                "success" => true,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        } catch (PDOException $e) {
            return array(
                "afectedRows" => 0,
                "affectedRows" => 0,
                "insertId" => NULL,
                "errorInfo" => $this->debug ? $e->getMessage() : "",
                "success" => false,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        }
    }

}
