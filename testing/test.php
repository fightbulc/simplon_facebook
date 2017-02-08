<?php

use Simplon\Facebook\FacebookException;
use Simplon\Facebook\Page\FacebookPages;
use Simplon\Facebook\Photo\FacebookPhotos;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\User\FacebookUsers;

require 'common.php';

$user = new FacebookUsers($app, new FacebookPosts(), new FacebookPhotos());
$page = new FacebookPages($app, new FacebookPosts(), new FacebookPhotos());

try
{
    $user->setAccessToken('EAACEdEose0cBAK6Y5PPcRqZAoUKWOH2lFT9eH4Fi49iMuDtzSafZCKlx2qAZADezpS3irLwyB7WglxDcCSynLKFyarWYfFE6gVEIDQ1IdMvMJc8wqt2OsTl0BNNS5sh2rlkYTXnMzeGIvzCEfTmsq9uqDd5ADJ1E1OYdGZCRtQZDZD');

    var_dump(
        $user->getAccountsData()
    );
}
catch (FacebookException $e)
{
    var_dump($e->getDataArray());
}
