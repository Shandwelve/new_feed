<?php

namespace application\core;

use application\controllers\MainController;
use application\core\View;

class Router
{
    private array $routes = [];
    private array $params = [];

    public function __construct()
    {
        $arr = require_once 'application/config/routes.php';
        foreach ($arr as $key => $item) {
            $this->add($key, $item);
        }
    }

    private function add(string $route, array $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = "#^$route$#";
        $this->routes[$route] = $params;
    }

    private function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_numeric($match)) {
                        $match = (int)$match;
                    }
                    $params[$key] = $match;
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'];
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}