<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\core\Pagination;

class MainController extends Controller
{
    public function index()
    {
        $limit = 2;
        $articlesNumber = $this->model->getArticlesNumber();
        $pagination = new Pagination($this->route, $articlesNumber, $limit);
        $pages = $pagination->getHtml();
        $start = $pagination->getStart();
        $result = $this->model->getArticles($start, $limit);
        $preview = $this->model->previewDescription($result);

        $this->view->addComponent(['articles' => $preview, 'pages' => $pages]);
        $this->view->render('Main Page');
    }
}