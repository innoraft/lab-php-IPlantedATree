<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<!--
<div class="navbar navbar-default navbar-static-top">
  <div class="container">
    <a href="#" class="navbar-brand">Treeplant</a>
    <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse navHeaderCollapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#">Item 1</a></li>
          <li><a href="#">Item 2</a></li>
          <li><a href="#">Item 3</a></li>
          <li><a href="#">Item 4</a></li>
        </ul>
    </div>
  </div>
</div>
-->

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
  $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
  $picture = $requestPicture->getGraphUser();
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
echo "<img src='".$picture['url']."'/>";
echo 'Logged in as ' . $userNode->getName();
echo 'ID : ' . $userNode->getID();
echo 'Email : ' . $userNode->getEmail();
echo 'First name : ' . $userNode->getFirstName();
echo 'Last name : ' . $userNode->getLastName();
echo '<br><br><br>';
echo $userNode; 

?>

<a href="http://treeplant123.com/post.php">POST</a>
</body>
</html>