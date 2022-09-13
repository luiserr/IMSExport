<?php

namespace IMSExport\Core\Connection;

use PDOException;
use PDO;

/**
 * Conexion con la Base de Datos para extraer informacion de WebContents;
 * Evidencias, Blogs y Wikis
 * 
 */
class Conexion extends PDO
{
    private $host = '20.51.249.57'; // 10.9.0.9 o 40.76.244.92 o 20.51.249.57
    private $port = '13306'; //3306 o SENA Development 13306
    private $db = 'territorio2_0';
    private $usr = 'territorium';
    private $pwd = 'T3rr1t0r1um4zur3';
    private $chrset = 'utf8';

    public function __construct()
    {
        try {
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            parent::__construct('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db . ';charset=' . $this->chrset, $this->usr, $this->pwd, $options);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage() . "<br />";
            exit;
        }
    }
}