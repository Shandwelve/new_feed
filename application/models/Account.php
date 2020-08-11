<?php


namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function checkExistence(string $username, string $password): bool
    {
        $params = ['username' => $username];
        $hash = $this->dataBase->column("SELECT password FROM Account WHERE username = :username", $params);
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
}