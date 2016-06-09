<?php
namespace Bca\Modules\Main\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;
use Bca\Modules\Main\Models\Menu;
class IndexController extends Controller
{
	
	public function indexAction()
    {
		 echo "Main Module";
		echo "<h1>WELCOME TO MULTI MODULE DASHBOARD</h1>";
        echo $this->tag->linkTo("admin","Admin Dashboard");
		echo "<br>";
		echo $this->tag->linkTo("mobile","Mobile Dashboard");
		$home = array(
		"name" =>"Home",
		"alias" =>"home"
		);
		//$a = Menu::findFirst(6);
		//$b = Menu::findFirst(7);
		//$b->moveAsFirst($a);
		//$c = Menu::findFirst(8);
		//$c->moveAsFirst($b);
		//echo "<pre>";var_dump(Menu::find(['order' => 'lft'])->toArray());echo "</pre>";
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
		echo "<pre>";var_dump($temp);echo "</pre>";
		/*$sub_menu = new Menu();
		$sub_menu->name="phat sub 0";
		$sub = Menu::findFirst(6);
		$sub_menu->insertBefore($sub);*/
    }
	public function adminAction()
    {
		echo "Admin Action";
    }
	public function mainAction()
    {
		echo "Main Action";
    }
	public function cmsAction()
    {
		echo "CMS Action";
    }

	
}