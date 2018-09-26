<?php
require '../../app/bootstrap.php';
$msg = NULL;

if(isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

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

                      
echo $twig->render('login/login.twig', [
    'msg' => $msg,
    'facebook_url' => $facebook_url
                                  ]);
?>
