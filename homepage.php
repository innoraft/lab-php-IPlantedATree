<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$fb = new Facebook\Facebook([
			'app_id' => '1867029653544963',
			'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
			'default-graph_version' => 'v2.5'
			// ,'state' => $state
		]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','publish_actions','user_about_me','user_friends','user_posts']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://treeplant123.com/callback5.php', $permissions);

?>
<!DOCTYPE html>
<html>
<head>
	<title>TreePlant123</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/w3.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	<script type="text/javascript" src="scripts/js/homepage.js"></script>
</head>
<body>


<div class="navbar navbar-default navbar-fixed-top">
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
        <li class="active"><a href="#">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="#">XYZ</a></li>
        <li><a href="#">About Us</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="w3-container">
   <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Login</h2>
      </header>
      <div class="w3-container">
        <p>Please login with Facebook to continue!</p>
      </div>
      <footer class="w3-container w3-teal">
        <div class="align-center">
        	<button class="hvr-fade">
        		<i class="fa fa-facebook" aria-hidden="true">	
        		</i>
        		<?php echo '<a href="' . htmlspecialchars($loginUrl) . '">'.'Login With Facebook'.'</a>';?>
        	</button>
        </div>
      </footer>
    </div>
  </div>
</div>

<img id="backgroundImage1" class="img-responsive" src="assets/images/plantingtrees10.jpg">
<img id="backgroundImage2" class="img-responsive" src="assets/images/treeplant.jpg">
<div id="btn_wrapper">
	<button  id="btn_plant" onclick="document.getElementById('id01').style.display='block'">Let's Plant Some Trees</button>
</div>
<!--change -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- <script type="text/jquery" src="scripts/js/homepage.js"></script> -->

</body>
</html>