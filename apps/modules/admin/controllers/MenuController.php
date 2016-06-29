<?php
namespace Bca\Modules\Admin\Controllers;
use Bca\Modules\Admin\Models\Menu;
use Bca\Modules\Admin\Models\MenuType;
use Bca\Modules\Admin\Models\Layout;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class MenuController extends Controller
{
	
	public function indexAction()
    {
		$menuType = new MenuType();
		$layout =   new Layout();
		$this->view->tree = $menuType->showTab();
		$this->view->listLayout = $layout->getSelectOptions(1);
    }
	public function createmenuAction()
	{
		$name       =  $this->request->get("name");
		$alias      =  $this->request->get("alias");
		$menuTypeId  =  $this->request->get("menuTypeId");
		$layoutId  =  $this->request->get("layoutId");
		
		if( $name && $alias)
		{
			$root   =  Menu::findFirst(1);
			$child        =  new Menu();
			$child->name  =  $name;
			$child->alias =  $alias;
			$child->menuTypeId =  intval($menuTypeId);
			$child->layoutId =  intval($layoutId);
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
		$menuType = $this->request->get('menuTypeId','int');
		$des = Menu::findFirst($des);
		$node = Menu::findFirst($id);
		$childs = $node->descendants();
		foreach($childs as $child)
		{
			$child->menuTypeId = $menuType;
			$child->save();
		}
		$node->menuTypeId = $menuType;
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
		$name = $this->request->get('name');
		$sort = $this->request->get('sort','int');
		$menuType = new MenuType();
		if($name && $sort)
		{
			$menuType->name = $name;
			$menuType->sort = $sort;
			if($menuType->save())
			{
				return $this->response->setJsonContent(array('status' => true,'id'=> $menuType->id));		
			}
		}
		return $this->response->setJsonContent(array('status' => false));
		
	}
	public function deletemenutypeAction()
	{
		$id = $this->request->get('id','int');
		$menuType = new MenuType();	
		$item = $menuType->findFirst($id);
		$children = Menu::find('menuTypeId='.$item->id);
		//Echo '<pre>';var_dump($children->toArray());Echo '</pre>';die();
		if($item->delete())
		{
			foreach($children as $child)
				{
					$child->deleteNode();
				}
			return $this->response->setJsonContent(array('status' => true));
		}	
		return $this->response->setJsonContent(array('status' => false));
		
	}
	

	
}