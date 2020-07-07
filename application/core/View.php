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
    }

    public function render(string $title, array $vars = ['status' => ''])
    {
        extract($vars);
        $path = "application/views/$this->path.php";
        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once 'application/views/layouts/' . $this->layout . '.php';
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