<?php
namespace poirot\redis;

class PhpModuleRedis extends AbstractRedis
{

    /**
     * @param null $params
     */
    function __construct($params = null)
    {
        if($params)
            parent::__construct($params);

        parent::__construct(['host'=>'127.0.0.1' , 'port'=>6379 , 'recordNum'=>200 , 'table'=>'tbl1']);

        $redisClient = new Redis();
        $redisClient->connect($this->host , $this->port);

        $this->redisHandler = $redisClient;

        if($params)
            $this->setFromArray($params);

        return $this;
    }


    /**
     * @param array $data
     * @return $this
     */
    function persist(array $data)
    {
        if($this->redisHandler) {

            $this->redisHandler->setOption(Redis::OPT_PREFIX, $this->table.':');

            for ($i = 0; $i < $this->recordNum; $i++) {
                foreach ($data as $key => $value) {
                    $this->redisHandler->set($key, $value);
                }
            }
        }

        return $this;
    }


    /**
     * @param array $data
     * @return bool
     */
    function persistPipe(array $data)
    {

        $result = false;

        if($this->redisHandler) {

            $this->redisHandler->_prefix($this->table);

            for ($i = 0; $i < $this->recordNum; $i++) {
                $record = [];
                $this->redisHandler->multi();
                foreach ($this->columns as $column) {
                    $this->redisHandler->set($column, $record[$column]);
                }

                $result = $this->redisHandler->exec();
            }

        }

        return $result;
    }


}
