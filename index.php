<?php
require_once 'vendor/autoload.php';
require_once 'IndexResource.php';

$resource = new IndexResource(__DIR__ . '/articles');
echo $resource->respond();