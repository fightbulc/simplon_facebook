<?php

use Simplon\Facebook\App\FacebookApps;

require __DIR__ . '/../vendor/autoload.php';

$app = new FacebookApps('946621778709815', 'a0c4757bf2b23773c6fb5ac37c7eea50');
$app->requestAccessToken();