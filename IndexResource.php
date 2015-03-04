<?php

class IndexResource extends \watoki\curir\Container {

    public function doPost($article, $email, $comment) {
        mail("me@example.com", "New comment on $article", $comment, "From: $email");

        return array_merge($this->doGet(), [
            "message" => "Thanks for your comment. I'll publish it soon."
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
            'link' => array('href' => 'article.html?article=' . substr(basename($articleFile), 0, -5)),
            'date' => date('Y, F dS', strtotime($date)),
            'title' => str_replace(['_', '.html'], ' ', $title)
        ];
    }
}