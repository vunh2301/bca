<?php
namespace Bca\Modules\Admin\Controllers;
use Bca\Modules\Admin\Models\Layout;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class LayoutController extends Controller
{
	
	public function indexAction()
    {
		$layout =   new Layout();
		$this->view->listLayout = $layout->getSelectOptions(1);		
    }
	public function getpreviewAction($id=1)
	{
		switch($id)
		{
			case 1: $preview='<div style="background-color:#eee; height:200px; width:100%"><center>Header</center></div><div style="background-color:#eee; height:200px; width:100%; margin-top:20px;"><center>Body</center></div><div style="background-color:#eee; height:200px; width:100%; margin-top:20px;"><center>Footer</center></div>';
			return $preview;
			case 2: $preview='<div style="background-color:#aaa; height:200px; width:100%"><center>Header</center></div><div style="background-color:#aaa; height:200px; width:100%; margin-top:20px;"><center>Body</center></div><div style="background-color:#aaa; height:200px; width:100%; margin-top:20px;"><center>Footer</center></div>';
			return $preview;
			case 3: $preview='<div style="background-color:#666; height:200px; width:100%"><center>Header</center></div><div style="background-color:#666; height:200px; width:100%; margin-top:20px;"><center>Body</center></div><div style="background-color:#666; height:200px; width:100%; margin-top:20px;"><center>Footer</center></div>';
			return $preview;		
		}
	}
}