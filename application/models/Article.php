<?php

namespace application\models;

use application\core\Model;

class Article extends Model
{
    public function getArticle(int $id): array
    {
        return $this->dataBase->row("
            SELECT
                feeds.title, feeds.created_at, feeds.content, images.image, account.username
            FROM
                 feeds
            JOIN images ON feeds.image_id = images.id
            JOIN account ON feeds.author_id = account.id
            where
                  feeds.id =  :id",
            [
                'id' => $id
            ]
        );
    }

    public function checkExistence(int $id): bool
    {
        return (bool)$this->dataBase->column("
                        SELECT 
                            id 
                        FROM 
                            Feeds 
                        WHERE 
                            id = :id",
            [
                'id' => $id
            ]
        );
    }

    public function getArticleErrors(string $action): ?string
    {
        $errors = [];

        if (empty($_POST['new_title'])) {
            $errors[] = 'title';
        }
        if (empty($_POST['new_post_time'])) {
            $errors[] = 'post time';
        }
        if (empty($_POST['new_post_date'])) {
            $errors[] = 'post date';
        }
        if (empty($_FILES['new_post_image']) && $action === 'add') {
            $errors[] = 'image';
        }
        if (empty($_POST['new_description'])) {
            $errors[] = 'description';
        }

        if (!empty($errors)) {
            return 'Complete next fields: '.implode(', ', $errors).'!';
        }
        return null;
    }

    public function uploadImage(array $name, int $id): int
    {
        $extension = pathinfo($name['name'], PATHINFO_EXTENSION);
        move_uploaded_file($name['tmp_name'], 'img/' . "$id.$extension");
        $this->dataBase->query("
                INSERT 
                    images
                SET 
                image = :image",
            [
                'image' => "$id.$extension"
            ]
        );

        return $this->dataBase->lastInsertId();
    }

    public function addPost(): int
    {
        $image = $this->dataBase->column("
                SELECT 
                    MAX(id)
                FROM 
                    images"
        );

        $feed = [
            'title'      => $_POST['new_title'],
            'author_id'  => $_SESSION['user_id'],
            'content'    => $_POST['new_description'],
            'image_id'   => $image + 1,
            'created_at' => $_POST['new_post_date'] . ' ' . $_POST['new_post_time']
        ];

        $this->dataBase->query("
            INSERT 
                feeds
            SET 
                title = :title,
                author_id = :author_id,
                content = :content,
                image_id = :image_id,
                created_at = :created_at",
            $feed
        );

        return $this->dataBase->lastInsertId();
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
            'created_at' => $_POST['new_post_date'] . ' ' . $_POST['new_post_time'],
            'id'         => $id
        ];

        $this->dataBase->query("
                UPDATE 
                    feeds 
                SET
                    title = :title, content = :content, created_at = :created_at
                WHERE id = :id",
            $feed
        );
    }

    public function deletePost(int $id)
    {
        $params = ['id' => $id];
        $image = $this->dataBase->column("
                SELECT 
                     image 
                FROM 
                     images 
                 WHERE 
                    id = :id",
            $params
        );
        $author_id = $this->dataBase->column("
                SELECT 
                    author_id 
                FROM 
                    feeds 
                WHERE 
                    id = :id",
            $params
        );

        $this->dataBase->query("
                DELETE FROM
                    authors 
                WHERE 
                    id = :id",
            [
                'id' => $author_id
            ]
        );

        $this->dataBase->query("
                DELETE FROM
                    feeds 
                WHERE 
                    id = :id",
            $params
        );

        $this->dataBase->query("
                DELETE FROM
                    likes 
                WHERE 
                    id = :id",
            $params
        );

        $this->dataBase->query("
                DELETE FROM
                    comments
                WHERE 
                    id = :id",
            $params
        );

        $this->dataBase->query("
                DELETE FROM
                    images
                WHERE 
                    id = :id",
            $params
        );
        unlink('img/' . $image);
    }
}