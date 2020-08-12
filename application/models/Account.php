<?php


namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function checkExistence(string $username, string $password): bool
    {
        $params = ['username' => $username];
        $hash = $this->dataBase->column("SELECT password FROM Account WHERE username = :username", $params);
        var_dump(password_verify($password, $hash));
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }

    public function getRole(string $username): string
    {
        $params = ['username' => $username];
        return $this->dataBase->column("SELECT role FROM Account WHERE username = :username", $params);
    }

    public function validateData(array $data): ?string
    {
        $errors = [];

        if (empty($data['first_name'])) {
            $errors[] = 'Pls enter first name!';
        }
        if (empty($data['last_name'])) {
            $errors[] = 'Pls enter last name!';
        }
        if (empty($data['username'])) {
            $errors[] = 'Pls enter username!';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }
        if (empty($data['password'])) {
            $errors[] = 'Pls enter password!';
        }
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Password does not match!';
        }
        if (!empty($this->dataBase->column("SELECT id FROM Account WHERE username = :username", ['username' => $data['username']]))){
            $errors[] = 'Username is already busy!';
        }
        if (!empty($this->dataBase->column("SELECT id FROM Account WHERE email = :email", ['email' => $data['email']]))){
            $errors[] = 'Email is already busy!';
        }

        if (!empty($errors)) {
            return $errors[0];
        }
        return null;
    }

    public function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function createAccount(array $data)
    {
        $this->dataBase->query('INSERT INTO Account (first_name, last_name, username, email, password) VALUES (:first_name, :last_name, :username, :email, :password)',
            $data);
    }
}