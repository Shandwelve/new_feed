<?php


namespace application\models;

use application\core\Model;

class Comment extends Model
{
    public function getCommentErrors(): ?string
    {
        if (empty($_POST['comment_message'])) {
            return 'Pls enter message!';
        }

        return null;
    }

    public function addComment(int $id)
    {
        $params = ['username' => $_SESSION['username']];
        $author_id = $this->dataBase->column("SELECT id FROM Account WHERE username = :username", $params);
        $params = ['feed_id' => $id, 'author_id' => $author_id, 'content' => $_POST['comment_message']];
        $this->dataBase->query("INSERT INTO Comments (feed_id, author_id, content, commented_at)
                                VALUES(:feed_id, :author_id, :content, NOW())", $params);
    }

    public function deleteComment(int $id): int
    {
        $feed_id = $this->dataBase->column("SELECT feed_id FROM Comments WHERE id = :id", ['id' => $id]);
        $this->dataBase->query("DELETE FROM Comments WHERE id = :id", ['id' => $id]);

        return $feed_id;
    }

    public function getCommentsAuthors(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("SELECT username FROM Account WHERE id = :id", $params);
    }

    public function getComments(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("SELECT id, author_id, content, commented_at FROM Comments  WHERE feed_id = :id ORDER BY id DESC",
            $params);
    }
}