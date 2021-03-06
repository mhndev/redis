<?php

class PhpModuleRedis extends AbstractRedis
{

    /**
     * @param null $params
     */
    function __construct(array $params = [])
    {
        if($params)
            parent::__construct($params);

        parent::__construct($params);

        $redisClient = new Redis();
        $redisClient->connect('127.0.0.1' , 6379);

        $this->redisHandler = $redisClient;

        if($params)
            $this->setupFromArray($params);

        return $this;
    }

    /**
     * @param $namespace
     * @param null $args
     * @return array
     */
    function fetchFromNamespace($namespace , $args = null)
    {
        if(empty($this->getRecordsIn))
            $this->recordsIn = $this->redisHandler->keys($namespace.':*');

        if(!$args)
            return $this->recordsIn;
        else
            return count($this->recordsIn) < $args['count']? $this->recordsIn : array_slice($this->recordsIn, 0, $args['count']);
    }


    /**
     * @param array $data
     * @return $this
     */
    function persist(array $data)
    {
        if($this->redisHandler) {

            $this->redisHandler->setOption(Redis::OPT_PREFIX, $this->namespace.':');

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
        if($this->redisHandler) {
            $this->redisHandler->_prefix($this->namespace);


            var_dump($data);
            die();
            $pipe = $this->redisHandler->multi();

            for ($i = 0; $i < $this->recordNum; $i++) {
                foreach($data as $key => $value)
                    $pipe->set($key , $value);
            }

            $this->redisHandler->exec();

        }
    }


}
