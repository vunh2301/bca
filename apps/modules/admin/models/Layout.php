<?php 
namespace Bca\Modules\Admin\Models;
use Bca\Modules\Admin\Models\Layout;
class Layout extends \Phalcon\Mvc\Model
{
	public function initialize()
	{
		$layout = $this->findFirst(1);
		$sections = Section::find();
		$html = $layout->htmlcode;
		foreach($sections as $section)
		{
			
			$html = str_replace('<'.$section->name.'/>',$section->htmlcode,$html);
		}
		$layout->htmlcode = $html;
		$layout->save();
	}
	public function getSelectOptions($id = 0)
	{
		$layouts = $this->find();
		foreach($layouts as $layout)
		{
			
			$html .='<option value="'.$layout->id.'"'.($id == $layout->id ? ' selected': ' ').'>'.$layout->name.'</option>';
			
		}
		
		return $html;
		
	}
	
}
