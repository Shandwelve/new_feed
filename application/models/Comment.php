<?php


namespace application\models;

use application\core\Model;

class Comment extends Model
{
    public function getCommentErrors(): ?string
    {
        if (empty($_POST['comment_message'])) {
            return 'Please enter message!';
        }

        return null;
    }

    public function addComment(int $id): int
    {
        $params = ['feed_id' => $id, 'author_id' => $_SESSION['user_id'], 'content' => $_POST['comment_message']];
        $this->dataBase->query("
                        INSERT 
                            comments 
                        SET 
                            feed_id = :feed_id, author_id = :author_id, content = :content, commented_at = NOW()",
            $params
        );

        return $this->dataBase->lastInsertId();
    }

    public function deleteComment(int $id): int
    {
        $feed_id = $this->dataBase->column("
                                    SELECT 
                                        feed_id 
                                    FROM 
                                        comments
                                    WHERE 
                                        id = :id",
                                    [
                                        'id' => $id
                                    ]
        );
        $this->dataBase->query("
                        DELETE FROM 
                            comments 
                        WHERE 
                            id = :id",
                        [
                            'id' => $id
                        ]
        );

        return $feed_id;
    }


    public function getComments(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("
                                SELECT 
                                    comments.id, comments.content, comments.commented_at, account.username 
                                FROM 
                                    comments 
                                JOIN account on account.id = comments.author_id 
                                WHERE 
                                    feed_id = :id 
                                ORDER BY 
                                    id 
                                DESC",
                                 $params
        );
    }
}