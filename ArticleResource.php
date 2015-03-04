<?php

class ArticleResource extends \watoki\curir\Resource {

    public function doGet($article) {
        list($date, $title) = explode('__', $article);

        return [
            'title' => ucfirst(str_replace('_', ' ', $title)),
            'date' => date('Y, F dS', strtotime($date)),
            'content' => file_get_contents("articles/$article.html"),
            'commentOn' => ['value' => $article]
        ];
    }

}