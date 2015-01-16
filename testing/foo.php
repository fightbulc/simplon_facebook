<?php

require __DIR__ . '/../vendor/autoload.php';
session_start();

//$userAccessToken = 'CAADDTZC7V0TEBAH1OoGIFmoV1fejPE2PqB8QiGEaQNbmx2ttYZCEE7zNzUHmqsJyZBHspXOg3DEwBxN5lv6MsZABl8jyADNAUE8xPyxyydd9Nd7awHJUz0zzfI24DeauDJD2NEfXhO9JBHq8AYlcZAoBqIBpX4AtFVrNmOsdbDvlaN7DWd8i8Imew5pSkDaUrCDgdOp1P7gZDZD';
//$pageAccessToken = 'CAADDTZC7V0TEBAPXG960A7AF1TSwbJVUK77NBYRAON7ohZChUejsbHtQ1eFJyZAATRqxAW2d8ONLdJweFOiO6v6RaaBCrE3hLUZCihVGe2saeCLNZAI325GdRpQRQZBnKnbPGqL5xnIcPU9WnezwXpImZBxRBFQYdFiil3rpSUCIHryJ6EZCh05uQ2lnR3Lb3eYZD';

// ##########################################

$facebookAuthVo = (new \Simplon\Facebook\Core\Vo\FacebookAuthVo())
    ->setAppId('690542844393444')
    ->setAppSecret('XXX');

$facebook = new \Simplon\Facebook\Core\Facebook($facebookAuthVo);

// ##########################################

if (isset($_GET['reset']) || (isset($_SESSION['userAccessToken']) === false && isset($_GET['code']) === false))
{
    echo '<a href="' . $facebook->getUrlLogin('http://open.dev/simplon_facebook/testing/foo.php', ['manage_pages']) . '">LOGIN</a>';
}
else
{
    if (isset($_GET['code']))
    {
        $_SESSION['userAccessToken'] = $facebook->requestUserAccessTokenByCode($_GET['code'], 'http://open.dev/simplon_facebook/testing/foo.php');
        header('Location: http://open.dev/simplon_facebook/testing/foo.php');
    }
}

if (empty($_GET))
{
    echo '<strong>UserAccessToken: ' . $_SESSION['userAccessToken'] . '</strong>';

    $facebook->setUserAccessToken($_SESSION['userAccessToken']);

    $facebookUsers = new \Simplon\Facebook\User\FacebookUsers($facebook);

    echo '<ul>';
    foreach ($facebookUsers->getAccountsData() as $facebookUserAccountVo)
    {
        echo '<li>';
        echo '<pre>';
        print_r($facebookUserAccountVo->getAccessToken());
        echo '</pre>';
        echo '</li>';
    }
    echo '</ul>';
}