<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getArticles(int $start, int $max = 10): array
    {
        $params = ['start' => $start, 'max' => $max];
        return $this->dataBase->row("SELECT id, title, content, created_at FROM Feeds ORDER BY id DESC LIMIT :start, :max",
            $params);
    }

    public function getArticlesNumber(): int
    {
        return $this->dataBase->column("SELECT COUNT(id) FROM Feeds ");
    }

    public function getImages(int $start, int $limit): array
    {
        $params = ['start' => $start, 'max' => $limit];
        return $this->dataBase->row("SELECT image FROM Images ORDER BY id DESC LIMIT :start, :max", $params);
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
}
