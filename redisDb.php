<?php


class redisDb
{
    protected static $_driverName;
    protected static $_driver;
    protected static $_instance;
    protected static $_options;


    /**
     * @param null $driver
     * @param array $options
     * @throws Exception
     */
    private function __construct($driver = null , $options = [])
    {
        if($driver)
            if($driver == 'phpModule' && !extension_loaded('redis'))
                throw new Exception("php redis module has'nt been loaded maybe it's not installed");
        self::$_driverName = $driver;

        if($driver == 'phpModule') {
            self::$_driver = new PhpModuleRedis($options);

        }
        else
            self::$_driver = new PhpLibRedis($options);

    }


    /**
     * @param null $driver
     * @param array $options
     * @return redisDb
     */
    public static function getInstance ($driver = null , array $options = [])
    {
        if (!self::$_instance) {
            self::$_instance = new self($driver , $options);
            self::$_driver->setupFromArray($options);
        }

        return self::$_instance;
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

        if(empty(self::$_driverName))
            if($driver == 'phpModule')
                self::$_driver = new PhpModuleRedis();
            self::$_driver = new PhpLibRedis();


        return $this;
    }


    /**
     * @return mixed
     */
    function getDriver()
    {
        return self::$_driver;
    }

    /**
     * @param $data
     */
    function  persist($data)
    {
        if(self::$_driver == 'phpModule'){
            self::$_driver->persist($data);
        }
    }

    function  persistPipe()
    {
        //call driver persist function
    }

}