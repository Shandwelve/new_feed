<?php


namespace application\models;

use application\core\Model;

class Like extends Model
{
    public function getAppreciationNumber(int $id, int $appreciation): int
    {
        return $this->dataBase->column("
                                SELECT 
                                    count(id)
                                FROM 
                                    likes 
                                WHERE 
                                    appreciation = :appreciation and feed_id = :id",
            [
                'id'           => $id,
                'appreciation' => $appreciation
            ]
        );
    }


    public function addAppreciation(int $id, int $appreciation)
    {
        $params = [
            'account_id'   => $_SESSION['user_id'],
            'feed_id'      => $id,
            'appreciation' => $appreciation
        ];
        $this->changeAppreciation($_SESSION['user_id'], $id);
        $this->dataBase->query("
                        INSERT 
                            likes 
                        SET
                            account_id = :account_id, feed_id = :feed_id, appreciation = :appreciation",
            $params);
    }

    public function checkAppreciation(int $id, int $appreciation): string
    {
        if (isset($_SESSION['username'])) {
            $result = $this->dataBase->column("
                                        SELECT 
                                            count(id) 
                                        FROM 
                                            likes 
                                        WHERE 
                                            account_id = :account_id 
                                            and appreciation = :appreciation 
                                            and feed_id = :feed_id",
                [
                    'account_id'   => $_SESSION['user_id'],
                    'feed_id'      => $id,
                    'appreciation' => $appreciation
                ]);

            if ($result === '1') {
                return 'checked';
            }
        }
        return '';
    }

    private function changeAppreciation(int $account_id, int $feed_id)
    {
        $id = $this->dataBase->column("
                                SELECT 
                                    id 
                                FROM 
                                    likes 
                                WHERE 
                                    account_id = :account_id",
            [
                'account_id' => $account_id
            ]
        );

        if (!empty($id)) {
            $this->dataBase->query("
                                DELETE FROM 
                                    likes 
                                WHERE 
                                    account_id = :account_id and feed_id = :feed_id",
                [
                    'account_id' => $account_id,
                    'feed_id'    => $feed_id
                ]
            );
        }
    }
}