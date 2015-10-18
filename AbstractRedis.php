<?php



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
     * @var
     */
    protected $recordsIn;


    /**
     * @var
     */
    protected $namespace;

    /**
     * @return mixed
     */
    public function getRecordsIn()
    {
        return $this->recordsIn;
    }
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
//        $this->setHost($options['host']);
//        $this->setPort($options['port']);
//        $this->setRecordNum($options['recordNum']);
//        $this->setTable($options['table']);
//        $this->setNamespace($options['namespace']);
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
        return $this->columns;
    }

    /**
     * @param array $array
     */
    function setupFromArray(array $array)
    {
        foreach($array as $key => $val){
            $this->{'set'.$key}($val);
        }
    }


    function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    function getNamespace()
    {
        return $this->namespace;
    }

    abstract function  persist(array $data);

    abstract function  persistPipe(array $data);
}
