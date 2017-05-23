<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','publish_actions','user_about_me','user_friends','user_posts']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://i-planted-a-tree.sites.innoraft.com/callback5.php', $permissions);

?>
<!DOCTYPE html>
<html>
<head>
	<title>TreePlant123</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/w3.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script type="text/javascript" src="scripts/js/homepage.js"></script>
  <style type="text/css">
    body{
      background-image: none;
    }
    .jumbo-display{
      width: 100%;
      display: block;
      margin-top : 130px;
      position: absolute;
      text-align: center;
      background-color: transparent;
      height: 350px;
      margin-bottom: 30px;
      background: rgba(255,255,255,0.8); /* For browsers that do not support gradients */
      background: -webkit-linear-gradient(left, rgba(0,0,0,0.8) , rgba(255,255,255,0.8)); /* For Safari 5.1 to 6.0 */
      background: -o-linear-gradient(right, rgba(0,0,0,0.1) , rgba(255,255,255,0.8)); /* For Opera 11.1 to 12.0 */
      background: -moz-linear-gradient(right, rgba(0,0,0,0.1) , rgba(255,255,255,0.8)); /* For Firefox 3.6 to 15 */
      background: linear-gradient(to right, rgba(0,0,0,0.1)  , rgba(255,255,255,0.8)); /* Standard syntax */
    }
    .jumbo-display h1{
      font-size: 70px;
      font-weight: bold;
      margin-bottom: 30px;
      color:#00aa00;
    }
    .jumbo-display p{
      margin-bottom: 70px;
      font-size: 30px;
      color:#00aa00;
    }
  </style>
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
        <li class="active"><a href="#">Home</a></li>
        <?php
          if(isset($_SESSION['facebook_access_token']))
            echo '<li><a href="profile.php">Profile</a></li>';
        ?>
        <li><a href="aboutus.php">About Us</a></li>
      </ul>
    </div>
  </div>
</div>
<img id="backgroundImage1" class="img-responsive" src="assets/images/plantingtrees10.jpg">
<img id="backgroundImage2" class="img-responsive" src="assets/images/treeplant.jpg">
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
        	<button class="hvr-fade btn-primary">
        		<i class="fa fa-facebook" aria-hidden="true">	
        		</i>
        		<?php echo '<a style="text-decoration:none;color:fff;" href="' . htmlspecialchars($loginUrl) . '">'.'Login With Facebook'.'</a>';?>
        	</button>
        </div>
      </footer>
    </div>
  </div>
</div>
<div class="jumbo-display">
  <h1>Innoraft Tree Plant Campaign</h1>
  <p>Plant trees and save the world</p>
  <div id="btn_wrapper">
  <button  id="btn_plant" onclick="document.getElementById('id01').style.display='block'">Let's Go</button>
</div>
</div>

<!--change -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/jquery">
	$("btn_plant").hover(function(){
    	$('#backgroundImage1').css("background-image", "assets/images/forest.jpg");
    }, function(){
    $(this).css("background-color", "pink");
});
</script>
</body>
</html>