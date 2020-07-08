<?php


namespace application\core;

use PDO;
use PDOException;

class DataBase
{
    private static object $instance;

    private object $connection;

    public static function getInstance(): object
    {
        return self::$instance ??= new self();
    }

    public function connect(array $config): bool
    {
        try {
            $this->connection = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['name']}",
                $config['username'], $config['password']);
        } catch (PDOException $exception) {
            die('Connection error: ' . $exception->getMessage());
        }
        return true;
    }

    public function selectById(string $table, int $id, string $field): array
    {
        $query = $this->connection->prepare("SELECT $field FROM $table WHERE id = :id");
        $query->execute(['id' => $id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectImages(string $table): array
    {
        $query = $this->connection->prepare("SELECT image FROM $table");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectImage(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT image FROM $table WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAuthor(string $table, int $feed_id): array
    {
        $author_id = $this->connection->prepare("SELECT author_id FROM Feeds WHERE id = :id");
        $author_id->execute(['id' => $feed_id]);
        $id = $author_id->fetch(PDO::FETCH_ASSOC);
        $query = $this->connection->prepare("SELECT first_name, last_name FROM $table WHERE id = :id");
        $query->execute(['id' => $id['author_id']]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectArticle(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT title, content, created_at FROM  $table WHERE id = :id;");
        $query->execute(['id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function checkExistence(string $table, int $id): bool
    {
        $query = $this->connection->prepare("SELECT title, content, created_at FROM  $table WHERE id = :id;");
        $query->execute(['id' => $id]);

        if ($query->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }

        return false;
    }

    public function selectArticles(string $table): array
    {
        $query = $this->connection->prepare("SELECT id, title, content FROM $table");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAuthor(string $table, array $params)
    {
        $query = $this->connection->prepare("INSERT INTO $table (first_name, last_name) VALUES (:first_name, :last_name)");
        $query->execute(['first_name' => $params['first_name'], 'last_name' => $params['last_name']]);

        return $this->lastInsertId();
    }

    public function addImage(string $table, string $name): string
    {
        $query = $this->connection->prepare("INSERT INTO $table (image) VALUES (:name)");
        $query->execute(['name' => $name]);

        return $this->lastInsertId();
    }

    public function addArticle(string $table, array $params): string
    {
        $query = $this->connection->prepare("INSERT INTO $table (title, author_id, content, image_id, created_at) 
                                             VALUES(:title, :author_id, :content, :image_id, :created_at)");
        $query->execute([
            'title'      => $params['title'],
            'author_id'  => $params['author_id'],
            'content'    => $params['content'],
            'image_id'   => $params['image_id'],
            'created_at' => $params['created_at']
        ]);

        return $this->lastInsertId();
    }

    public function updateArticle(string $table, array $params, int $id): string
    {
        $query = $this->connection->prepare("UPDATE $table SET title = :title, content = :content, created_at = :created_at WHERE id = :id");
        $query->execute([
            'title'      => $params['title'],
            'content'    => $params['content'],
            'created_at' => $params['created_at'],
            'id'         => $id
        ]);

        return $this->lastInsertId();
    }

    public function deletePost(string $table, int $id)
    {
        $query = $this->connection->prepare("DELETE FROM $table WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    public function deleteAuthor(string $table, int $id)
    {
        $author_id_query = $this->connection->prepare("SELECT author_id FROM Feeds WHERE id = :id");
        $author_id_query->execute(['id' => $id]);
        $author_id = $author_id_query->fetch(PDO::FETCH_ASSOC);

        $query = $this->connection->prepare("DELETE FROM $table WHERE id = :id");
        $query->execute(['id' => $author_id['author_id']]);
    }

    public function addComment(string $table, array $params): string
    {
        $query = $this->connection->prepare("INSERT INTO $table (feed_id, author_id, content, commented_at) 
                                             VALUES(:feed_id, :author_id, :content, NOW())");
        $query->execute([
            'feed_id'   => $params['feed_id'],
            'author_id' => $params['author_id'],
            'content'   => $params['content']
        ]);

        return $this->lastInsertId();
    }

    public function selectComments(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT author_id, content, commented_at FROM $table WHERE feed_id = :id");
        $query->execute(['id' => $id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectCommentsAuthors(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT first_name, last_name FROM $table WHERE id = :id");
        $query->execute(['id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectLikes(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT likes FROM $table WHERE feed_id = :id");
        $query->execute(['id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertLikes(string $table, int $id)
    {
        $query = $this->connection->prepare("INSERT INTO $table (feed_id, likes) VALUES (:id, 0)");
        $query->execute(['id' => $id]);
    }

    public function updateLikes(string $table, int $id)
    {
        $query = $this->connection->prepare("UPDATE $table SET likes = likes + 1 WHERE feed_id = :id");
        $query->execute(['id' => $id]);
    }

    public function selectCommentsAuthorsId(string $table, int $id): array
    {
        $query = $this->connection->prepare("SELECT author_id FROM $table WHERE feed_id = :id");
        $query->execute(['id' => $id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteComments(string $table, int $id)
    {
        $query = $this->connection->prepare("DELETE FROM $table WHERE feed_id = :id");
        $query->execute(['id' => $id]);
    }

    public function deleteLikes(string $table, int $id)
    {
        $query = $this->connection->prepare("DELETE FROM $table WHERE feed_id = :id");
        $query->execute(['id' => $id]);
    }

    public function deleteCommentsAuthors(string $table, int $id)
    {
        $query = $this->connection->prepare("DELETE FROM $table WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }

    public function maxId(string $table): array
    {
        $query = $this->connection->prepare("SELECT MAX(id) FROM $table");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}