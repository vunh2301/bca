<?php
namespace Bca\Modules\Admin\Controllers;
use Bca\Modules\Admin\Models\Layout;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class SiteController extends Controller
{
	
	public function indexAction()
    {
	
    }
	public function editAction()
    {
		$this->view->setMainView('../edit');
    }
	
}