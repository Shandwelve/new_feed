<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

class AccountController extends Controller
{
    public function signin()
    {
        $username = 'Test';
        $password = 'test';

        if ($this->model->checkExistence($username, $password)) {
            $_SESSION['account'] = $this->model->getRole($username);
            var_dump($_SESSION['account']);
            echo 'Welcome ' . $username;
        } else {
            echo 'Signin Error';
        }
    }

    public function signup()
    {
        $first_name = 'Test';
        $last_name = 'Test';
        $username = 'Test';
        $email = 'test@gmail.com';
        $password = 'test';
        $confirm_password = 'test';
        $data = [
            'first_name'       => $first_name,
            'last_name'        => $last_name,
            'username'         => $username,
            'email'            => $email,
            'password'         => $password,
            'confirm_password' => $confirm_password
        ];
        $errors = $this->model->validateData($data);
        if (empty($errors)) {
            $data['password'] = $this->model->passwordHash($data['password']);
            unset($data['confirm_password']);
            echo 'Success';
            $this->model->createAccount($data);
        } else {
            echo $errors;
        }
    }
}