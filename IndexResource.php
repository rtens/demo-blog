<?php

use watoki\deli\router\MultiRouter;

class IndexResource extends \watoki\curir\Container {

    public function doPost($article, $email, $comment) {
        @mkdir("comments/$article", 0777, true);
        file_put_contents("comments/$article/" . time() . '.json', json_encode([
            "by" => $email,
            "comment" => $comment
        ]));
        mail("me@example.com", "New comment on $article", $comment, "From: $email");

        return array_merge($this->doGet(), [
            "message" => "Thanks for your comment."
        ]);
    }

    public function doGet() {
        return [
            'article' => $this->assembleArticles()
        ];
    }

    function assembleArticles() {
        return array_map([$this, 'assembleArticle'], glob('articles/*.html'));
    }

    public function assembleArticle($articleFile) {
        list($date, $title) = explode('__', basename($articleFile));

        return [
            'link' => array('href' => 'articles/' . substr(basename($articleFile), 0, -5) . '.html'),
            'date' => date('Y, F dS', strtotime($date)),
            'title' => str_replace(['_', '.html'], ' ', $title)
        ];
    }

    protected function createRouter() {
        $router = new \watoki\deli\router\DynamicRouter();
        $router->addObjectPath('articles/{article}', ArticleResource::class, $this->factory);
        return new MultiRouter([$router, parent::createRouter()]);
    }
}