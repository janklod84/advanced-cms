<?php 
namespace NPD\Routing;

use Closure;
use NPD\Http\Request;
use NPD\Loader;

class Router
{
     
     /**
	     * current route of the request
	     * @var string
	    */
	    private $currentRoute;


	     /**
	      * collection of accepted routes
	      * 
	      * @var RoutesCollection
	     */
	     private $routeCollection;

       
       /**
          * pointer to not found page
          * 
          * @var Route
       */
       private $notFound;

       /**
        * The data comming the controller method
        * 
        * @var string
       */
       private $data;



	     /**
	      * Request Object 
	      * @var NPD\Http\Request
	     */
	     private $request;


  	   /**
        * Loader Object
        * 
        * @var NPD\Loader
       */ 
       private $load;


         
       /**
        * Cosntructor Route
        * @param NPD\Http\Request $request 
        * @return void
       */
	     public function __construct(Request $request, Loader $loader)
	     {
	     	     $this->request = $request;
             $this->load    = $loader;
	     	     $this->routeCollection  = new RoutesCollection();
	     }

         
         /**
          * add new GET route to routes collection 
          * 
          * @param mixed $path
          * @param mixed $controller
          * @return void
         */
         public function get($path, $controller = false)
         {
         	   $this->addNewRoute($path, $controller, 'GET');
         }


         /**
          * add new POST route to routes collection 
          * 
          * @param mixed $path
          * @param mixed $controller
          * @return void
         */
         public function post($path, $controller = false)
         {
         	   $this->addNewRoute($path, $controller, 'POST');
         }

         
         /**
          * Set Not found page controller or method
          * 
          * @param type $path 
          * @param type $controller 
          * @param type|string $method 
          * @return type
          */
         public function notFound($path, $controller, $method = 'index')
         {
         	    $route = new Route();
         	    $route->path($path);
         	    $route->controller($controller);
         	    $route->method($method);
         	    $this->notFound = $route;
         	    $this->routeCollection->store($route);
         }


         /**
          * add new route to routes collection 
          * 
          * @param string $routePath
          * @param string $action
          * @param string $requestMethod
          * @return void
         */
         private function addNewRoute($routePath, $action = false, $requestMethod = 'GET')
         {
                $route = new Route();

                if($routePath instanceof Closure)
                {
                    $routeObject = call_user_func($routePath, $route);
                    $routeObject->requestMethod($requestMethod);

                    if($routeObject->pathsIsNotEmpty())
                    {
                    	   foreach($routeObject->getPaths() as $path)
                    	   {
                    	   	    $route = new Route();
                    	   	    $routeObject->copyTo($route);
                    	   	    $route->path($path);
                    	   	    $this->routeCollection->store($route);
                    	   }

                     } else {

                     	   $this->routeCollection->store($routeObject);
                     }

                }else{

                	   // shorthand method
                	   if(strpos($action, '@') !== false)
                	   {
                	   	   list($controller, $method) = explode('@', $action);

                	   }else{

                	   	     $controller = $action;
                	   	     $method     =  'index';
                	   }
                       
                       $route->path($routePath);
                	     $route->controller($controller);
                	     $route->method($method);
                	     $this->routeCollection->store($route);
                }
         }


         public function build()
         {
              if(!$this->notFound)
              {
              	  die('Please assign a not found page ');
              }

              $currentRoute = implode('/', $this->request->getRoute()) . '/';
              
              if($this->routeCollection->equalTo($currentRoute))
              {
                   $route = $this->routeCollection->getRouteObject();

                   if($route->getRequestMethod() != $this->request->method())
                   {
                   	    // redirect to not found page

                   } else {
                        
                        $controller = $route->getController();
                        $method     = $route->getMethod();
                        $arguments  = $route->getArguments();
                        $this->data = $this->load->controller($controller, $method, $arguments);
                        echo $this->data;
                   }

              }else{

             	    // not found
              	  $route = $this->notFound; // pre($route);
              	  // redirect to not found page
              }
         }
}