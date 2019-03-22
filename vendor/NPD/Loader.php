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
	   	     return $this->dispatcher->dispatch($controller, $method, $arguments);
	   }
}
