<?php

use watoki\curir\delivery\WebResponse;
use watoki\curir\error\HttpError;

class ArticleResource extends \watoki\curir\Resource {

    public function doGet($article) {
        $file = "articles/$article.html";
        if (!file_exists($file)) {
            throw new HttpError(WebResponse::STATUS_NOT_FOUND, "The article [$article] does not exist.");
        }

        list($date, $title) = explode('__', $article);

        return [
            'title' => ucfirst(str_replace('_', ' ', $title)),
            'date' => date('Y, F dS', strtotime($date)),
            'content' => file_get_contents($file),
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