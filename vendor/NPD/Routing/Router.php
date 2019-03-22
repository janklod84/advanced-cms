<?php 
namespace NPD\Routing;

use Closure;
use NPD\Request;


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
	      * container of controller names
	      * that will be loaded before | after main route loads
	      * 
	      * @var array 
	     */
	     private $calls = [];


	     /**
	      * Request Object 
	      * @var Request
	     */
	     private $request;


	     /**
	      * pointer to not found page
	      * 
	      * @var Route
	     */
	     private $notFound;

         
         /**
          * Cosntructor Route
          * @param Request $request 
          * @return void
          */
	     public function __construct(Request $request)
	     {
	     	    $this->request = $request;
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

                   pre($route);
                   
              }else{

             	  // not found
              	  $route = $this->notFound();
              	  // redirect to not found page
              }
         }
}