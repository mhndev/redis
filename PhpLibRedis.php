<?php

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
     */
    function persistPipe(array $data)
    {
        if($this->redisHandler) {

            $this->redisHandler->_prefix($this->table);

            for ($i = 0; $i < $this->recordNum; $i++) {
                $pipe = $this->redisHandler->multi();
                foreach ($data as $key => $value) {
                    $pipe->set($key, $value);
                }

                $pipe->exec();
            }

        }
    }
}