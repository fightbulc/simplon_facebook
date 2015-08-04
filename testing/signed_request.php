<?php

use Simplon\Facebook\Core\FacebookRequests;

require __DIR__ . '/../vendor/autoload.php';

$appSecret = '';
$signedRequest = '';

$data = FacebookRequests::parseSignedRequest($appSecret, $signedRequest);

var_dump($data->getUserId());