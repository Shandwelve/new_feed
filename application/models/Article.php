<?php

namespace application\models;

use application\core\Model;

class Article extends Model
{
    public function getArticle(int $id): array
    {
        $params = ['id' => $id];
        return $this->dataBase->row("SELECT title, content, created_at FROM Feeds WHERE id = :id", $params);
    }

    public function getImage(int $id): string
    {
        $params = ['id' => $id];
        return $this->dataBase->column("SELECT image FROM Images WHERE id = :id", $params);
    }

    public function getArticleAuthor(int $id): array
    {
        $params = ['id' => $id];
        $author_id = $this->dataBase->column("SELECT author_id FROM Feeds WHERE id = :id", $params);
        $params = ['id' => $author_id];

        return $this->dataBase->row("SELECT username FROM Account WHERE id = :id", $params);
    }

    public function checkExistence(int $id): bool
    {
        $params = ['id' => $id];
        if ($this->dataBase->column("SELECT id FROM  Feeds WHERE id = :id", $params)) {
            return true;
        }
        return false;
    }

    public function getArticleErrors(string $action): ?string
    {
        $errors = [];

        if (empty($_POST['new_title'])) {
            $errors[] = 'Pls enter title!';
        }
        if (empty($_POST['new_post_time'])) {
            $errors[] = 'Pls post time!';
        }
        if (empty($_POST['new_post_date'])) {
            $errors[] = 'Pls enter post date!';
        }
        if (empty($_FILES['new_post_image']) && $action === 'add') {
            $errors[] = 'Pls select image!';
        }
        if (empty($_POST['new_description'])) {
            $errors[] = 'Pls enter description!';
        }

        if (!empty($errors)) {
            return $errors[0];
        }
        return null;
    }

    public function uploadImage(array $name, int $id)
    {
        $extension = pathinfo($name['name'], PATHINFO_EXTENSION);
        move_uploaded_file($name['tmp_name'], 'img/' . "$id.$extension");
        $params = ['image' => "$id.$extension"];
        $this->dataBase->query("INSERT INTO Images(image) VALUES(:image)", $params);
    }

    public function addPost(): int
    {
        $author_id = $this->dataBase->column("SELECT id FROM Account WHERE username = :username", ['username' => $_SESSION['username']]);
        $image = $this->dataBase->column('SELECT MAX(id) FROM Images');
        $feed = [
            'title'      => $_POST['new_title'],
            'author_id'  => $author_id,
            'content'    => $_POST['new_description'],
            'image_id'   => $image + 1,
            'created_at' => $_POST['new_post_date']. ' ' . $_POST['new_post_time']
        ];

        $this->dataBase->query("INSERT INTO Feeds (title, author_id, content, image_id, created_at) 
                                VALUES(:title, :author_id, :content, :image_id, :created_at)", $feed);

        return $this->dataBase->lastInsertId();
    }

    public function addLikes(int $id)
    {
        $params = ['id' => $id];
        $this->dataBase->query("INSERT INTO Likes (feed_id, likes) VALUES (:id, 0)", $params);
    }

    public function editImage(int $id)
    {
        if (!empty($_FILES)) {
            $extension = pathinfo($_FILES['new_post_image']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['new_post_image']['tmp_name'], 'img/' . "$id.$extension");
        }
    }

    public function editPost(int $id)
    {
        $feed = [
            'title'      => $_POST['new_title'],
            'content'    => $_POST['new_description'],
            'created_at' => $_POST['new_post_date'],
            'id'         => $id
        ];

        $this->dataBase->query("UPDATE Feeds SET title = :title, content = :content, created_at = :created_at WHERE id = :id",
            $feed);
    }

    public function deletePost(int $id)
    {
        $params = ['id' => $id];
        $image = $this->dataBase->column("SELECT image FROM Images WHERE id = :id", $params);
        $author_id = $this->dataBase->column("SELECT author_id FROM Feeds WHERE id = :id", $params);
        $comments_authors = $this->dataBase->row("SELECT author_id FROM Comments WHERE feed_id = :id", $params);

        $this->dataBase->query("DELETE FROM Authors WHERE id = :id", ['id' => $author_id]);
        $this->dataBase->query("DELETE FROM Feeds WHERE id = :id", $params);
        $this->dataBase->query("DELETE FROM Likes WHERE id = :id", $params);
        $this->dataBase->query("DELETE FROM Comments WHERE id = :id", $params);
        $this->dataBase->query("DELETE FROM Images WHERE id = :id", $params);

        foreach ($comments_authors as $item) {
            $this->dataBase->query("DELETE FROM Authors WHERE id = :id", ['id' => $item['author_id']]);
        }

        unlink('img/' . $image);
    }
}