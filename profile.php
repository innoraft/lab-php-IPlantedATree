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
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
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
      </ul>
    </div>
  </div>
</div>


<div id="profile_main_body">
  <div class="container">
    <?php echo "<img style='width:100%;height:40%;' src='".$picture['url']."'/>";
          echo 'Logged in as ' . $userNode->getName();
    ?>
  </div>
  <div id="profile_upload_area">
    <div>Upload Your Challenge Photo!</div>
    <div>
      <form action="upload.php" method="post" enctype="multipart/form-data">
      <label>Select image to Upload</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <img id="imagePreview" src="assets/images/placeholder.jpg" alt="your image" width="200" height="200" style="display: inline;" />
        <label for="message">Image Description</label>
        <textarea placeholder="Enter image description here" name="description"></textarea>
        <input type="hidden" name="fileName" value>
        <input type="submit" value="Upload Image" name="submit">
      </form>
      <script type="text/javascript">
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            /*input.files[0].name; //displays the filename*/
          }
        }

        $("#fileToUpload").change(function(){
          readURL(this);
        });
      </script>
    </div>
  </div>
</div>
<!-- <a href="http://treeplant123.com/post.php">POST</a> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

