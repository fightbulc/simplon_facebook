<?php

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\User\FacebookUsers;

require __DIR__ . '/../vendor/autoload.php';

// curl -i -X GET \
// "https://graph.facebook.com/v3.0/100027081525915/picture?redirect=false&access_token="

$appId = '170091487020701';
$appSecret = 'f941c52eec4303c7cd5b240c735dade1';
$accessToken = 'EAACasoKpxp0BAN0qW7OoznfkwzND6sUkbMch5k7vwZAKCWGO1W4qNtnRVxgD0JVT97YbZAoHfa0gzGeWJyA8MSZAoCZATsPoMfiVzaFyulYeG5psUiJXtCYZAFZC34sO4AfHYvdZCkzRgtW3EyRoFWMX0EqyFkUP8axTRTnyueAp3MiDdfavkK3ETotfSnguuoM3dZCBUsDmthy4418D3xGLRobh8DPgxY48oi0nmu3ZAIwZDZD';

$app = new FacebookApps($appId, $appSecret);
$app->requestAppAccessToken();

$user = new FacebookUsers($app);

try
{
    die(var_dump(
        $user->setAccessToken($accessToken)->getUserData()->toArray()
    ));
}
catch (\Simplon\Facebook\FacebookException $e)
{
    die(var_dump($e->getDataArray()));
}
catch (\Simplon\Request\RequestException $e)
{
}