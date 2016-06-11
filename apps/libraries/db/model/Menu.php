<?php
namespace Bca\Libraries\Db\Model;
use Phalcon\Mvc\Model;
class Menu extends Model
{
	public function getParams()
	{
		return json_decode($this->params,true);
		
	}
	public function showAlias()
	{
		$array = self::find(['order' => 'lft'])->toArray();
		$temp="";
		$alias ="";
		foreach($array as $menu)
		{
			$slug = self::findFirst($menu['id']);
			$alias[$menu["level"] - 1] = $menu["alias"];
			if($menu["level"] > 1){
				$prefix = '';
				foreach($alias as $index => $value){
					$prefix .= '/' . $value;
					if($index >= $menu["level"] - 2)break;
				}
				$slug->slug = $prefix . '/' . $menu["alias"];
				//$temp[]=array('alias'=>$prefix . '/' . $menu["alias"]);
			}else{
				$slug->slug = '/' . $menu["alias"];
				//$temp[]=array('alias'=>'/'.$menu["alias"]);
			}
			$slug->save();
		}
		
		echo "<pre>";var_dump($temp);echo "</pre>";
	}
	
}