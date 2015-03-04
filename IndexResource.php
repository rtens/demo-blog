<?php

class IndexResource extends \watoki\curir\Container {

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
            'link' => array('href' => $articleFile),
            'date' => date('Y, F dS', strtotime($date)),
            'title' => str_replace(['_', '.html'], ' ', $title)
        ];
    }
}