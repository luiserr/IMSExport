<?php

namespace IMSExport\Core\Connection;

class MysqlPDO {
    /*VARIABLES*/
    var $dbIp;
    var $dbPort;
    var $dbUser;
    var $dbPassword;
    var $dbDatabaseName;
    var $dbDatabase;
    var $dbLink;
    var $sentencia;
    var $fechaConexion;
    var $ipConexion;
    var $transaction;
    var $debug;

    public function __construct($dbIp, $dbPort, $dbUser, $dbPassword, $dbDatabaseName, $debug = FALSE) {
        $this->debug = $debug;
        $this->dbIp = $dbIp;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbDatabaseName = $dbDatabaseName;
        $this->fechaConexion = date("Y-m-d H:i:s");
    }

    public function openConection($charset="latin1") {
        //$charset="utf8"
        //Abrimos la conexion
        if ($this->dbLink = new PDO('mysql:dbname='.$this->dbDatabaseName.';host='.$this->dbIp."; port=".$this->dbPort.';charset='.$charset, $this->dbUser, $this->dbPassword)) {
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

    public function closeConection() {
        $this->closeCursor();
        $this->dbLink = NULL;
    }

    public function bTransaction (){
        $this->dbLink->beginTransaction();
        return TRUE;
    }

    public function commit() {
        $this->dbLink->commit();
        return TRUE;
    }

    public function rollback() {
        $this->dbLink->rollBack();
        return TRUE;
    }

    public function closeCursor() {
        try {
            if (!is_null($this->sentencia)) {
                $this->sentencia->close();
                $this->sentencia = NULL;
            }
        } catch (Exception $ex) {
            if ($this->debug) error_log($ex->getMessage());
        }
    }

    public function getNext() {
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

    /**
     * Funcion que ejecuta una consulta SELECT
     * @param {
     * formatedString , esta es una cadena que ha sido preparada para recibir variables vinculadas
     * formatValues, arreglo que contiene los valores que seran sustituidos por vprintf	y estos valores no deben ir escapados
     * @author {Ruben Alvarado}
     * @version {1.0}
     */
    public function runQuery($preparedString, $preparedValues, $fetch_all = FALSE) {
        try {
            $sentencia = $this->dbLink->prepare($preparedString);
            $sentencia->execute($preparedValues);

            if ($fetch_all) {
                $arrResult = $sentencia->fetchAll();
                $result = new \Dashboard\Core\Connection\pdoResult_Array($arrResult, $this->debug);
                $this->sentencia = $result;
            } else {
                $result = new \Dashboard\Core\Connection\pdoResult_Record($sentencia, $this->debug);
                $this->sentencia = $result;			//->fetch(PDO::FETCH_ASSOC);
            }

            return array(
                "resultados" => $result,
                "afectedRows" => $result->count(),
                "affectedRows"=>$result->count(),
                "numRows"=>$result->count(),
                "errorInfo" => "",
                "success"=>true,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        } catch (PDOException $e) {
            return array(
                "resultados" => NULL,
                "afectedRows" => 0,
                "affectedRows"=>0,
                "numRows"=>0,
                "errorInfo" => $this->debug ? $e->getMessage() : "",
                "success"=>false,
                "sentencia" => $this->debug ? $preparedString : ""
            );
            //print "<br />".$this->dbLink->prepare($preparedString);;
        }
    }

    /**
     * Funcion que ejecuta una consulta INSERT, UPDATE o DELETE
     * @param {
     * formatedString , esta es una cadena que ha sido preparada para recibir variables vinculadas
     * formatValues, arreglo que contiene los valores que seran sustituidos por vprintf	y estos valores no deben ir escapados
     * @author {Ruben Alvarado}
     * @version {1.0}
     */
    public function executeQuery($preparedString, $preparedValues) {
        try {
            $sentencia = $this->dbLink->prepare($preparedString);
            $sentencia->execute($preparedValues);

            return array(
                "afectedRows" => $sentencia->rowCount(),
                "affectedRows"=> $sentencia->rowCount(),
                "insertId" => $this->dbLink->lastInsertId(),
                "errorInfo" => "",
                "success"=>true,
                "sentencia" => $this->debug ? $preparedString : ""
            );
        } catch (PDOException $e) {
            //print "<br />ERROR PDO: ".$e->getMessage();
            return array(
                "afectedRows" => 0,
                "affectedRows"=>0,
                "insertId" => NULL,
                "errorInfo" => $this->debug ? $e->getMessage() : "",
                "success"=>false,
                "sentencia" => $this->debug ? $preparedString : ""
            );
            //print "<br />".$this->dbLink->prepare($preparedString);;
        }
    }

}


abstract class pdoResult {
    protected $debug;
    public $result;

    function __construct($result, $debug) {
        $this->debug = $debug;
        $this->result = $result;
    }

    abstract public function next();

    abstract public function close();

    abstract public function count();
}


class pdoResult_Record extends \Dashboard\Core\Connection\pdoResult
{
    public function next() {
        return $this->result->fetch(PDO::FETCH_ASSOC);
    }

    public function close() {
        try {
            if (!is_null($this->result)) {
                $this->result->closeCursor();
                $this->result = NULL;
            }
        } catch (Exception $ex) {
            if ($this->debug) error_log($ex->getMessage());
        }
    }

    public function count() {
        if (!is_null($this->result))
            return $this->result->rowCount();
        else
            return 0;
    }
}

class pdoResult_Array extends pdoResult {
    private $index;

    public function __construct($result, $debug) {
        parent::__construct($result, $debug);
        $this->index = -1;
    }

    public function next() {
        $this->index++;
        if ($this->index < $this->count())
            return $this->result[$this->index];
        else
            return FALSE;
    }

    public function close() {
        $this->result = array();
    }

    public function count() {
        if (is_array($this->result))
            return count($this->result);
        else
            return 0;
    }
}
