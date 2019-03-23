<?php 
namespace Frontend\Main;

use Controller; // alias of NPD\Routing\Controller [use NPD\Routing\Controller]


/**
 * site.com/ or site.com/home
 * on peut ecrire namespace frontend\main ou frontend\controller\main
*/
class HomeController extends Controller
{

        public function index()
        {
        	  // echo $this->request->method();
              return '<br>home page';
        }


        public function test($arg1)
        {
        	  return 'test method <strong>'. $arg1 .'</strong><br>';
        }

        /* 
         Exemple Not callable from public because is private
         private function test()
         {
        	  return 'test method <br>';
         }
       */
}