<?php 
namespace Backend\Test;

use Controller; 

/**
 * edit site.com/admin/users/edit/12
 * 
*/
class TestController extends Controller
{

        public function edit($id)
        {
              return 'text in backend with id = ' . $id;
        }
}