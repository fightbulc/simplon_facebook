<?php

use Simplon\Facebook\App\FacebookApps;

require __DIR__ . '/../vendor/autoload.php';

$app = new FacebookApps('568381760008564', 'd1b06621aa27a9cbbf70fbdd569c0d9d');
$app->requestAccessToken();