<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

class AccountController extends Controller
{
    public function signin()
    {
        if (empty($_POST)) {
            $this->view->addComponent(['status' => 'Signin']);
            $this->view->render('Signin');
            return;
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        if (!$this->model->checkExistence($username, $password)) {
            $this->view->addComponent(['status' => 'Invalid username or password!']);
            $this->view->render('Signin');
        }

        $account = $this->model->getUserData($username);
        $_SESSION['account'] = $account[0]['role'];
        $_SESSION['username'] = $account[0]['username'];
        $_SESSION['user_id'] = $account[0]['id'];
        $this->view->redirect('');
    }

    public function signup()
    {
        if (empty($_POST)) {
            $this->view->addComponent(['status' => 'Register']);
            $this->view->render(('Signup'));
            return;
        }

        $data = [
            'first_name'       => $_POST['first_name'],
            'last_name'        => $_POST['last_name'],
            'username'         => $_POST['username'],
            'email'            => $_POST['email'],
            'password'         => $_POST['password'],
            'confirm_password' => $_POST['confirm']
        ];

        $errors = $this->model->validateData($data);
        if (!empty($errors)) {
            $this->view->addComponent(['status' => $errors]);
            $this->view->render(('Signup'));
            return;
        }

        $data['password'] = $this->model->passwordHash($data['password']);
        unset($data['confirm_password']);
        $this->model->createAccount($data);
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['account'] = 'user';
        $this->view->redirect('');
    }

    public function signout()
    {
        $_SESSION['account'] = 'guest';
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        $this->view->redirect('');
    }
}