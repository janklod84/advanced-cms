<?php 
namespace NPD\Routing;

use NPD\Http\Request;
use NPD\Application;

class Dispatcher
{
        
        /**
         * Request Object
         * 
         * @var NPD\Http\Request $request
        */
        private $request;
        

        /**
         * Application object
         * 
         * @var NPD\Application
        */
        private $app;



        /**
         * set the script name for the current route
         * 
         * @var string
        */
        private $script;




        /**
         * The full path of controller of the current route
         * 
         * @var string
        */
        private $path;


        /**
         * Constructor
         * 
         * @param NPD\Http\Request $request
        */
        public function __construct(Request $request, Application $app)
        {
              $this->request = $request;
              $this->app = $app;
              $this->preparePath();
        }


	    /**
	     * set the path of the controller folder
	     * 
	     * @return void
	    */
	    private function preparePath()
	    {
             $this->script = $this->request->getScriptName();
             $this->path  = ROOT .'scripts' . DS . $this->script . DS . 'controller' . DS;
	    }


	  
	    /**
	     * create a new object of controller and call a method from it
	     * 
	     * main/home
	     * 
	     * Try echo out echo $className
	     * Try echo out echo $file
	     * 
	     * @param string $controller 
	     * @param string $method 
	     * @param type|array $args 
	     * @return string
	     */
	    public function dispatch($controller, $method, $args = [])
	    {
             $className = $this->script . '\\';     // frontend\
             $className .= str_replace('/', '\\', $controller); // fontend\main\home
             
             // echo $className .'<br>'; frontend\main\home

             $className = explode(DS, $className);
             $className = array_map('camel_case', $className);
             $className = implode(DS, $className);

             // echo $className .'<br>'; Frontend\Main\Home

             $className .= 'Controller';

             $file = $this->path;
             $file .= str_replace(['/', '\\'], DS, $controller) .'.php'; // main\home or main/home
             

             if(file_exists($file))
             {
             	 require($file);

             	 $object = new $className($this->app);
                 
             	 if(is_callable([$object, $method]))
             	 {
             	 	  $data = call_user_func_array([$object, $method], $args);

             	 	  return compact('object', 'data');

             	 }else{
                      
                      die('No callable');
                      // redirect to not found page
             	 }

             }else{

             	  // redirect to not found page
             }
	    }
}