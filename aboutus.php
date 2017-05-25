<?php
session_start();
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
        <?php if(isset($_SESSION['facebook_access_token'])) 
          echo '<li><a href="profile.php">Profile</a></li>';
          echo '<li><a href="post.php">Post</a></li>';
        ?>
        <li><a href="gallery.php">Gallery</a></li>
        <li class="active"><a href="aboutus.php">About Us</a></li>
        <?php if(isset($_SESSION['facebook_access_token'])) 
          echo '<li><a href="logout.php">Logout</a></li>';
        ?>
      </ul>
    </div>
  </div>
</div>
</body>
</html>