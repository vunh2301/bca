<?php
namespace Bca\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class IndexController extends Controller
{
	
	public function indexAction()
    {
		 echo "Admin Module";
		echo "<h1>WELCOME TO MULTI MODULE DASHBOARD</h1>";
        echo $this->tag->linkTo("admin","Admin Dashboard");
		echo "<br>";
		echo $this->tag->linkTo("mobile","Mobile Dashboard");
    }
	public function showAction($id)
    {
		$this->view->setMainView('master');
		 $this->view->phat = $id;
		
    }
	
}