<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getArticles(): array
    {
        return $this->dataBase->selectArticles('Feeds');
    }

    public function getImages(): array
    {
        return $this->dataBase->selectImages('Images');
    }

    public function getImage(int $id): array
    {
        return $this->dataBase->selectImage('Images', $id);
    }

    public function getArticle(int $id): array
    {
        return $this->dataBase->selectArticle('Feeds', $id);
    }

    public function getAuthor(int $id): array
    {
        return $this->dataBase->selectAuthor('Authors', $id);
    }

    public function checkExistence(int $id): bool
    {
        return $this->dataBase->checkExistence('Feeds', $id);
    }

    public function previewDescription(array $articles, int $offset = 200): array
    {
        for ($i = 0; $i < count($articles); $i++) {
            if (strlen($articles[$i]['content']) > $offset) {
                $preview = substr($articles[$i]['content'], 0, $offset) . '...';
                $articles[$i]['content'] = $preview;
            }
        }

        return $articles;
    }

    public function getArticleErrors(string $action): ?string
    {
        $errors = [];

        if (empty($_POST['new_title'])) {
            $errors[] = 'Pls enter title!';
        }
        if (empty($_POST['new_first_name'])) {
            $errors[] = 'Pls enter first name!';
        }
        if (empty($_POST['new_last_name'])) {
            $errors[] = 'Pls enter last name!';
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
        $this->dataBase->addImage('Images', "$id.$extension");
    }

    public function addPost(): int
    {
        $author = ['first_name' => $_POST['new_first_name'], 'last_name' => $_POST['new_last_name']];
        $author_id = $this->dataBase->addAuthor('Authors', $author);
        $image = $this->dataBase->maxId('Images');
        $feed = [
            'title'      => $_POST['new_title'],
            'author_id'  => $author_id,
            'content'    => $_POST['new_description'],
            'image_id'   => $image['MAX(id)'] + 1,
            'created_at' => $_POST['new_post_date']
        ];

        return $this->dataBase->addArticle('Feeds', $feed);
    }

    public function editImage(int $id)
    {
        if (!empty($_FILES)) {
            $extension = pathinfo($_FILES['new_post_image']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['new_post_image']['tmp_name'], 'img/' . "$id.$extension");
        }
    }

    public function editPost(int $id): int
    {
        $feed = [
            'title'      => $_POST['new_title'],
            'content'    => $_POST['new_description'],
            'created_at' => $_POST['new_post_date']
        ];
        return $this->dataBase->updateArticle('Feeds', $feed, $id);
    }

    public function deletePost(int $id)
    {
        $image = $this->dataBase->selectImage('Images', $id);
        $this->dataBase->deleteAuthor('Authors', $id);
        $this->dataBase->deletePost('Feeds', $id);
        unlink('img/' . $image['image']);
    }

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
        $author_id = $this->dataBase->addAuthor('Authors', $author);
        $params = ['feed_id' => $id, 'author_id' => $author_id, 'content' => $_POST['comment_message']];
        $this->dataBase->addComment('Comments', $params);
    }

    public function getCommentsAuthors(int $id): array
    {
        return $this->dataBase->selectCommentsAuthors('Authors', $id);
    }

    public function getComments(int $id): array
    {
        return $this->dataBase->selectComments('Comments', $id);
    }

    public function addLikes(int $id)
    {
        $this->dataBase->insertLikes('Likes', $id);
    }

    public function updateLikes(int $id)
    {
        $this->dataBase->updateLikes('Likes', $id);
    }

    public function getLikes(int $id): int
    {
        return $this->dataBase->selectLikes('Likes', $id)['likes'];
    }
}













