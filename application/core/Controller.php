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
        if (!isset($_SESSION['account'])) {
            $_SESSION['account'] = 'guest';
        }
        $this->route = $route;
        if ($this->checkAccess()) {
            $path = 'application\models\\' . ucfirst($route['controller']);
            $this->view = new View($this->route);
            $this->model = new $path;
        } else {
            View::errorCode(403);
        }
    }

    public function checkAccess(): bool
    {
        $access = require 'application/config/access.php';
        return in_array($this->route['action'], $access['all']) || in_array($this->route['action'],
                $access[$_SESSION['account']]);

    }
}
