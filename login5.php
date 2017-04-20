<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$fb = new Facebook\Facebook([
			'app_id' => '1867029653544963',
			'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
			'default-graph_version' => 'v2.5'
		]);

$helper = $fb->getRedirectLoginHelper();
//echo ($_SESSION['FBRLH_' . 'state']);
$permissions = ['email','publish_actions','user_about_me','user_friends','user_posts']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://treeplant123.com/callback5.php', $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>