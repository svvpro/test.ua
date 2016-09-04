<?php

/**
 * Created by PhpStorm.
 * User: SVV
 * Date: 04.09.2016
 * Time: 17:20
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $routsPath = ROOT.'\..\config\routs.php';
        $this->routes = include($routsPath);
    }

    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
             return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path){
//            echo "<br>$uriPattern -> $path ";
            if(preg_match("~$uriPattern~", $uri)){
                echo $path;
            }
        }
    }
}