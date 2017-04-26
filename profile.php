<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];
echo "<br><br>";
var_dump($_SESSION);


$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

try {
  $response = $fb->get('/me?fields=name,first_name,last_name,email',$accessToken);
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

echo 'Logged in as ' . $userNode->getName();
echo 'ID : ' . $userNode->getID();
echo 'Email : ' . $userNode->getEmail();
echo 'First name : ' . $userNode->getFirstName();
echo 'Last name : ' . $userNode->getLastName();
echo '<br><br><br>';
echo $userNode; 
?>
</body>
</html>