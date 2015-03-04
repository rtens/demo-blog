<?php
require_once 'vendor/autoload.php';

$viewModel = [
    'article' => assembleArticles()
];

$renderer = new \watoki\tempan\Renderer(file_get_contents('index.html'));
echo $renderer->render($viewModel);

function assembleArticles()
{
    $articles = [];
    foreach (glob('articles/*.html') as $article) {
        list($date, $title) = explode('__', basename($article));

        $articles[] = [
            'link' => array('href' => $article),
            'date' => date('Y, F dS', strtotime($date)),
            'title' => str_replace(['_', '.html'], ' ', $title)
        ];
    }
    return $articles;
}