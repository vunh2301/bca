<?php
namespace Bca\Modules\Admin\Controllers;
use Bca\Modules\Admin\Models\Menu;
use Bca\Modules\Admin\Models\MenuType;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class MenuController extends Controller
{
	
	public function indexAction()
    {
		

		/*if(Menu::findFirst(1)==null)
		{
			$root =  new Menu();
			$root->name="Menu";
			$root->alias="menu";
			$root->saveNode();
			
			$root = Menu::findFirst(1);
			$item1 = new Menu();
			$item1->name  = "Tin tức";
			$item1->alias = "tin-tuc";
			
			$item2 = new Menu();
			$item2->name  = "Thời sự";
			$item2->alias = "thoi-su";
			$item1->appendTo($root);
			$item2->insertAfter($item1);
		}
		$array = Menu::find(['order' => 'lft'])->toArray();
		$temp="";
		$alias ="";
		foreach($array as $menu)
		{
			$alias[$menu["level"] - 1] = $menu["alias"];
			if($menu["level"] > 1){
				$prefix = '';
				foreach($alias as $index => $value){
					$prefix .= '/' . $value;
					if($index >= $menu["level"] - 2)break;
				}
				$temp[]=array('alias'=>$prefix . '/' . $menu["alias"]);
			}else{
				$temp[]=array('alias'=>$menu["alias"]);
			}
		}*/
		//$menu = new Menu();
		$menuType = new MenuType();
		$this->view->tree = $menuType->showTab();
    }
	public function createAction()
	{
		$post  =  $this->request->getPost();
		$name  =  $post["name"];
		$alias =  $post["alias"];
		$slug  =  $post["slug"];
		
		if(isset($post["id"]))
		{
			$parentid     =  $post["id"];
			$root         =  Menu::findFirst($parentid);
			$child        =  new Menu();
			$child->name  =  $name;
			$child->alias =  $alias;
			$child->appendTo($root);
		}
	}
	public function afterSave()
	{
		$array = Menu::find(['order' => 'lft'])->toArray();
		$temp="";
		$alias ="";
		foreach($array as $menu)
		{
			$alias[$menu["level"] - 1] = $menu["alias"];
			if($menu["level"] > 1){
				$prefix = '';
				foreach($alias as $index => $value){
					$prefix .= '/' . $value;
					if($index >= $menu["level"] - 2)break;
				}
				$temp[]=array('alias'=>$prefix . '/' . $menu["alias"]);
			}else{
				$temp[]=array('alias'=>$menu["alias"]);
			}
		}
	}
	public function editAction($id)
	{
		
		
	}
	
	public function deleteAction($id)
	{
		$menu = new Menu();	
		$item = $menu->findFirst($id);
		if($item->deleteNode()===true)
		{
			$this->dispatcher->forward(
				array(
					"controller" => "menu",
					"action"     => "index"
				)
			);
		}			
	}
	public function saveAction()
	{
		$pos = $this->request->get('pos');
		$des = $this->request->get('des','int');
		$id = $this->request->get('id','int');
		$des = Menu::findFirst($des);
		$node = Menu::findFirst($id);
		
		//Menu::findFirst(5)->moveAfter(Menu::findFirst(7));
		//die();
		if($pos == 'append')
		{
			$node->moveAsFirst($des);
		}
		elseif($pos == 'insert')
		{
			$node->moveAfter($des);
		}
	}
	
	

	
}