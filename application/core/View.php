<?php

namespace application\core;

class View
{
    private string $path;
    private array $route;
    public string $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
        ob_start();
    }

    public function render(string $title)
    {
        $content = ob_get_clean();
        require_once 'application/views/layouts/' . $this->layout . '.php';
    }

    public function addComponent(array $vars = [], string $component = '')
    {
        extract($vars);
        if (empty($component)) {
            $path = "application/views/$this->path.php";
        } else {
            $path = "application/views/components/$component.php";
        }
        if (file_exists($path)) {
            require_once $path;
        }
    }

    static public function errorCode(int $value)
    {
        http_response_code($value);
        require_once 'application/views/errors/' . $value . '.php';
        die();
    }

    public function redirect(string $url)
    {
        header('location: /' . $url);
        die();
    }
}