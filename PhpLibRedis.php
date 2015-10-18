<?php
namespace poirot\redis;

class PhpLibRedis extends AbstractRedis
{

    /**
     * @param redis $redisHandler
     * @param null $params
     */
    function __construct(redis $redisHandler , $params = null)
    {
        $this->redisHandler = $redisHandler;
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

            $this->redisHandler->_prefix($this->table);

            for ($i = 0; $i < $this->recordNum; $i++) {
                $this->redisHandler->mset($data);
            }

        }

        return $this;
    }


    /**
     * @param array $data
     * @return bool|void
     */
    function persistPipe(array $data)
    {

        $result = false;

        if($this->redisHandler) {

            $this->redisHandler->_prefix($this->table);

            for ($i = 0; $i < $this->recordNum; $i++) {
                // $record = fetch from db
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