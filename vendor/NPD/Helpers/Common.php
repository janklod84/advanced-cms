<?php 

if(!function_exists('camel_case'))
{
       
        /**
         * convert string to be written in camel case
         * 
         * @param string $string
         * @param bool $upper_camel_case
         * @return string
         */
        function camel_case($string, $upper_camel_case = true)
        {
        	  if(strpos($string, '_') !== false)
        	  {
        	  	    $words = explode('_', $string);

        	  }elseif(strpos($string, '_') !== false){

                    $words = explode('-', $string);

        	  }else{

        	  	   return $upper_camel_case ? ucfirst($string) : lcfirst($string);
        	  }

        	  $words = array_map('ucfirst', $words);

        	  if(!$upper_camel_case)
        	  {
        	  	   // it means it will be lower camel case
        	  	   $words[0] = lcfirst($words[0]);
        	  }

        	  return implode('', $words);
        }

}



if(!function_exists('array_get'))
{
       /**
        * get a value from given array by key
        * otherwise return the default value
        * 
        * @param array $array
        * @param mixed $key
        * @param mixed $default
        * @return mixed
       */
	   function array_get($array, $key, $default = null)
	   {
	   	    if(!$key) return $default;
	   	    return isset($array[$key]) ? $array[$key] : $default;
	   }
}



if(!function_exists('pre'))
{

	   /**
	    * visualize the given array to be easy for reading on browser
	    * 
	    * @param mixed $array
	    * @param string $dump_mode
	    * @return void
	   */
	   function pre($array, $dump_mode = 'print')
	   {
	   	     echo '<pre>';
	   	     $dump_mode == 'print' ? print_r($array) : var_dump($array);
	   	     echo '</pre>';
	   }
}

