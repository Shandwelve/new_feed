<?php


namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function checkExistence(string $username, string $password): bool
    {
        $hash = $this->dataBase->column("
                SELECT
                    password 
                FROM 
                    account 
                WHERE 
                    username = :username",
                [
                    'username' => $username
                ]
        );

      return password_verify($password, $hash);

    }

    public function getUserData(string $username): array
    {
        return $this->dataBase->row("
                SELECT 
                    id, role, username, email, first_name, last_name
                FROM 
                    account 
                WHERE 
                    username = :username",
                [
                    'username' => $username
                ]
        );
    }

    public function validateData(array $data): ?string
    {
        $errors = [];

        if (empty($data['first_name'])) {
            $errors[] = 'Please enter first name!';
        }
        if (empty($data['last_name'])) {
            $errors[] = 'Please enter last name!';
        }
        if (empty($data['username'])) {
            $errors[] = 'Please enter username!';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }
        if (empty($data['password'])) {
            $errors[] = 'Please enter password!';
        }
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Password does not match!';
        }
        if (!empty($this->dataBase->column("SELECT id FROM Account WHERE username = :username",
            ['username' => $data['username']]))) {
            $errors[] = 'Username is already busy!';
        }
        if (!empty($this->dataBase->column("SELECT id FROM Account WHERE email = :email",
            ['email' => $data['email']]))) {
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

    public function createAccount(array $data): int
    {
        $this->dataBase->query("
        INSERT 
            account 
        SET
            first_name = :first_name, last_name = :last_name, username = :username, email = :email, password = :password",
            $data
        );

        return $this->dataBase->lastInsertId();
    }
}