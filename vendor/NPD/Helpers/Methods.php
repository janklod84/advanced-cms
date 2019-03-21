<?php 

if(!function_exists('app'))
{

	  /**
	   * get the object of the given key
	   * otherwise return application object
	   * 
	   * @param mixed $key
	   * @return mixed
	  */
	  function app($class = null)
	  {
	  	  global $app;

	  	  if(!is_null($class))
	  	  {
	  	  	  return app()->call($class);
	  	  }

	  	  return $app;
	  }

}