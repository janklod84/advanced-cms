<?php 
namespace NPD;


use Closure;
use NPD\Routing\Router as Route;

class Application 
{
	  
        /**
         * container of objects 
         * 
         * @var array 
        */
        private $objects = [];

        
        /**
         * Set specials registers to store its values in customized way
         * 
         * @var array
        */
        private $specials = [];

        
        /**
         * Constructor
        */
        // public function __construct(){}

        
        /**
         * initialiaze main settings
         * 
         * @return void
        */
  	    public function bootstrap()
  	    {
             // Load the method that is responsible for loading classes
  	    	   $this->loadClasses();

  	    	   // Load main helpers files
  	    	   $this->loadHelpers();


  	    	   // initialize request class
  	    	   // and prepare its main settings
             $this->register('request', new Request());

              
             // initialise route class
             $route = new Route($this->request);
             $this->register('route', $route);


             // require the index file for the current script [index.php as routes.php]
             require ROOT . 'scripts'. DS . $this->request->getScriptName() . DS . 'index.php';


  	    	   // initialize session class
  	    	   $this->register('session', function ($app) {
  	    	   	    return (new Session($app->request));
  	    	   });

             // Route build 
             $this->route->build();
            
  	    }

  	    /**
  	     * Register classes in the spl library
  	     * 
  	     * @return void
  	    */
  	    private function loadClasses()
  	    {
              spl_autoload_register([$this, 'loadClass']);
  	    }

        
        /**
	     * require the file of the initialised object if found
	     * 
	     * @param string $className
	     * @return void 
	    */
	    private function loadClass($className)
	    {
	    	  if(strpos($className, '\\') !== false)
	    	  {
	    	  	  $className = str_replace('\\', DS, $className);
	    	  }

              if(file_exists($file = ROOT . 'vendor'. DS . $className .'.php'))
              {
              	    require $file;

              }else{

              	  die('class ' . $className .' not found in '. $file);
              }
	    }


	    /**
	     * Load main helpers file 
	     * 
	     * @return void
	    */
	    private function loadHelpers()
	    {
	    	  foreach (glob(ROOT . 'vendor' . DS . 'NPD' . DS . 'Helpers' . DS .'*.php') as $file)
	    	  {
	    	  	   require $file;
	    	  }
	    }

        
        /**
         * get the required class from the object container
         * 
         * @param $class
         * @return mixed
        */
        public function call($class)
        {

        	// if class object not in the object container then create a new object
            if(!$this->has($class))
            {
            	 if(in_array($class, $this->specials))
            	 {
            	 	   $method = 'register' . ucfirst($class);
            	 	   $this->{$method}();

            	 }else{
                      
                      $this->register($class);
            	 }
            }

            return $this->objects[$class];
        }



        /**
	     * Determine wither the object container has the given class name
	     * 
	     * @param $class
	     * @return bool
	    */
	    public function has($class)
	    {
            return isset($this->objects[$class]);
	    }

	    /**
	     * Set an object to object container
	     *
	     * @param string $key
	     * @param mixed $value
	     * @return void 
	    */
	    public function __set($key, $value)
	    {
	    	 $this->register($key, $value);
	    }
        

        /**
         * get the required class from the object container
         * 
         * @param string $key
         * @return mixed
        */
	    public function __get($key)
	    {
             return $this->call($key);
	    }


	   /**
	     * Register an object to object container
	     *
	     * @param string $class
	     * @param mixed $value
	     * @return void 
	    */
        public function register($class, $value = null)
        {
              if(is_null($value))
              {
              	  $fullClassName = 'NPD\\' . ucfirst($class);
              	  $value = new $fullClassName();

              }elseif($value instanceof  Closure){
                 
                  $value = $this->executeCall($value);

              }

              $this->objects[$class] = $value;
        }

        
        /**
         * Execute a callable function
         * 
         * @param callable $callable
         * @return mixed
        */
        private function executeCall(callable $callable)
        {
             return call_user_func($callable, $this);
        }

}