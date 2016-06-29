<?php 
namespace Bca\Modules\Admin\Models;
use Bca\Modules\Admin\Models\Menu;
class Menu extends \Phalcon\Mvc\Model
{
	public function initialize()
    {
        $this->addBehavior(new Nested([
            'rootAttribute'  => 'root',
            'leftAttribute'  => 'lft',
            'rightAttribute' => 'rgt',
            'levelAttribute' => 'level',
        ]));
    }
	public function showTree($typeId)
	{
		$tree = Menu::find(['order' => 'lft','conditions' => 'id>1 AND menuTypeId='.$typeId]);
		$current_depth = 0;
		$counter = 0;
		$result = '';
		foreach($tree as $node){
			$node_depth = $node->level;
			$node_name = $node->name;
			$node_id = $node->id;
			$node_alias = $node->alias;
			if($node_depth == $current_depth){
				if($counter > 0) $result .= '</li>';            
			}
			elseif($node_depth > $current_depth){
				$result .= '<ol class="dd-list">';
				$current_depth = $current_depth + ($node_depth - $current_depth);
			}
			elseif($node_depth < $current_depth){
				$result .= str_repeat('</li></ol>',$current_depth - $node_depth).'</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$result .= '<li class="dd-item" data-id="'.$node_id.'" data-alias="'.$node_alias.'">';
			$result .= '<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true" style="cursor:pointer;margin-top:10px;margin-right:10px;"></span><span class="glyphicon glyphicon-edit pull-right" aria-hidden="true" style="cursor:pointer;margin-top:10px;margin-right:10px;"></span><div class="dd-handle">'.$node_name.'</div>';
			++$counter;
		}
		$result .= str_repeat('</li></ol>',$node_depth).'</ol></li>';
		$result= '<div class="dd" data-id="1">' . ($tree->count() > 0 ? $result : '<div class="dd-empty"></div>') . "</div>";
		return $result;
		
	}
}
