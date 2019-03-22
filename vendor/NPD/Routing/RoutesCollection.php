<?php 
namespace NPD\Routing;


class RoutesCollection
{

	   /**
	    * @var array
	   */
	   private $routes = [];


       /**
        * the route object that will be used for the current route path 
        *
        * @var Route
       */
       private $route;



       /**
        * store route object
        * @param Route $route 
        * @return type
        */
	   public function store(Route $route)
	   {
	   	     $pattern = $route->getPattern();

	   	     if($this->has($pattern))
	   	     {
	   	     	  die($route->getPath() . ' is already used in another controller');

	   	     }else{
                    
                  $this->routes[$pattern] = $route;
	   	     }
	   }

       /**
        * Determine wether pattern has in route
        * 
        * @param string $pattern 
        * @return bool
        */
	   public function has($pattern)
	   {
	   	     return (bool) isset($this->routes[$pattern]);
	   }

	   /**
	    * get all routes
	    * 
	    * @return array
	   */
	   public function all()
	   {
	   	   return $this->routes;
	   }


	   /**
	    * determine wether the given route is in our route collection
	    * determine if current route match route colection
	    * 
	    * get the arguments from the route
  	    * echo $routePath;
  	    * echo $route->getFilteredRoute();
	    * @param string $routePath
	    * @return mixed
	   */
	   public function equalTo($routePath)
	   {
	   	    // pre($this->routes);

	   	    foreach($this->routes as $pattern => $route)
	   	    {
	   	    	  if(preg_match($pattern, $routePath, $matches))
	   	    	  {
	   	    	  	    $routePath = $matches[0];
                        $arguments = trim(str_replace($route->getFilteredRoute(), '', $routePath), '/');
                        
                        $arguments = explode('/', $arguments);
                        $route->arguments($arguments);
                        $this->route = $route;
                        return true;
	   	    	  }
	   	    }

	   	    return false;
	   }


	   public function getRouteObject()
	   {
	   	    return $this->route;
	   }

}