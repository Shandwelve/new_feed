<?php

namespace application\core;

class Pagination
{
    private array $route = [];
    private int $limit;
    private int $total;
    private int $amount;
    private int $currentPage;

    public function __construct(array $route, int $total, int $limit = 10)
    {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->getAmount();
        $this->currentPage = $this->getCurrentPage();
    }

    private function getCurrentPage(): int
    {
        if (!isset($this->route['page']) || $this->route['page'] < 1) {
            return 1;
        }
        if ($this->route['page'] > $this->amount) {
            return $this->amount;
        }
        return $this->route['page'];
    }

    private function getAmount(): int
    {
        return ceil($this->total / $this->limit);
    }

    public function getStart(): int
    {
        return ($this->currentPage - 1) * $this->limit;
    }

    public function getHtml(): string
    {
        $backPage = null;
        $forwardPage = null;
        $currentPage = null;
        $back = $this->currentPage - 1;
        $forward = $this->currentPage + 1;

        $currentPage = '<li class="current_page"><a href="#">' . $this->currentPage . '</a></li>';

        if ($this->currentPage > 1) {
            $backPage = '<li class="navigation_btn back_btn"><a href="/page/' . $back . '">' . 'Back' . '</a></li>';
        }
        if ($this->currentPage < $this->amount) {
            $forwardPage = '<li class="navigation_btn forward_btn"><a href="/page/' . $forward . '">' . 'Forward' . '</a></li>';
        }
        return '<ul class="pages">' . $backPage . $currentPage . $forwardPage . '</ul>';
    }
}