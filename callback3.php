<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
session_start();?>
<html>
<head>
  <script>FB.ui({
  method: 'feed',
  link: 'https://developers.facebook.com/docs/',
  caption: 'An example caption',
}, function(response){});</script>
</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
else{
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);
$fb->setDefaultAccessToken($accessToken);
if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

try{

  $logoutUrl = $helper->getLogoutUrl($accessToken,"http://treeplant123.com/login1.php");

}catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
echo "<br><br><br><br><br>";

// try {
//   $response = $fb->get('/me?fields=name,first_name,last_name,email');
//   $userNode = $response->getGraphUser();
// } catch(Facebook\Exceptions\FacebookResponseException $e) {
//   // When Graph returns an error
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(Facebook\Exceptions\FacebookSDKException $e) {
//   // When validation fails or other local issues
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }

// echo 'Logged in as ' . $userNode->getName();
// echo 'ID : ' . $userNode->getID();
// echo 'Email : ' . $userNode->getEmail();
// echo 'First name : ' . $userNode->getFirstName();
// echo 'Last name : ' . $userNode->getLastName();
// echo '<br><br><br>';
// echo $userNode; 
// $str = $userNode->all();
// print_r $str;
// posting on user timeline using publish_actins permission
  
  // getting all friends of user
  $friends = $fb->get('/me/taggable_friends'); 
  $friends = $friends->getGraphEdge()->asArray();
  /*The above result is returned in the form of an associative array.
  Eg. $friends[0] => ['id' => 'adsawdqweqwe123' , 'name' => 'Voeoqej AjkJDSAK']
      $friends[1] => ['id' => 'getgre233123fde' , 'name' => 'Fsdawc']
  */
  $totalFriends = count($friends);
  $count = 0;
  $friendIDs = '';
  ?>
  <select>
  <?php
  while($count < $totalFriends){
    if($count == 0)
      $friendIDs =  $friends[$count]['id'].',';
    else if($count == $totalFriends-1)
      $friendIDs =  $friendIDs.$friends[$count]['id'];
    else
      $friendIDs =  $friendIDs.$friends[$count]['id'].',';
    // try {
    //   // Returns a `Facebook\FacebookResponse` object
    //    $get = '/'.$friends[$count]['id'].'?fields=id,name';
    //    $response = $fb->get($get,$accessToken);
    // } catch(Facebook\Exceptions\FacebookResponseException $e) {
    //   echo 'Graph returned an error: ' . $e->getMessage();
    //   exit;
    // } catch(Facebook\Exceptions\FacebookSDKException $e) {
    //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
    //   exit;
    // }
    //$user = $response->getGraphUser();
    //echo '<option value="'.$user['name'].'">'.$user['name']."</option>";
    echo '<option value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";
    $count++;
  }
  ?>
  </select>
  <?php
  $msg = ['message' => 'Yo11', 'tags' => $friendIDs];
  // posting on facebook and tagging friend with it
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed', $msg);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Posted with id: ' . $graphNode['id'];
?>

</body>
</html>