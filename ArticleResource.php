<?php

class ArticleResource extends \watoki\curir\Resource {

    public function doGet($article) {
        list($date, $title) = explode('__', $article);

        return [
            'title' => ucfirst(str_replace('_', ' ', $title)),
            'date' => date('Y, F dS', strtotime($date)),
            'content' => file_get_contents("articles/$article.html"),
            'commentOn' => ['value' => $article],
            'comment' => $this->assembleComments($article)
        ];
    }

    private function assembleComments($article) {
        return array_map([$this, 'assembleComment'], glob("comments/$article/*.json"));
    }

    private function assembleComment($file) {
        $data = json_decode(file_get_contents($file), true);

        return array_merge($data, [
            'date' => date('Y-m-d', substr(basename($file), 0, -5))
        ]);
    }

}