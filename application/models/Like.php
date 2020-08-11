<?php


namespace application\models;

use application\core\Model;

class Like extends Model
{
    public function updateLikes(int $id)
    {
        $params = ['id' => $id];
        $this->dataBase->query("UPDATE Likes SET likes = likes + 1 WHERE feed_id = :id", $params);
    }

    public function getLikes(int $id): int
    {
        $params = ['id' => $id];
        return $this->dataBase->column("SELECT likes FROM Likes WHERE feed_id = :id", $params);
    }
}