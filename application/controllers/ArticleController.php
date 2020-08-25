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
        if (!$this->model->checkExistence($this->route['id'])) {
            View::errorCode(404);
            return;
        }

        $result = $this->model->getArticle($this->route['id']);
        $result[0]['created_at'] = date('g:i a \o\n l jS F Y', strtotime($result[0]['created_at']));
        $this->view->addComponent(['data' => $result]);

        $this->getLikes();
        $this->getComments();

        $this->view->render('Article');
    }

    public function add()
    {
        if (empty($_POST)) {
            $this->view->addComponent(['status' => 'Add article!']);
            $this->view->render('Add');
            var_dump(1);
            return;
        }

        $errors = $this->model->getArticleErrors('add');
        if (isset($errors)) {
            $this->view->addComponent(['status' => $errors]);
            $this->view->render('Add');
            var_dump(2);
            return;
        }

        $id = $this->model->addPost();
        $this->model->uploadImage($_FILES['new_post_image'], $id);
        $this->view->redirect('show/' . $id);
    }

    public function addComment()
    {
        $comment = new Comment();

        $errors = $comment->getCommentErrors();
        if (!isset($errors)) {
            $comment->addComment($this->route['id']);
        }
    }

    public function getLikes()
    {
        $like = new Like();
        $likes_number = $like->getAppreciationNumber($this->route['id'], 1);
        $dislikes_number = $like->getAppreciationNumber($this->route['id'], 0);
        $like_status = $like->checkAppreciation($this->route['id'], 1);
        $dislike_status = $like->checkAppreciation($this->route['id'], 0);

        $appreciation = [
            'like_status'     => $like_status,
            'dislike_status'  => $dislike_status,
            'likes_number'    => $likes_number,
            'dislikes_number' => $dislikes_number
        ];

        $this->view->addComponent(
            [
                'appreciation' => $appreciation
            ],
            'likes'
        );

    }

    public function getComments()
    {
        $comment = new Comment();
        $comments_content = $comment->getComments($this->route['id']);
        $comments_status = 'Leave a comment!';

        $this->view->addComponent([
            'comments'        => $comments_content,
            'comments_status' => $comments_status
        ], 'comments');
    }


    public function deleteComment()
    {
        $comment = new Comment();
        $id = $comment->deleteComment($this->route['id']);
        $this->view->redirect('show/' . $id);
    }

    public function edit()
    {
        if (!$this->model->checkExistence($this->route['id'])) {
            View::errorCode(404);
            return;
        }

        $result = $this->model->getArticle($this->route['id']);
        $data_time = explode(' ', $result[0]['created_at']);
        if (empty($_POST)) {
            $this->view->addComponent(['status' => 'Edit article!', 'data' => $result, 'data_time' => $data_time]);
            $this->view->render('Edit');
            return;
        }

        $errors = $this->model->getArticleErrors('edit');
        if (isset($errors)) {
            $this->view->addComponent(['status' => $errors, 'data' => $result]);
            $this->view->render('Edit');
            return;
        }

        $this->model->editPost($this->route['id']);
        $this->model->editImage($this->route['id']);
        $this->view->redirect('show/' . $this->route['id']);
        $this->view->addComponent(['status' => 'Success', 'data' => $result]);
        $this->view->render('Edit');
    }

    public function delete()
    {
        if (!$this->model->checkExistence($this->route['id'])) {
            View::errorCode(404);
            return;
        }

        $this->model->deletePost($this->route['id']);
        $this->view->redirect('');
    }

    public function addLike()
    {
        $like = new Like();
        $like->addAppreciation($this->route['id'], 1);
        $this->view->redirect('show/' . $this->route['id']);
    }

    public function addDislike()
    {
        $like = new Like();
        $like->addAppreciation($this->route['id'], 0);
        $this->view->redirect('show/' . $this->route['id']);
    }
}