<?php
session_start();
?>
<?php
include('conn.php');
require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');
$accessToken =  $_SESSION["facebook_access_token"];

if(isset($_SESSION['saveContentID'])){
  $_SESSION['saveContentID'] = NULL;
  unset($_SESSION['saveContentID']);
}

try {
  $response = $fb->get('/me?fields=name,id,first_name,last_name,email',$accessToken);
  // $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
  // $picture = $requestPicture->getGraphUser();
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
$name = $userNode->getName();
$userId = $userNode->getId();
// $sql = "INSERT INTO user IF NOT EXISTS values('$name','$userId','')";
// if($conn->query($sql))
  // echo "Updated";
// else
  // die($conn->error);

?>
<!DOCTYPE html>
<html>
<head>
  <title>TreePlant123</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet">
    <script type="text/javascript">
      var tagged_friends = '';
    </script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="scripts/js/profile.js"></script>
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
        <li class="active"><a href="#">Profile</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>

<div  class="row" id="profile_row">
  <div class="col-md-12 border-negative profile-col-2 rem-padding-right">
    <div id="main-container" class="expandUp">
      <span>Choose your image for uploading</span>
      <form id="uploadForm" action="saveContent.php" method="post" enctype="multipart/form-data">
      <div id="imageContainer">
        <img id="imagePreview" name="imagePreview" src="assets/images/placeholder.jpg" alt="your image" width="400" height="300" /><br>
      </div>
      <div id="profile_fileUploadButtons"><br>
        <label>Select image to Upload</label>
        <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
        <input type="hidden" name="fileName" value>
        <label for="message">Add an Image Description</label><br>
        <textarea placeholder="Enter image description here" id="description" name="description"></textarea><br>
        <br>
        <input type="hidden" id="tagged_friends" name="tagged_friends" value="X">
        <input type="reset" class="btn btn-primary btn-lg" name="Reset">
        <input id="submit" class="btn btn-primary btn-lg" type="submit" value="Save" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

