<?php 

$router = app('route');


// sitename.com/test
$router->get(function($route){
	$route->path('test/{title}');
	$route->controller('test/test');
	$route->method('testMethod');
    return $route;
});



// sitename.com/test
$router->get(function($route){
	$route->paths('/', 'home');
	$route->controller('main/home');
    return $route;
});


$router->notFound('404', 'error/not-found');