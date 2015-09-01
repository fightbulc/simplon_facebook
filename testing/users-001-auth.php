<?php

use Simplon\Facebook\FacebookException;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\User\FacebookUsers;

require 'common.php';

$options = getopt('c:i:e:a:d:');

$urlCallback = 'https://play-facebook.ngrok.io/';
$user = new FacebookUsers($app, new FacebookPosts());

try
{
    // auth with code
    if (empty($options['c']) === false)
    {
        $user->requestAccessTokenByCode($options['c'], $urlCallback);
        var_dump($app->getDebugTokenVo($user->getAccessToken()));
    }

    // token info
    elseif (empty($options['i']) === false)
    {
        var_dump($app->getDebugTokenVo($options['i'])->isShortTermToken());
    }

    // long term
    elseif (empty($options['e']) === false)
    {
        $user->setAccessToken($options['e'])->requestLongTermAccessToken();
        var_dump($app->getDebugTokenVo($user->getAccessToken()));
    }

    // fetch user data
    elseif (empty($options['d']) === false)
    {
        var_dump($user->setAccessToken($options['d'])->getUserData()->getFullName());
    }

    // built auth url
    else
    {
        var_dump($user->getUrlAuthentication($urlCallback));
    }
}
catch (FacebookException $e)
{
    var_dump($e->getDataArray());
}
