<?php 
namespace NPD\Routing;

use NPD\Http\Request;


class Dispatcher
{
        
        /**
         * Request Object
         * 
         * @var NPD\Http\Request $request
        */
        private $request;


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
        public function __construct(Request $request)
        {
              $this->request = $request;
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
             $className .= 'Controller';  // fontend\main\homeController

             $file = $this->path;
             $file .= str_replace(['/', '\\'], DS, $controller) .'.php'; // main\home or main/home
             

             if(file_exists($file))
             {
             	 require($file);

             	 $object = new $className();
                 
             	 if(is_callable([$object, $method]))
             	 {
             	 	  return call_user_func_array([$object, $method], $args);

             	 }else{
                      
                      die('No callable');
                      // redirect to not found page
             	 }

             }else{

             	  // redirect to not found page
             }
	    }
}