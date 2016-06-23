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
			$active = $key==0?'active':'';
			$tab.='<li class="'.$active.'" data-id="'.$item->id.'"><a href="#ttab'.$item->id.'" data-toggle="tab" style="padding-left:30px;padding-right:30px;">'.$item->name.'</a></li>';
			$tab_content.='<div id="ttab'.$item->id.'" class="tab-pane '.$active.' ">'.$menu->showTree($item->id).'</div>';

		}
		$html='<div class="panel-heading"><ul class="nav nav-tabs pull-left">'.$tab.'</ul><ul class="nav nav-tabs pull-right"><li><span class="glyphicon glyphicon-plus size-20" style="padding:10px 15px 16px 15px; cursor:pointer;"></span></li></ul></div><div class="panel-body"><div class="tab-content transparent">'.$tab_content.'</div></div>';
		return $html;
	}
}
