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
		
		$menuType = new MenuType();
		$this->view->tree = $menuType->showTab();
    }
	public function createmenuAction()
	{

		$name       =  $this->request->get("name");
		$alias      =  $this->request->get("alias");
		$menu_type  =  $this->request->get("menu_type");
		
		if( $name && $alias)
		{
			$root   =  Menu::findFirst(1);
			$child        =  new Menu();
			$child->name  =  $name;
			$child->alias =  $alias;
			$child->menu_type =  intval($menu_type);
			$child->appendTo($root);
			$this->updateSlug();
			return $this->response->setJsonContent(array("status" => true,'id'=>$child->id));
		}
		return $this->response->setJsonContent(array("status" => false));
	}
	public function editmenuAction()
	{
		$id         =  $this->request->get("id");
		$name       =  $this->request->get("name");
		$alias      =  $this->request->get("alias");
		$item = Menu::findFirst($id);
		$item->name=$name;
		$item->alias=$alias;
		if($item->save())
		{
			$this->updateSlug();
			return $this->response->setJsonContent(array('status' => true));
		}
		return $this->response->setJsonContent(array('status' => false));
		//$menu_type  =  $this->request->get("menu_type");
	}
	
	public function deletemenuAction()
	{
		$id = $this->request->get('id','int');
		$menu = new Menu();	
		$item = $menu->findFirst($id);
		if($item->deleteNode())
		{
			$this->updateSlug();
			return $this->response->setJsonContent(array('status' => true));
		}	
		return $this->response->setJsonContent(array('status' => false));		
	}
	public function savemenuAction()
	{

		$pos = $this->request->get('pos');
		$des = $this->request->get('des','int');
		$id = $this->request->get('id','int');
		$menuType = $this->request->get('menu_type','int');
		$des = Menu::findFirst($des);
		$node = Menu::findFirst($id);
		$childs = $node->descendants();
		foreach($childs as $child)
		{
			$child->menu_type = $menuType;
			$child->save();
		}
		$node->menu_type = $menuType;
		$node->save();
		if($pos == 'append')
		{
			$node->moveAsFirst($des);
		}
		elseif($pos == 'insert')
		{
			$node->moveAfter($des);
		}
		$this->updateSlug();
	}
	public function showAction()
	{
		return $this->response->setJsonContent(Menu::find(['columns'=>'id,name,alias','order' => 'lft','conditions' => 'id>1']));
	}
	public function updateSlug()
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
				$item = Menu::findFirst($menu['id']);
				$item->slug = $prefix . '/' . $menu["alias"];
				$item->save();
			}else{
				$temp[]=array('alias'=>$menu["alias"]);
				$item = Menu::findFirst($menu['id']);
				$item->slug = $menu['alias'];
				$item->save();
			}
		}
	}
	public function createmenutypeAction()
	{
		
	}
	
	

	
}