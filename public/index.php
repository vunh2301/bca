<?php
//define env & default path
define('APPLICATION_STAGE_DEVELOPMENT', 'development');
define('APPLICATION_STAGE_PRODUCTION', 'production');
define('APPLICATION_STAGE', (getenv('PHALCONEYE_STAGE') ? getenv('PHALCONEYE_STAGE') : APPLICATION_STAGE_PRODUCTION));
define('DS', DIRECTORY_SEPARATOR);
// Type application is a development will display error
if (APPLICATION_STAGE == APPLICATION_STAGE_DEVELOPMENT) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
// Physical file path
if (!defined('ROOT_PATH')) {
	define('ROOT_PATH', dirname(dirname(__FILE__)));
}
if (!defined('PUBLIC_PATH')) {
	define('PUBLIC_PATH', dirname(__FILE__));
}

require_once(ROOT_PATH."/apps/AppBootstrap.php");
$bootstrap = new AppBootstrap();
echo $bootstrap->handle()->getContent();

