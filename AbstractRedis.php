<?php

namespace poirot\redis;

/**
 * Class AbstractRedis
 */
abstract class AbstractRedis implements tblToRedis
{
    /**
     * @var
     */
    protected $host;

    /**
     * @var
     */
    protected $port;

    /**
     * @var
     */
    protected $table;

    /**
     * @var
     */
    protected $columns;

    /**
     * @var
     */
    protected $ttl;

    /**
     * @var
     */
     protected $redisHandler;

    /**
     * @return mixed
     */
    public function getRedisHandler()
    {
        return $this->redisHandler;
    }

    /**
     * @var
     */
    protected $recordNum;

    /**
     * @return mixed
     */
    public function getRecordNum()
    {
        return $this->recordNum;
    }

    /**
     * @param mixed $recordNum
     */
    public function setRecordNum($recordNum)
    {
        $this->recordNum = $recordNum;
    }


    function __construct(array $options)
    {
        $this->setHost($options['host']);
        $this->setPort($options['port']);
        $this->setRecordNum($options['recordNum']);
        $this->setTable($options['table']);
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }


    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }


    /**
     * @param $ttl
     * @return $this
     */
    function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }


    /**
     * @return string
     */
    protected function getColumns()
    {
        if(empty($this->columns))
            $this->columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'my_database' AND TABLE_NAME = 'my_table';";

        return $this->columns;
    }

    /**
     * @param array $array
     */
    function setupFromArray(array $array)
    {

    }

    abstract function  persist(array $data);

    abstract function  persistPipe(array $data);
}
