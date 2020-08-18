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
        $back = $this->currentPage - 1;
        $forward = $this->currentPage + 1;
        $backPage = '';
        $forwardPage = '';

        $currentPage = '<li class="page-item active" aria-current="page"><a class="page-link" href="#">' . $this->currentPage . ' <span class="sr-only">(current)</span></a></li>';

        if ($this->currentPage > 1) {
            $previous = '<li class="page-item"> <a class="page-link" href="/page/' . $back . '" tabindex="-1" aria-disabled="true">Previous</a> </li>';
            $backPage = '<li class="page-item"><a class="page-link" href="/page/' . $back . '">' . $back . '</a></li>';
        } else {
            $previous = '<li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a> </li>';
        }

        if ($this->currentPage < $this->amount) {
            $next = '<li class="page-item"> <a class="page-link" href="/page/' . $forward . '" tabindex="-1" aria-disabled="true">Next</a> </li>';
            $forwardPage = '<li class="page-item"><a class="page-link" href="/page/' . $forward . '">' . $forward . '</a></li>';
        } else {
            $next = '<li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a> </li>';
        }

        return '<nav aria-label="..." class="d-flex justify-content-center">
        <ul class="pagination">' . $previous . $backPage . $currentPage . $forwardPage . $next . '</ul> </nav>';
    }
}