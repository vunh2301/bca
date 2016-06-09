<?php
namespace App\Mobile\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo "<h1>WELCOME TO MOBILE DASHBOARD</h1>";
    }
}