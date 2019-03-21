<?php 


// get the application class
require ROOT . 'vendor' . DS . 'NPD' . DS . 'Application.php';

// create a new object of application class
$app = new NPD\Application();


/*
$app->register('test', function($application) {
   return 'tested';
});


echo $app->test;
*/


// initialiaze main settings
$app->bootstrap();


