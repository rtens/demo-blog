<?php
use watoki\curir\rendering\adapter\TempanRenderer;
use watoki\curir\WebDelivery;

require_once 'vendor/autoload.php';
require_once 'IndexResource.php';
require_once 'ArticleResource.php';

$factory = WebDelivery::init(new TempanRenderer());
WebDelivery::quickResponse(IndexResource::class, $factory);