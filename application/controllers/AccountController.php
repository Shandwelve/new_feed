<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

class AccountController extends Controller
{
    public function signin()
    {
        $username = 'Admin';
        $password = '123
        
       ';
        if ($this->model->checkExistence($username, $password)) {
            $_SESSION['account'] = $this->model->getRole($username);
            var_dump($_SESSION['account']);
            echo 'Welcome '.$username;
        }
        else {
            echo 'Signin Error';
        }
    }

    public function signup()
    {
        if ($this->model->validateData()) {
            $this->model->createAccount();
        }
    }
}