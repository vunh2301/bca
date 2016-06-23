<?php

namespace Bca\Modules\Admin;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Bootstrap implements ModuleDefinitionInterface
{
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Bca\Modules\Admin\Controllers' => '../apps/modules/admin/controllers/',
                'Bca\Modules\Admin\Models'      => '../apps/modules/admin/models/',
            )
        );

        $loader->register();
    }
	

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Bca\Modules\Admin\Controllers");
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../apps/modules/admin/views/');
			$view->setLayoutsDir('/');
			$view->setMainView('../master');
            return $view;
        });
    }
}