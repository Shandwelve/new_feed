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
            $comments_status = 'Leave a comment!';

            $result[0]['created_at'] = date('g:i a \o\n l jS F Y', strtotime($result[0]['created_at']));
            foreach ($comments_content as $item) {
                $comment_authors[] = $comment->getCommentsAuthors($item['author_id']);
            };

//            if (!empty($_POST)) {
//                $errors = $comment->getCommentErrors();
//                if (!isset($errors)) {
//                    if (isset($_POST['like'])) {
//                        $like->updateLikes($this->route['id']);
//                    }
//                    $comment->addComment($this->route['id']);
//                    $this->view->redirect('show/' . $this->route['id']);
//                } else {
//                    $comments_status = $errors;
//                }
//            }

            $this->view->render('Article',
                [
                    'data'            => $result,
                    'image'           => $image,
                    'article_author'  => $article_author,
                    'comments'        => $comments_content,
                    'comment_authors' => $comment_authors,
                    'comments_status' => $comments_status,
                    'likes'           => $likes_number
                ]);

        } else {
            View::errorCode(404);
        }
    }


    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('Add', ['status' => 'Add article!']);
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

    public function addComment()
    {
            $comment = new Comment();;
            $errors = $comment->getCommentErrors();
            if (!isset($errors)) {
                $comment->addComment($this->route['id']);
            }
            $this->view->redirect('show/' . $this->route['id']);
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
        } else {
            $result = $this->model->getArticle($this->route['id']);
            $data_time = explode(' ', $result[0]['created_at']);
            if (empty($_POST)) {
                $this->view->render('Edit',
                    ['status' => 'Edit article!', 'data' => $result, 'data_time' => $data_time]);
            } else {
                $errors = $this->model->getArticleErrors('edit');
                if (!isset($errors)) {
                    $this->model->editPost($this->route['id']);
                    $this->model->editImage($this->route['id']);
                    $this->view->redirect('show/' . $this->route['id']);
                    $this->view->render('Edit', ['status' => 'Success', 'data' => $result]);
                } else {
                    $this->view->render('Edit', ['status' => $errors, 'data' => $result]);
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