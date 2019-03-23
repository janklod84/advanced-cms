<?php 
namespace NPD\Routing;

use NPD\Application;


abstract class Controller
{
       
        /**
         * Application object
         * 
         * @var NPD\Application
        */
        private $app;


        /**
         * Constructor
         * 
         * @param NPD\Application $app 
         * @return void
         */
        public function __construct(Application $app)
        {
             $this->app = $app;
        }

        /**
         * assign a key with its value to the controller class
         * 
         * @param string $key
         * @param mixed $value
         * @return void
        */
        public function __set($key, $value)
        {
        	  $this->{$key} = $value;
        }


        /**
         * get a value from this class or from application class
         * 
         * @param string $key
         * @return mixed
        */
        public function __get($key)
        {
            return $this->app->call($key);
        }
}