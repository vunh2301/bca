<?php 
namespace Bca\Modules\Admin\Models;
use Bca\Modules\Admin\Models\MenuType;
class MenuType extends \Phalcon\Mvc\Model
{
	public function showTab()
	{
		$menuType = $this->find(['order' => 'sort']);
		$menu = new Menu();
		foreach($menuType as $key=>$item)
		{
			if($key==0)
			{
				$tab.='<li class="active"><a href="#ttab'.$item->id.'_nobg" data-toggle="tab">'.$item->name.'</a></li>';
				$tab_content.='<div id="ttab'.$item->id.'_nobg" class="tab-pane active">'.$menu->showTree($item->id).'</div>';
			}
			else
			{
				$tab.='<li class=""><a href="#ttab'.$item->id.'_nobg" data-toggle="tab">'.$item->name.'</a></li>';
				$tab_content.='<div id="ttab'.$item->id.'_nobg" class="tab-pane">'.$menu->showTree($item->id).'</div>';
			}
		}
		$html='<div class="panel-heading"><ul class="nav nav-tabs pull-left">'.$tab.'</ul></div><div class="panel-body"><div class="tab-content transparent">'.$tab_content.'</div></div>';
		return $html;
	}
}
