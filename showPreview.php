<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

include('conn.php');
$contentId = $_GET['contentId'];
$sql = "SELECT * FROM `userContent` WHERE id='".$contentId."'";
$rs = $conn->query($sql);
$row = mysqli_fetch_array($rs);
$description = $row['description'];
$target_file = $row['picture_url'];

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
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script type="text/javascript" src="scripts/js/homepage.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
  <script type="text/javascript">
      var tagged_friends = '';
  </script>
  <script type="text/javascript" src="scripts/js/showPreview.js"></script>
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 40vh; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 30%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {
  padding: 10px 16px;
  font-size: 20px;
}

.modal-footer {
    padding: 10px 16px;
    background-color: #5cb85c;
}
#tag-friends{
  visibility : hidden;
}
#showPreview-submit{
  visibility: hidden;
}
</style>


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
  <div class="col-md-2 border profile-col-1" style="color: #fff;height: 100vh;padding-right: 0px;">
    <?php echo "<img id='profile_picture' class='outset' src='".$picture['url']."'/>";
          echo 'Welcome ' . $userNode->getName() . '!';
    ?>
  </div>
  <div class="col-md-10 border-negative profile-col-2" style="text-align: center;">
    <div id="profile_heading" style="position: relative;">Ready to POST?</div>
    <form id="uploadForm" action="upload.php" method="POST"> <!-- Upload form begins-->
      <div id="imageContainer">
        <img id="imagePreview" name="imagePreview" src="<?php echo $target_file; ?>" alt="your image" width="400" height="300" /><br>
      </div>
      <div id="profile_fileUploadButtons">
        <?php if(!empty($description)){ ?>
          <div style="height: auto;width:600px;margin:10px auto;padding: 10px;resize: none;color:#000;background-color: #fff;text-align: left;" id="description" name="description"><?php echo $description; ?></div><br>
          <?php 
              }
          else{ ?> 
            <div style="height: auto;width:50vw;margin:10px auto;padding: 10px;resize: none;color:#000;background-color: #fff;text-align: center;" id="description" name="description">No description given!</div><br>
          <?php
              }
           ?>
        <label id="lbl_tag_friends">Tag friends</label>
<?php
   
echo ' <input type="text" id="friends" list="taggable_friends">';
echo '<datalist id="taggable_friends">';
echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
while($count < $totalFriends){
  if($count == 0)
      $friendIDs =  $friends[$count]['id'].',';
  else if($count == $totalFriends-1)
      $friendIDs =  $friendIDs.$friends[$count]['id'];
  else
      $friendIDs =  $friendIDs.$friends[$count]['id'].',';

  // echo '<option id="'.$count.'" value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";

  echo '<option id="'.$count.'" value="'.$friends[$count]['name'].'"><img src="'.$friends[$count]['picture']['url'].'">'.$friends[$count]['name']."</option>";   
    
  $count++;
}
echo ' <!--[if lte IE 9]></select><![endif]-->';
echo '</datalist>';                                                                 
?>
      <br>
      <input type="hidden" id="tagged_friends" name="tagged_friends" value="X">
      <input class="btn myButton" id="showPreview-submit" type="submit" value="Upload Image">
    </form>
    <!-- <button style="color:#000;" id="btn_tag_friends">Tag friends</button> -->
    <!-- Upload form ends-->
    </div>
    <button id="myBtn" class="myButton" style="position: absolute;top: 550px;left: 500px;">Upload</button>
  </div>
</div>

<!-- Trigger/Open The Modal -->
<!-- <button id="myBtn">Upload</button> -->

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" style="text-align: center;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Tag friends</h2>
    </div>
    <div class="modal-body">
      <p>Do you want to tag your friends?</p>
    </div>
    <div class="modal-footer" style="color:#000;">
      <button id="yes">Yes</button>
      <button id="no">No</button>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
document.getElementById('yes').onclick = function(){
  modal.style.display = "none";
    document.getElementById('myBtn').style.display = "none";
    document.getElementById('friends').style.visibility = "visible";
    document.getElementById('tagged_friends').style.visibility = 'visible';
    document.getElementById('lbl_tag_friends').style.visibility = "visible";
    document.getElementById('showPreview-submit').style.visibility = "visible";
};
document.getElementById('no').onclick = function(){
  document.getElementById('uploadForm').submit();
};
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

