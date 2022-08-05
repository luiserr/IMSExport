<?php

namespace IMSExport\Core\Connection;

use Exception;
use PDO;

class BaseModel
{
    /**
     * @var MysqlPDO $connection
     */
    protected $connection;
    protected $params;

    protected $host;
    protected $port;
    protected $db;
    protected $user;
    protected $pass;

    const PROCTORING = 'proctoring';
    const EXAM = 'exam';
    const REPLICA = 'replica';

    public function __construct($server = self::REPLICA)
    {
        $this->getConnectionParams($server)
            ->setConnection($this->host, $this->port, $this->user, $this->pass, $this->db);
    }

    /**
     * @param $server
     * @return $this
     */
    public function getConnectionParams($server)
    {
        require _DASHBORAD . 'src/Core/Connection/configuration.php';
        $config = $ServiceConfiguration;
        switch ($server) {
            case self::PROCTORING:
                $config = $config[self::PROCTORING];
                break;
            case self::EXAM:
                $config = $config[self::EXAM];
                break;
            default:
                $config = $config[self::REPLICA];
        }
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->db = $config['db'];
        return $this;
    }


    public function setConnection($host, $port, $user, $pass, $db)
    {
        $mySqlPdo = new MysqlPDO(
            $host,
            $port,
            $user,
            $pass,
            $db
        );
        $this->connection = $this->openConection($mySqlPdo);
        return $this;
    }

    public function firstElement($resource)
    {
        $data = $this->getData($resource);
        if ($data) {
            return isset($data[0]) ? $data[0] : null;
        }
        return null;
    }

    /**
     * @param $resource
     * @return null|array
     */
    public function getData($resource)
    {
        if ($resource && isset($resource['success']) && $resource['success']) {
            /*
             * @var PDOStatement $statment;
             */
            $statment = $resource['data'];
            return $statment->fetchAll(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function getDataPaginate($resouce)
    {
        return [
            'data' => $this->getData($resouce),
            'pagination' => $resouce['pagination']
        ];
    }

    protected function query($sql, $parameters = [], $pagination = null)
    {
        $resource = $this
            ->connection
            ->runQuery($sql, $parameters);
        if ($resource['success']) {
            if (!$pagination) {
                return $this->response($resource, []);
            }
            $paginator = $this->getPaginator($resource, $pagination);
            $paginateResource = $this->executePaginateQuery($sql, $parameters, $paginator);
            if ($paginateResource['success']) {
                return $this->response($paginateResource, $paginator);
            }
        }
        return null;
    }

    /**
     * @param MysqlPDO $connection
     * @return MysqlPDO
     */
    private function openConection($connection)
    {
        $connection->openConection('utf8mb4');
        $connection->debug = 1;
        $connection->dbLink->exec("set names 'utf8mb4'");
        return $connection;
    }

    private function response($resource, $pagination = null)
    {
        $response = [
            'data' => $resource['resultados']->result,
            'success' => $resource['success']
        ];
        if (!$pagination) {
            return $response;
        }
        $response['pagination'] = $pagination;
        return $response;
    }

    private function getPaginator($resource, $pagination)
    {
        $perPage = isset($pagination['perPage']) ? (int)$pagination['perPage'] : 0;
        $page = isset($pagination['page']) ? (int)$pagination['page'] : 10;
        $totalItems = (int)$resource['numRows'];
        $totalPages = ceil($totalItems / $perPage);
        return [
            'perPage' => $perPage,
            'currentPage' => $perPage ? (($page - 1) * $perPage) : 10,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems
        ];
    }

    private function executePaginateQuery($sql, $parameters, $paginator)
    {
        $newSQL = $this->builderPaginateSQL($sql, $paginator['currentPage'], $paginator['perPage']);
        return $this->connection->runQuery($newSQL, $parameters);
    }

    private function builderPaginateSQL($sql, $page, $perPage)
    {
        if (strpos($sql, strtoupper('limit')) || strpos($sql, 'limit')) {
            return $sql;
        }
        $newSQL = $sql;
        str_replace(';', '', $newSQL);
        $newSQL .= " LIMIT {$page} " . ($perPage ? ", {$perPage}" : '');
        return $newSQL;
    }

    protected function execute($sql, $parameters = [])
    {
        return $this
            ->connection
            ->executeQuery($sql, $parameters);
    }

    /**
     * @param $sql
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    protected function executeOrFail($sql, $parameters = [])
    {
        $execution = $this->execute($sql, $parameters);
        if (!$execution['success']) {
            throw new Exception($execution['errorInfo']);
        }
        return $execution;
    }

    public function beginTransaction()
    {
        $this->connection->bTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollback()
    {
        $this->connection->rollback();
    }
}
