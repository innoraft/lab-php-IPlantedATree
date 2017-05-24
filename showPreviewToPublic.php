<?php
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';

include('conn.php');
include('assets/config/fbCredentials.php');
$contentId = $_GET['contentId'];
$sql = "SELECT * FROM `userContent` WHERE id='".$contentId."'";
$rs = $conn->query($sql);
$row = mysqli_fetch_array($rs);
$description = $row['description'];
$target_file = $row['picture_url'];
$accessToken =  $_SESSION["facebook_access_token"];


try {
  $response = $fb->get('/me?fields=name,id,first_name,last_name,email',$accessToken);
  $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
  $picture = $requestPicture->getGraphUser();
  $userNode = $response->getGraphUser();
  $friends = $fb->get('/me/taggable_friends?fields=name,id,picture.width(50)',$accessToken); 
  $friends = $friends->getGraphEdge()->asArray();  
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
$_SESSION['friends'] = $friends;
$totalFriends = count($friends);
$count = 0;
$friendIDs = '';

?>
<!DOCTYPE html>
<html>
<head>
  <title>TreePlant123</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <script type="text/javascript" src="scripts/js/showPreview.js"></script>
    <style>

.btn-custom{
      margin-top: 20px;
      border-radius: 0px;
    }

.description1{
  height: auto;
  width:600px;
  margin:10px auto;
  padding: 10px;
  resize: none;
  color:#000;
  background-color: #fff;
  text-align: left;
}
.description2{
  height: auto;
  width:50vw;
  margin:10px auto;
  padding: 10px;
  resize: none;
  color:#000;
  background-color: #fff;
  text-align: center;
}

.share-button{
  height:100%;
  display: inline;
  border-right:1px solid #000;
  margin-right: 10px;
}
#myBtn{
  margin-bottom:20px;
}
.btn-mod{
  margin-top:-30px;
  margin-bottom: 30px;
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
        <li><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="<?php echo $_SESSION['logoutUrl'];?>">Logout</a></li>
      </ul>
    </div>
  </div>
</div>

<div  class="row" id="profile_row">
  <div class="col-md-12 border-negative profile-col-2 rem-padding-right">
    <div id="main-container" class="expandUp">
      <span>You can see people planting trees. So can you. Just click on the button below.</span>
      <div id="imageContainer">
        <img id="imagePreview" name="imagePreview" src="<?php echo $target_file; ?>" alt="your image" width="400" height="300" />
      </div>
      <div id="profile_fileUploadButtons">
        <?php if(!empty($description)){ ?>
          <div class="description1" id="description" name="description"><?php echo $description; ?></div><br>
          <?php 
              }
          else{ ?> 
            <div class="description2" id="description" name="description">No description given!</div><br>
          <?php
              }
           ?>
      </div>
      <a href="index.php"><button class="btn btn-lg btn-primary btn-mod">Post photos</button></a>
    </div>
  </div>
</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>

