<?php

use Simplon\Facebook\Objects\FacebookObjects;

require 'common.php';

$objects = new FacebookObjects($app);
var_dump($objects->createCrawl('http://gimmemore.com/en/test/result/7T7AP1CQJXSN'));