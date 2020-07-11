<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\core\Pagination;

class MainController extends Controller
{
    public function index()
    {
        $articlesNumber = $this->model->getArticlesNumber();
        $pagination = new Pagination($this->route, $articlesNumber, 10);
        $pages = $pagination->getHtml();
        $result = $this->model->getArticles($pagination->getStart(), 10);
        $preview = $this->model->previewDescription($result);
        $images = $this->model->getImages();
        $this->view->render('Main Page', ['articles' => $preview, 'images' => $images, 'pages' => $pages]);
    }

    public function article()
    {
        if ($this->model->checkExistence($this->route['id'])) {
            $result = $this->model->getArticle($this->route['id']);
            $image = $this->model->getImage($this->route['id']);
            $article_author = $this->model->getArticleAuthor($this->route['id']);
            $comments = $this->model->getComments($this->route['id']);
            $likes = $this->model->getLikes($this->route['id']);
            $comment_authors = [];
            $status = '';

            foreach ($comments as $item) {
                $comment_authors[] = $this->model->getCommentsAuthors($item['author_id']);
            };
            if (!empty($_POST)) {
                $errors = $this->model->getCommentErrors();
                if (!isset($errors)) {
                    if (isset($_POST['like'])) {
                        $this->model->updateLikes($this->route['id']);
                    }
                    $status = 'Success';
                    $this->model->addComment($this->route['id']);
                    $this->view->redirect('article/' . $this->route['id']);
                } else {
                    $status = $errors;
                }
            }

            $this->view->render('Article',
                [
                    'data'            => $result,
                    'image'           => $image,
                    'article_author'  => $article_author,
                    'comments'        => $comments,
                    'comment_authors' => $comment_authors,
                    'status'          => $status,
                    'likes'           => $likes
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
                $this->view->redirect('article/' . $id);
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
                    $this->view->redirect('article/' . $this->route['id']);
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