<?php
use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Bca\Libraries\Db\Model;
use Phalcon\Mvc\Router\Group as RouterGroup;
use Phalcon\Mvc\Url as UrlProvider;
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
			return new DbAdapter(array_merge(array("options" => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )),$config->database->toArray()));
		});
	}
	function initRouter($di)
	{
		$di->set('router', function () {
			$menu = new Model\Menu();
			$router = new Router();
			$array = $menu::find(['order' => 'lft']);
			// default value module
			$admin = new RouterGroup(array('module' => 'admin'));
			$admin->setPrefix('/admin');
			$admin->add("", array(
				'controller' => 'index',
				'action' => 'index'
			));
			$admin->add("/:controller", array(
				'controller' => 1,
				'action' => 'index'
			));
			$admin->add("/:controller/:action", array(
				'controller' => 1,
				'action' => 2
			));
			$admin->add("/:controller/:action/:params", array(
				'controller' => 1,
				'action' => 2,
				'params' => 3
			));
			$router->mount($admin);
			/*$router->add(
					'/admin',
					array(						
						'module' 		=> 'admin',
						'controller' 	=> 'index',
						'action' 		=> 'index'
					)
			);
			$router->add(
					'/admin/:controller',
					array(						
						'module' 		=> 'admin',
						'controller' 	=> 1,
						'action' 		=> 'index'
					)
			);
			$router->add(
					'/admin/:controller/:action/:params',
					array(						
						'module' 		=> 'admin',
						'controller' 	=> 1,
						'action' 		=> 2,
						'params' 		=> 3,
					)
			);*/

			/*foreach($array as $menu)
			{
				// /blog
				$router->add($menu->slug, array_merge($menu->toArray(),array(
					'module'     => 'main',
					'controller' => $menu->controller,
					'action'     => $menu->action
				)));
				/ /blog/the-thao
				$group = new RouterGroup(
					array(
						'module'     => 'main',
						'controller' => $menu->controller,
					)
				);
				$group ->setPrefix($menu->slug);
				$group->add(
					'/{cid:[a-z\-]+}',
					array(
						'controller' => 'index',
						'action'     => 'content'
					)
				)->convert('cid', function ($cid) {
					if($cid == 'eu') return 5;
				});
				$router->mount($group);

			}*/
			$router->removeExtraSlashes(true);
			$router->setDefaultModule("admin");
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
		/*$di->set('url', function () {
			$url = new UrlProvider();
			$url->setBaseUri('/bca/');
			return $url;
		});*/
		$this->initConfig($di);
		$this->initLoader($di);
		// init database
		$this->initDb($di);
		// init Router
		$this->initRouter($di);
		// checked modules
		$this->initModules($modules);
		
	return parent::__construct($di);
}
	
}