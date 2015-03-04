<?php

class IndexResource implements \watoki\deli\Responding {

    public function respond(\watoki\deli\Request $r) {
        $renderer = new \watoki\tempan\Renderer(file_get_contents('index.html'));
        return $renderer->render([
            'article' => $this->assembleArticles()
        ]);
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