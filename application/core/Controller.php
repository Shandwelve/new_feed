<?php

namespace application\core;

use application\core\View;

abstract class Controller
{

    public array $route;
    protected object $view;
    protected object $model;

    public function __construct(array $route)
    {
        $this->route = $route;
        $path = 'application\models\\' . ucfirst($route['controller']);
        $this->view = new View($this->route);
        $this->model = new $path;
    }
}