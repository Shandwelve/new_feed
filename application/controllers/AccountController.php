<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

class AccountController extends Controller
{
    public function signin()
    {
        if (empty($_POST)) {
            $this->view->render('Signin', ['status' => 'Signin']);
        }
        else {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->model->checkExistence($username, $password)) {
                $_SESSION['account'] = $this->model->getRole($username);
                $_SESSION['username'] = $username;
                $this->view->redirect('');
            } else {
                $this->view->render('Signin', ['status' => 'Invalid username or password!']);
            }
        }
    }

    public function signup()
    {
        if (empty($_POST)) {
            $this->view->render('Signup', ['status' => 'Register']);
        }
        else {
            $data = [
                'first_name'       => $_POST['first_name'],
                'last_name'        => $_POST['last_name'],
                'username'         => $_POST['username'],
                'email'            => $_POST['email'],
                'password'         => $_POST['password'],
                'confirm_password' => $_POST['confirm']
            ];
            $errors = $this->model->validateData($data);
            if (empty($errors)) {
                $data['password'] = $this->model->passwordHash($data['password']);
                unset($data['confirm_password']);
                $this->model->createAccount($data);
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['account'] = 'user';
                $this->view->redirect('');
            } else {
                $this->view->render('Signup', ['status' => $errors]);
            }
        }

    }

    public function signout()
    {
        $_SESSION['account'] = 'all';
        unset($_SESSION['username']);
        $this->view->redirect('');
    }
}