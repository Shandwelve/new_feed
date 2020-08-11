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
        $_SESSION['account'] = 'all';
        $this->route = $route;
        //      var_dump(password_hash('123', PASSWORD_BCRYPT ));
        if ($this->checkAccess()){
            $path = 'application\models\\' . ucfirst($route['controller']);
            $this->view = new View($this->route);
            $this->model = new $path;
        }
        else {
            View::errorCode(403);
        }
    }

    public function checkAccess():bool
    {
        $access = require 'application/config/access.php';
        if (in_array($this->route['action'] ,$access[$_SESSION['account']]) || in_array($this->route['action'] ,$access['all'])){
            return true;
        }
        return false;
    }
}
