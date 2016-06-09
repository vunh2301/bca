<?php
use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config\Adapter\Ini as ConfigIni;
class AppBootstrap extends Application
{
	public $di;
	
	function initConfig($di)
	{
		$di->set('config',function(){
			return new ConfigIni(ROOT_PATH . '/apps/configs/config.ini');
		});
	}
	function getDi()
	{
		if($this->di!=null)
		{
			return $di;
		}
		return new FactoryDefault();
	}
	function initDb($di)
	{
		$config = $di->get("config");
		$di->set('db', function () use ($config) {
			return new DbAdapter($config->database->toArray());
		});
	}
	function initRouter($di)
	{
		$di->set('router', function () {
			$router = new Router();
			$router->setDefaultModule("main");
			return $router;
		});	
		
	}
	function initModules($params)
	{
		$array_modules = array();
		foreach($params as $module)
		{
			
			if(file_exists("../apps/modules/".$module."/Bootstrap.php"))
			{
			// Register the installed modules
				$array_modules[$module]= array(
					'className' => "Bca\Modules\\".ucfirst($module)."\Bootstrap",
					'path'      => '../apps/modules/'.$module.'/Bootstrap.php',
					);
			}
			
		}
		$this->registerModules($array_modules);
	}
	function initLoader($di)
	{
		$loader = new Loader();
			$loader->registerNamespaces(
				array(
					"Bca\Libraries" => ROOT_PATH."/apps/libraries",
					"Bca\Modules" => ROOT_PATH."/apps/modules"
				)
			);
			$loader->register();
		$di->set('loader',$loader);
	}
	function __construct()
	{
		$modules = array("main","admin","cms");
		//$some = new Bca\Libraries\Db\Model\Nested();
		$di = $this->getDi();
		$this->initConfig($di);
		$this->initLoader($di);
		// init database
		$this->initDb($di);
		$menu = new Bca\Libraries\Db\Model\Menu();
		$menu->printd();
		// init Router
		$this->initRouter($di);
		// checked modules
		$this->initModules($modules);
	return parent::__construct($di);
}
	
}