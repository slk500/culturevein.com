<?php
require '../../app/bootstrap.php';

$fb = new \Facebook\Facebook([
    'app_id' => '',
    'app_secret' => '',
    'default_graph_version' => '',
    //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://culturevein.com/facebook-connect', $permissions);

$facebook_url =  htmlspecialchars($loginUrl);

echo $twig->render('login/register.twig', [
    'facebook_url' => $facebook_url
                                  ]);
?>