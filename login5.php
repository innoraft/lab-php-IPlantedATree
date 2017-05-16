<?php
session_start();
//$state = $_SESSION['state'] = md5(uniqid(rand(), TRUE));
//echo $state;
require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','publish_actions','user_about_me','user_friends','user_posts']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://treeplant123.com/callback5.php', $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>
