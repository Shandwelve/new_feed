<?php


namespace application\models;

use application\core\Model;

class Like extends Model
{
    public function getAppreciationNumber(int $id, string $appreciation): int
    {
        $params = ['id' => $id, 'appreciation' => $appreciation];
        return $this->dataBase->column("SELECT count(id) FROM Likes WHERE appreciation = :appreciation and feed_id = :id",
            $params);
    }


    public function addAppreciation(int $id, string $appreciation)
    {
        $account_id = $this->dataBase->column("SELECT id FROM Account WHERE username = :username",
            ['username' => $_SESSION['username']]);
        $params = [
            'account_id'   => $account_id,
            'feed_id'      => $id,
            'appreciation' => $appreciation
        ];
        $this->changeAppreciation($account_id, $id);
        $this->dataBase->query("INSERT INTO Likes (account_id, feed_id, appreciation) VALUES(:account_id, :feed_id, :appreciation)",
            $params);
    }

    public function checkAppreciation(int $id, string $appreciation): string
    {
        $account_id = $this->dataBase->column("SELECT id FROM Account WHERE username = :username",
            ['username' => $_SESSION['username']]);
        $params = [
            'account_id'   => $account_id,
            'feed_id'      => $id,
            'appreciation' => $appreciation
        ];

        $result = $this->dataBase->column("SELECT count(id) FROM Likes WHERE account_id = :account_id and appreciation = :appreciation and feed_id = :feed_id",
            $params);

        if ($result === '1') {
            return 'checked';
        }
        return '';
    }

    private function changeAppreciation(int $account_id, int $feed_id)
    {
        $id = $this->dataBase->column("SELECT id FROM Likes WHERE account_id = :account_id",
            ['account_id' => $account_id]);
        if (!empty($id)) {
            $params = ['account_id' => $account_id, 'feed_id' => $feed_id];
            $this->dataBase->query("DELETE FROM Likes WHERE account_id = :account_id and feed_id = :feed_id", $params);
        }
    }
}