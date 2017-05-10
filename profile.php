<?php
session_start();
?>
<?php

require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];


$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

try {
  $response = $fb->get('/me?fields=name,id,first_name,last_name,email',$accessToken);
  $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
  $picture = $requestPicture->getGraphUser();
  $userNode = $response->getGraphUser();
  // $friends = $fb->get('/me/taggable_friends?fields=name,id,picture.width(50)',$accessToken); 
  // $friends = $friends->getGraphEdge()->asArray();  
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
// $_SESSION['friends'] = $friends;
// $totalFriends = count($friends);
// $count = 0;
// $friendIDs = '';



// echo "<img src='".$picture['url']."'/>";
// echo 'Logged in as ' . $userNode->getName();
// echo 'ID : ' . $userNode->getID();
// echo 'Email : ' . $userNode->getEmail();
// echo 'First name : ' . $userNode->getFirstName();
// echo 'Last name : ' . $userNode->getLastName();
// echo '<br><br><br>';
// echo $userNode; 

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
    <script type="text/javascript">
      var tagged_friends = '';
    </script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="scripts/js/profile.js"></script>
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
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#">Profile</a></li>
        <li><a href="#">XYZ</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="<?php echo $_SESSION['logoutUrl'];?>">Logout</a></li>
      </ul>
    </div>
  </div>
</div>

<div  class="row" id="profile_row">
  <div class="col-md-2 border profile-col-1">
    <?php echo "<img id='profile_picture' class='outset' src='".$picture['url']."'/>";
          echo '<div style="color:#fff;margin-top:10px;font-size:20px;">Welcome<br> ' . $userNode->getName() . '!</div>';
    ?>
  </div>
  <div class="col-md-10 border-negative profile-col-2">
    <div id="profile_heading">Upload Your Challenge Photo!</div>
    <form id="uploadForm" action="saveContent.php" method="post" enctype="multipart/form-data">
    <div id="imageContainer">
      <img id="imagePreview" name="imagePreview" src="assets/images/placeholder.jpg" alt="your image" width="400" height="300" /><br>
    </div>
    <div id="profile_fileUploadButtons"><br>
      <label>Select image to Upload</label>
      <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
      <input type="hidden" name="fileName" value>
      <label for="message">Image Description</label><br>
      <textarea placeholder="Enter image description here" id="description" name="description"></textarea><br>
      <!-- <label>Tag friends</label> -->
      <br>
      <input type="hidden" id="tagged_friends" name="tagged_friends" value="X">
      <!-- <input type="button" id="save" name="save" value="Save"> -->
      <input type="reset" class="myButton" name="Reset">
      <input id="submit" class="myButton" type="submit" value="Save" name="submit">
    </div>
    </form>
  </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

