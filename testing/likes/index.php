<?php

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\Photo\FacebookPhotos;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\User\FacebookUsers;

require __DIR__ . '/../../vendor/autoload.php';

session_start();
$app = new FacebookApps('946621778709815', 'a0c4757bf2b23773c6fb5ac37c7eea50');
$app->requestAccessToken();

$user = new FacebookUsers($app, new FacebookPosts(), new FacebookPhotos());

if (!empty($_SESSION['token']))
{
    $user->setAccessToken($_SESSION['token']);
}

if (!$user->getAccessToken())
{
    if (empty($_GET['code']))
    {
        header('Location: ' . $user->getUrlAuthentication('http://open.dev/simplon_facebook/testing/likes', ['user_likes']));
        exit;
    }
    elseif (!empty($_GET['code']))
    {
        $user->requestAccessTokenByCode($_GET['code'], 'http://open.dev/simplon_facebook/testing/likes');
        $_SESSION['token'] = $user->getAccessToken();
    }
}

$likeData = $app->requestRawData('/me/likes', ['access_token' => $user->getAccessToken(), 'limit' => 100]);
$cards = [];

foreach ($likeData['data'] as $item)
{
    $cards[] = [
        'id'   => $item['id'],
        'name' => $item['name'],
        'img'  => 'https://graph.facebook.com/v2.9/' . $item['id'] . '/picture?redirect=1&width=200',
    ];
}

shuffle($cards);
$cards = array_slice($cards, 0, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link type="text/css" rel="stylesheet" href="memory.css">
</head>
<body>
<div class="wrap">
    <div class="game"></div>

    <div class="modal-overlay">
        <div class="modal">
            <h2 class="winner">You Rock!</h2>
            <button class="restart">Play Again?</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="memory.js"></script>
<script>
    (function () {
        Memory.init(<?= json_encode($cards) ?>);
    })();
</script>
</body>
</html>