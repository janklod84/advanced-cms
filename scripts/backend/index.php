<?php 

$router = app('route');


// sitename.com/test
$router->get(function($route){
	$route->path('users/edit/{id}');
	$route->controller('test/test');
	$route->method('edit');
    return $route;
});


$router->notFound('not-found', 'error/not-found');