<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\models\Comment;
use application\models\Like;

class ArticleController extends Controller
{
    public function show()
    {
        if ($this->model->checkExistence($this->route['id'])) {
            $comment = new Comment();
            $like = new Like();
            $result = $this->model->getArticle($this->route['id']);
            $image = $this->model->getImage($this->route['id']);
            $article_author = $this->model->getArticleAuthor($this->route['id']);
            $comments_content = $comment->getComments($this->route['id']);
            $likes_number = $like->getLikes($this->route['id']);
            $comment_authors = [];
            $status = '';

            foreach ($comments_content as $item) {
                $comment_authors[] = $comment->getCommentsAuthors($item['author_id']);
            };
            if (!empty($_POST)) {
                $errors = $comment->getCommentErrors();
                if (!isset($errors)) {
                    if (isset($_POST['like'])) {
                        $like->updateLikes($this->route['id']);
                    }
                    $status = 'Success';
                    $comment->addComment($this->route['id']);
                    $this->view->redirect('show/' . $this->route['id']);
                } else {
                    $status = $errors;
                }
            }

            $this->view->render('Article',
                [
                    'data'            => $result,
                    'image'           => $image,
                    'article_author'  => $article_author,
                    'comments'        => $comments_content,
                    'comment_authors' => $comment_authors,
                    'status'          => $status,
                    'likes'           => $likes_number
                ]);

        } else {
            View::errorCode(404);
        }
    }


    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('Add', ['status' => 'Complete fields!']);
        } else {
            $errors = $this->model->getArticleErrors('add');
            if (!isset($errors)) {
                $id = $this->model->addPost();
                $this->model->uploadImage($_FILES['new_post_image'], $id);
                $this->model->addLikes($id);
                $this->view->redirect('show/' . $id);
            } else {
                $this->view->render('Add', ['status' => $errors]);
            }
        }
    }

    public function edit()
    {
        if (!$this->model->checkExistence($this->route['id'])) {
            View::errorCode(404);
        } else {
            $result = $this->model->getArticle($this->route['id']);
            $author = $this->model->getArticleAuthor($this->route['id']);
            if (empty($_POST)) {
                $this->view->render('Edit', ['data' => $result, 'author' => $author]);
            } else {
                $errors = $this->model->getArticleErrors('edit');
                if (!isset($errors)) {
                    $this->model->editPost($this->route['id']);
                    $this->model->editImage($this->route['id']);
                    $this->view->redirect('show/' . $this->route['id']);
                    $this->view->render('Edit', ['status' => 'Success', 'data' => $result, 'author' => $author]);
                } else {
                    $this->view->render('Edit', ['status' => $errors, 'data' => $result, 'author' => $author]);
                }
            }
        }
    }

    public function delete()
    {
        if (!$this->model->checkExistence($this->route['id'])) {
            View::errorCode(404);
        } else {
            $this->model->deletePost($this->route['id']);
            $this->view->redirect('');
        }
    }
}