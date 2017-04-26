<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
session_start();?>
<html>
<head>
  <title>Treeplant</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
// if (isset($_GET['state'])) {
//     $helper->getPersistentDataHandler()->set('state', $_GET['state']);
// }
//$_SESSION['FBRLH_state']=$_GET['state'];
// $_SESSION['FBRLH_state']=$_GET['state']; 
//echo ($_SESSION['FBRLH_' . 'state']);
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
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);
$fb->setDefaultAccessToken($accessToken);
if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  //echo '<h3>Long-lived</h3>';
  //var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

try{

  $logoutUrl = $helper->getLogoutUrl($accessToken,"http://treeplant123.com/login5.php");

}catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
echo "<br><br><br><br><br>";

/*New changes 21/4/17 begin*/

  try {
    $profile_request = $fb->get('/me?fields=name,id');
    $profile = $profile_request->getGraphNode()->asArray();
    $friends = $fb->get('/me/taggable_friends?fields=name,id'); 
    $friends = $friends->getGraphEdge()->asArray();
    $requestPicture = $fb->get('/me/picture?redirect=false&height=300');
    $picture = $requestPicture->getGraphUser();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    session_destroy();
    // redirecting user back to app login page
    header("Location: ./");
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  
  include('conn.php');
  $name = $profile['name'];
  $id = $profile['id'];
  $file = file_get_contents($picture['url']);
  $path = "assets/uploads";
  $path .= "/".$id."prof_pic.jpg";
  $totalFriends = count($friends);
  file_put_contents($path, $file);
  //var_dump($file);
  $sql = "INSERT INTO `user` values('$name','$id','$path')";
  if($conn->query($sql))
    echo "Successful insertion";
  else
    echo "Unsuccessful insertion";
  $i = 0;
  $sql = "";
  for($i=0 ; $i<$totalFriends ; $i++){
    $friendID = $friends[$i]['id'];
    $link = "http://treeplant.com/visit.php?link=".$id.'_'.$friendID;
    if($i == 0)
      $sql = "INSERT INTO `invitation` values('$id','$friendID',0,'$link')";
    else
      $sql .= ",('$id','$friendID',0,'$link')";

    echo "<br><br>".$sql."<br><br>";
    if($conn->query($sql))
      echo "Successful insertion 2";
    else
      echo "Unsuccessful insertion 2";
  }
  $conn->close();


  // // get basic page info
  // $page = $fb->get('/funnydemons?fields=username,picture.width(500),cover,');
  // $page = $page->getGraphNode()->asArray();

  // echo "<img src='{$page['cover']['source']}'>";


/*New changes 21/4/17 end*/

  
  // getting all friends of user
  
  /*The above result is returned in the form of an associative array.
  Eg. $friends[0] => ['id' => 'adsawdqweqwe123' , 'name' => 'Voeoqej AjkJDSAK']
      $friends[1] => ['id' => 'getgre233123fde' , 'name' => 'Fsdawc']
  */
  
  $count = 0;
  $friendIDs = '';
   
  echo ' <input type="text" id="default" list="taggable_friends">';
  echo '<datalist id="taggable_friends">';
  echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
  while($count < $totalFriends){
    if($count == 0)
      $friendIDs =  $friends[$count]['id'].',';
    else if($count == $totalFriends-1)
      $friendIDs =  $friendIDs.$friends[$count]['id'];
    else
      $friendIDs =  $friendIDs.$friends[$count]['id'].',';

    echo '<option value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";
    

    $count++;
  }
  echo ' <!--[if lte IE 9]></select><![endif]-->';
  echo '</datalist>';
   $link = "http://treeplant123.com/login5.php?link=".$id;
  $msg = ['message' => 'Yo111111SEWYSTQQGHIJKLMNOPQRSTUVWXYZ','link' => $link ,'tags' => $friendIDs];
  // posting on facebook and tagging friend with it
// try {
//   // Returns a `Facebook\FacebookResponse` object
  
// } catch(Facebook\Exceptions\FacebookResponseException $e) {
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(Facebook\Exceptions\FacebookSDKException $e) {
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }
$response = $fb->post('/me/feed', $msg);
$graphNode = $response->getGraphNode();
echo "<img src='".$path."'/>";
echo 'Posted with id: ' . $graphNode['id'];
echo '<a href="' . htmlspecialchars($logoutUrl) . '">Logout</a>';
?>
<br><br>
<a href="changes.txt">changes.txt</a>
<br><br>
<?php 
// var_dump($helper->getPersistentDataHandler());
// echo "<br>GET";
// var_dump($_GET);
// echo "<br>SESSION";
// var_dump($_SESSION);
?>
<script src="scripts/js/datalist.polyfill.min.js"></script>
<script src="scripts/js/datalist.js"></script>
</body>
</html>
