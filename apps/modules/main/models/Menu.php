<?php 
namespace Bca\Modules\Main\Models;
use Bca\Modules\Main\Models;
class Menu extends \Phalcon\Mvc\Model
{
	public function initialize()
    {
        $this->addBehavior(new Nested([
            'rootAttribute'  => 'root',
            'leftAttribute'  => 'lft',
            'rightAttribute' => 'rgt',
            'levelAttribute' => 'level'
        ]));
    }
}
