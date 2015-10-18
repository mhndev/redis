<?php


class redisDb
{
    protected $_driverName;
    protected $_driver;
    protected $_options;


    /**
     * @param null $driver
     * @param array $options
     * @throws Exception
     */
    public function __construct($driver = null , $options = [])
    {
        if($driver)
            if($driver == 'phpModule' && !extension_loaded('redis'))
                throw new Exception("php redis module has'nt been loaded maybe it's not installed");
        $this->_driverName = $driver;


        if($driver == 'phpModule') {
            $this->_driver = new PhpModuleRedis($options);
            $this->_driver->setupFromArray($options);

        }
//        else
//            $this->_driver = new PhpLibRedis($options);
//        $this->_driver->setupFromArray($options);

    }

    /**
     * @param $driver
     * @return mixed
     * @throws Exception
     */
    function setDriver($driver)
    {
        if($driver == 'phpModule' && !extension_loaded('redis'))
            throw new Exception("php redis module has'nt been loaded may be it's not installed");

        if(empty($this->_driverName))
            if($driver == 'phpModule')
                $this->_driver = new PhpModuleRedis();
            $this->_driver = new PhpLibRedis();


        return $this;
    }


    /**
     * @return mixed
     */
    function getDriver()
    {
        return $this->_driver;
    }

    /**
     * @param $data
     */
    function  persist($data)
    {
        if($this->_driver == 'phpModule'){
            $this->_driver->persist($data);
        }
    }

    function persistPipe($data)
    {
        if($this->_driverName == 'phpModule'){
            $this->_driver->persistPipe($data);
        }
    }

}