<?php


namespace application\models;

use application\core\Model;

class Comment extends Model
{
    public function getCommentErrors(): ?string
    {
        $errors = [];

        if (empty($_POST['comment_first_name'])) {
            $errors[] = 'Pls enter first name!';
        }
        if (empty($_POST['comment_last_name'])) {
            $errors[] = 'Pls enter last name!';
        }
        if (empty($_POST['comment_message'])) {
            $errors[] = 'Pls enter message!';
        }

        if (!empty($errors)) {
            return $errors[0];
        }
        return null;
    }

    public function addComment(int $id)
    {
        $author = ['first_name' => $_POST['comment_first_name'], 'last_name' => $_POST['comment_last_name']];
        $this->dataBase->query("INSERT INTO Authors (first_name, last_name) VALUES (:first_name, :last_name)", $author);
        $author_id = $this->dataBase->lastInsertId();
        $params = ['feed_id' => $id, 'author_id' => $author_id, 'content' => $_POST['comment_message']];
        $this->dataBase->query("INSERT INTO Comments (feed_id, author_id, content, commented_at)
                                VALUES(:feed_id, :author_id, :content, NOW())", $params);
    }

    public function getCommentsAuthors(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("SELECT first_name, last_name FROM Authors WHERE id = :id", $params);
    }

    public function getComments(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("SELECT author_id, content, commented_at FROM Comments  WHERE feed_id = :id ORDER BY id DESC",
            $params);
    }
}