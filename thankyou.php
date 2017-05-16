<?php
session_start();
?>
<?php

require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');
$accessToken =  $_SESSION["facebook_access_token"];


try {
  $response = $fb->get('/me?fields=first_name',$accessToken);
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
$_SESSION['id'] = $userNode->getId();
$logoutUrl = 'https://www.facebook.com/logout.php?next=treeplant123.com&access_token='.$accessToken;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

	<style type="text/css">
		body{
			margin:0px;
			padding: 0px;
			background-image: url('assets/images/cartoon_forest.jpg');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		}
		#ty-plant{
			width:300px;
			height: 300px;
			margin: 0 auto;
			/*background-image: url('assets/images/thankyou2.jpg');*/
			background-size: cover;
			background-position: center;
			box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
		}
		.arch {
			margin: 60px 10px 0px;
  			font-size: 40px;
  			font-weight: bold;
  			margin-bottom: 40px;
  			text-align: center;
		}

		.arch span {
 			-webkit-background-clip: text;
  			color : #000;
  			text-shadow: 3px 3px 3px #fff;
		}

		.btn-custom{
			margin-top: 20px;
			border-radius: 0px;
			box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
		}
		#ty_container{
			background-color: rgba(255,255,255,.4);
		    border: 1px solid #000;
		    width: 840px;
		    height: auto;
		    margin: 10px auto 0;
		    padding:20px;
		}
	</style>
	<script type="text/javascript" src="scripts/js/arctext.js"></script>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="#" class="navbar-brand">Treeplant</a>
      <button class="navbar-toggle" data-toggle="collapse" data-target=".myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="<?php echo $_SESSION['logoutUrl'];?>">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<div id="ty_container">
<div class="arch">Thank you for your participation <?php echo $userNode['first_name'];?>.</div>
<div id="ty-plant" style="background-image:url('<?php echo $picture['url'];?>')">
<!-- <img src="<?php ?>"> -->
</div>
<div class="arch" style="margin-top: 10px;">Keep planting more trees!</div>
<script type="text/javascript">
	$(document).ready(function() {
  		$(".arch").arctext({radius: 1000});
	});
</script>
<div style="text-align: center;">
<a href="https://www.facebook.com/<?php echo $_SESSION['id'] ?>" target="_blank" style="text-decoration: none;color:#fff;">
<button type="button" class="btn btn-primary btn-lg btn-custom">
<i class="fa fa-facebook fa-lg" aria-hidden="true" style="margin-right: 20px;"></i><div style="height:100%;display: inline;border-right:1px solid #000;margin-right: 10px;"></div>Go to Facebook Profile Page</button></a>
</div>
</div>
<div style="color: #fff;">
<?php 
// unset($_SESSION['target_file']);
// unset($_SESSION['fileName']);
// unset($_SESSION['friends']);
?>
</div>
</body>
</html>