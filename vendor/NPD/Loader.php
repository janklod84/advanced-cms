<?php 
namespace NPD;

use NPD\Routing\Dispatcher;

/**
 * Loader
 * @package NPD\Loader
*/
class Loader
{

	   /**
	    * Dispatcher
	    * 
	    * @var NPD\Routing\Dispatcher
	   */
	   private $dispatcher;

	   /**
	    * container of controllers object
	    * 
	    * @var array
	   */
	   private $controllers = [];


	   /**
	    * container of models objects
	    * 
	    * @var array
	   */
	   private $models = [];

       
       /**
        * Constructor
        * 
        * @param NPD\Routing\Dispatcher
       */
	   public function __construct(Dispatcher $dispatcher)
	   {
             $this->dispatcher = $dispatcher;
	   }

	   /**
	    * Load a controller
	    * 
	    * @param string $controller
	    * @param string $method
	    * @param array $arguments
	    * @return mixed
	   */
	   public function controller($controller, $method, array $arguments = [])
	   {
	   	     if($this->controllerExists($controller))
	   	     {
	   	     	    echo $method .'<br>';

	   	     	    $object = $this->controllers[$controller];

	   	     	    if(is_callable([$object, $method]))
	   	     	    {
	   	     	    	  return call_user_func_array([$object, $method], $arguments);

	   	     	    }else{

	   	     	    	  // redirect to not found page
                          echo 'private';
	   	     	    }

	   	     }else{
                
     	   	     $result = $this->dispatcher->dispatch($controller, $method, $arguments);
                 $this->controllers[$controller] = $result['object'];
                 return $result['data'];
	   	     }

	   }


	   /**
	    * determine wether controller object is stored in controllers container
	    * 
	    * @param string $controller
	    * @return bool
	   */
	   private function controllerExists($controller)
	   {
	   	     return (bool) isset($this->controllers[$controller]);
	   }
}
