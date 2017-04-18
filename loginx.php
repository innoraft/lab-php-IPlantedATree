<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1867029653544963',
	'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
	'default-graph_version' => 'v2.5'
  ]);

$helper = $fb->getRedirectLoginHelper();

// app directory could be anything but website URL must match the URL given in the developers.facebook.com/apps
define('APP_URL', 'http://treeplant123.com/loginx.php');

$permissions = ['publish_actions', 'user_friends']; // optional

try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();

  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }

if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	// if (isset($_GET['code'])) {
	// 	header('Location: ./');
	// }

	// validating user access token
	try {
		$user = $fb->get('/me');
		$user = $user->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// if access token is invalid or expired you can simply redirect to login page using header() function
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// getting all friends of user
	$friends = $fb->get('/me/taggable_friends');
	$friends = $friends->getGraphEdge()->asArray();

	// getting random friend out of all friends
	$totalFriends = count($friends);
	$random = rand(0, $totalFriends);
	$random1 = rand(0, $totalFriends);
	$random2 = rand(0, $totalFriends);

	// tag a friend in a photo
	$uploadPhoto = $fb->post("/me/photos", array('url' => ''));
	$uploadPhoto = $uploadPhoto->getGraphNode()->asArray();
	$tagInPhoto = $fb->post('/' . $uploadPhoto['id'] . '/tags', array('tag_uid' => $friends[$random]['id']));

	// tag multiple friends in a photo
	$tags = [];
	$tag['tag_uid'] = $friends[$random]['id'];
	$tags[] = $tag;
	$tag['tag_uid'] = $friends[$random1]['id'];
	$tags[] = $tag;
	$tag['tag_uid'] = $friends[$random2]['id'];
	$tags[] = $tag;

	//$uploadPhoto = $fb->post("/me/photos", array('url' => 'https://pbs.twimg.com/profile_images/762704058243219457/aLbu-kMF.jpg'));
	//$uploadPhoto = $uploadPhoto->getGraphNode()->asArray();
	//$tagInPhoto = $fb->post('/' . $uploadPhoto['id'] . '/tags', array('tags' => $tags));

  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl(APP_URL, $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}