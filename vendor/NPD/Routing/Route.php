<?php 
namespace NPD\Routing;


class Route
{
        
         /**
          * the path of the route
          * 
          * i.e posts/{post-title}
          * @var string
         */
         private $path;


         /**
          * the path of the route without arguments
          * 
          * @var string
         */
         private $filteredRoute;


         /**
          * set multi paths for one controller
          * 
          * @var array 
         */
         private $paths = [];


         /**
          * controller name
          * 
          * @var string 
         */
         private $controller;


         /**
          * method name that will be used with controller
          * 
          * @var string 
         */
         private $method = 'index';


         /**
          * the arguments of the method 
          * 
          * @var array
         */
         private $args = [];



         /**
          * the request method that user should access with its given type
          * it will be POST OR GET OR AJAX
         */
         private $requestMethod = 'GET';



         /**
          * set the path of controller file
          * 
          * @var string
         */
         private $file;


         /**
          * the pattern of the route path
          * 
          * @var string
          */
          private $pattern;


          /**
           * pattern of numbers validation
           * {id}
           * 
           * @var string
          */
          private $idPattern = '\d+/';


          /**
           * pattern of string validation
           * {title}
           * 
           * @var string
          */
          private $titlePattern = '[a-zA-Z0-9-_+]+/';

          
         /**
          * add path for one controller
          * 
          * @param string $path 
          * @return void
         */
         public function path($path)
         {
              $this->path = $path;

              // create the pattern of the path
              $this->setPattern($path);
         }
         
         /**
          * add multi paths for one controller
          * 
          * @param array $paths
          * @return void
          * 
          * paths(array $paths = [])
          * {
          *    $this->paths = is_array($paths) ? $paths : func_get_args();
          * }
         */
         public function paths($paths = [])
         {
               $this->paths = is_array($paths) ? $paths : func_get_args();
         }
         
         /**
          * set the the controller name
          * and create the file path for that controller
          * 
          * @param string $controller
          * @return void
         */
         public function controller($controller)
         {
              $this->file = $this->controller = $controller;
         }
         
         /**
          * set the method for the controller
          * 
          * @param string $method
          * @return void
         */
         public function method($method)
         {
              $this->method = $method;
         }

         
          /**
          * set the request method that user should be accessing this route with
          * i.e GET | POST
          * 
          * @param string $requestMethod
          * @return void
         */
         public function requestMethod($requestMethod)
         {
               $this->requestMethod = $requestMethod;
         }

        
        
         
         /**
          * get the path of the route
          * 
          * @return string
         */
         public function getPath()
         {
              return $this->path;
         }
         
         /**
          * get all paths that will be used for the route controller
          * 
          * @return array
         */
         public function getPaths()
         {
              return $this->paths;
         }

         
         /**
          * determine wether paths are not empty
          * 
          * @return bool
         */
         public function pathsIsNotEmpty()
         {
         	  return (bool) !empty($this->paths);
         }
         
         /**
          * get the the controller
          * 
          * 
          * @return string
         */
         public function getController()
         {
              return $this->controller;
         }
         

         /**
          * get the path of the controller file
          * 
          * 
          * @return string
         */
         public function getControllerPath()
         {
              return $this->file;
         }
         
         /**
          * get method of route
          * 
          * 
          * @return string
         */
         public function getMethod()
         {
               return $this->method;
         }


         public function arguments(array $arguments)
         {
               $this->args = $arguments;
         }
         
         /**
          * get the request method of route
          * 
          * 
          * @return string
         */
         public function getRequestMethod()
         {
              return $this->requestMethod;
         }

         /**
          * get the pattern of the route
          * 
          * @return string
         */
         public function getPattern()
         {
         	    return $this->pattern;
         }


         public function getFilteredRoute()
         {
              return $this->filteredRoute;
         }


         /**
          * copy the attributes of this route object to another route object
          * 
          * @param Route $route
          * @return void
          */
          public function copyTo(Route &$route)
          {
               $route->controller($this->controller);
               $route->method($this->method);
               $route->requestMethod($this->requestMethod);
          }
          
         
         /**
          * Create the pattern for the route
          * 
          * @param string $path 
          * @return void
        */
         private function setPattern($path)
         {

               $this->filteredRoute = $this->filterRoute($path);
               $this->filteredRoute = rtrim($this->filteredRoute, '/') . '/';

           	   $path = trim($path, '/');

           	   $segments = explode('/', $path);

           	  // prepare the pattern for the path
               $pattern = '#^';

       	       foreach((array) $segments as $segment)
       	       {
           	    	   if($segment == '{id}')
           	    	   {
           	    	   	    $pattern .= $this->idPattern;

           	    	   }elseif($segment == '{title}'){

           	    	   	     $pattern .= $this->titlePattern;

           	    	   }else{

           	    	   	     $pattern .= $segment . '/';
           	    	   }
           	    
       	       }
               
               // $pattern .=  rtrim($path, '/') . '/'; // #^posts/
               $pattern =  rtrim($pattern, '/') . '/'; // #^posts/
               $pattern .= '$#ui';
               
               $this->pattern = $pattern;
         }


         private function filterRoute($path)
         {
             return strpos($path, '{') !== false ? substr($path, 0, strpos($path, '{')) : $path;
         }

}