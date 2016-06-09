<?php
namespace Bca\Libraries\Db\Model;
use Phalcon\Mvc\Model;
class Menu extends Model
{
	public function printd()
	{
		$array = self::find(['order' => 'lft'])->toArray();
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
	}
	
}