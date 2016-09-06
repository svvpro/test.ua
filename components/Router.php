<?php

/**
 * Created by PhpStorm.
 * User: SVV
 * Date: 06.09.2016
 * Time: 21:19
 */
class Routs
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'\..\config\routs.php';
        $this->routes = include($routesPath);
    }

    private function getUri()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
           return trim($_SERVER['REQUEST_URI'],'/');
        }
    }

    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path){
            if(preg_match("~$uriPattern~", $uri)){
                $segments = explode('/', $path);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $controllerFile = ROOT.'/../controllers/'.$controllerName.'.php';

                if(file_exists($controllerFile))
                {
                    require_once ($controllerFile);
                }

                $controllerObject = new $controllerName();
                $result = $controllerObject->$actionName();
                if($result != null){
                    break;
                }

            }
        }
    }

}